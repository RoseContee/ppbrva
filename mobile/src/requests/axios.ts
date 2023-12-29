import Axios from 'axios';
import RNFetchBlob from 'rn-fetch-blob';
import store, { dispatch } from '../store';
import { setLoggedIn } from '../store/settings';

// const SERVER_URL = 'http://192.168.100.30/ppbrva/public';
const SERVER_URL = 'https://app.ppbrva.com';

const BASE_URL = `${SERVER_URL}/api/app`

const axios = Axios.create({
	baseURL: `${BASE_URL}`,
});

axios.interceptors.request.use(config => {
  config.headers.Authorization = `Bearer ${store.getState().settings.access_token}`;
  return config;
});
axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status == 401) {
      dispatch(setLoggedIn(false));
    }
    return Promise.reject(getErrorMessage(error));
  }
);

const getErrorMessage = (error: any, defaultMessage?: string) => {
  let message;
  if (!error.response) {
    message = 'There is a problem with your network. Check your network connection.';
  } else if (!error.response.data || !error.response.data.message) {
    message = defaultMessage || 'Something went wrong.';
  } else {
    message = error.response.data.message;
  }
  return message;
}

export const downloadInvoice = (invoiceID: string) => {
  return RNFetchBlob.config({
    addAndroidDownloads : {
      useDownloadManager : true,
      notification : true,
      title : 'Invoice Downloading...',
      description : 'Downloading an invoice from ppbrva',
      mime : 'application/pdf',
      path: `${RNFetchBlob.fs.dirs.DownloadDir}/${invoiceID}.pdf`,
    }
  }).fetch('GET', `${BASE_URL}/invoices/${invoiceID}/download`, {
    Authorization : `Bearer ${store.getState().settings.access_token}`,
    Accept: 'application/json',
  });
}

export default axios;
