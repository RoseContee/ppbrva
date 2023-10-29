import Axios from 'axios';
import store from '../store';

const SERVER_URL = 'http://192.168.137.100/ppbrva/public';
// const SERVER_URL = 'https://app.ppbrva.com';

const axios = Axios.create({
	baseURL: `${SERVER_URL}/api/app`,
});

axios.interceptors.request.use(config => {
  const access_token = store.getState().user.access_token;
  config.headers.Authorization = `Bearer ${access_token}`;
  return config;
});

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
