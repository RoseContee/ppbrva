import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

interface DashboardProps {
  play_icon: string,
  play_link: string,
  improve_icon: string,
  improve_link: string,
  rent_icon: string,
  rent_link: string,
  shop_icon: string,
  shop_link: string,
}

interface SocialProps {
  social1_icon: string,
  social1_link: string,
  social2_icon: string,
  social2_link: string,
  social3_icon: string,
  social3_link: string,
}

interface StateProps {
  loggedIn: boolean,
  access_token: string | null,
  dashboard: DashboardProps,
  social: SocialProps,
}

const initialState: StateProps = {
  loggedIn: true,
  access_token: null,
  dashboard: {} as DashboardProps,
  social: {} as SocialProps,
}

const settingsSlice = createSlice({
  name: 'settings',
  initialState: initialState,
  reducers: {
    setLoggedIn(state, action) {
      state.loggedIn = action.payload;
    },
    saveAccessToken(state, action) {
      state.access_token = action.payload;
    },
    saveDashboard(state, action) {
      state.dashboard = action.payload;
    },
    saveSocial(state, action) {
      state.social = action.payload;
    },
  },
});

export const {
  setLoggedIn, saveAccessToken, saveDashboard, saveSocial
} = settingsSlice.actions;
export const getLoggedIn = (state: RootState) => state.settings.loggedIn;
export const getAccessToken = (state: RootState) => state.settings.access_token;
export const getDashboard = (state: RootState) => state.settings.dashboard;
export const getSocial = (state: RootState) => state.settings.social;

export default settingsSlice.reducer;
