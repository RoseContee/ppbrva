import Axios from 'axios';
import RNFetchBlob from 'rn-fetch-blob';
import store from '../store';

// const SERVER_URL = 'http://192.168.100.30/ppbrva/public';
const SERVER_URL = 'https://app.ppbrva.com';

const BASE_URL = `${SERVER_URL}/api/app`

const axios = Axios.create({
	baseURL: `${BASE_URL}`,
});

axios.interceptors.request.use(config => {
  const access_token = store.getState().user.access_token;
  config.headers.Authorization = `Bearer ${access_token}`;
  return config;
});

export const downloadInvoice = (invoiceID: string) => {
  const access_token = store.getState().user.access_token;
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
    Authorization : `Bearer ${access_token}`,
    Accept: 'application/json',
  });
};

export const getErrorMessage = (error: any, defaultMessage?: string) => {
  let message;
  if (!error.response) {
    message = 'There is a problem with your network. Check your network connection.';
  } else if (!error.response.data || !error.response.data.message) {
    message = defaultMessage || 'Something went wrong.';
  } else {
    message = error.response.data.message;
  }
  return message;
};

export default axios;
