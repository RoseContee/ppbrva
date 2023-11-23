import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

interface StateProps {
  dashboard: {
    icons: {
      play?: string,
      improve?: string,
      rent?: string,
      shop?: string,
    },
    links: {
      play_link?: string,
      improve_link?: string,
      rent_link?: string,
      shop_link?: string,
    }
  }
}

const initialState: StateProps = {
  dashboard: {
    icons: {},
    links: {},
  },
};

const settingsSlice = createSlice({
  name: 'settings',
  initialState: initialState,
  reducers: {
    saveDashboard(state, action) {
      state.dashboard = action.payload;
    },
  },
});

export const { saveDashboard } = settingsSlice.actions;
export const getDashboardIcons = (state: RootState) => (state.settings.dashboard || {}).icons;
export const getDashboardLinks = (state: RootState) => (state.settings.dashboard || {}).links;

export default settingsSlice.reducer;
