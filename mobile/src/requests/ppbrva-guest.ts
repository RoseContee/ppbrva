import axios from './axios';
import { dispatch } from '../store';
import { saveAccessToken, setLoggedIn } from '../store/settings';
import { MeProps, saveMe } from '../store/user';
import { saveStorage } from '../utils/storage';

export const postLogin = (data: any) => {
  return new Promise((resolve: (user: MeProps) => void, reject) => {
    axios.post(`/login`, data)
      .then(({ data: { access_token, user } }) => {
        saveStorage('access_token', access_token);
        dispatch(setLoggedIn(true));
        dispatch(saveAccessToken(access_token));
        dispatch(saveMe(user));
        resolve(user);
      })
      .catch(error => reject(error));
  });
}

export const postForgotPassword = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/forgot-password`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postVaildateCode = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/validate-code`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}

export const postResetPassword = (data: any) => {
  return new Promise((resolve, reject) => {
    axios.post(`/reset-password`, data)
      .then(() => resolve(true))
      .catch(error => reject(error));
  });
}