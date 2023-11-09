import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

interface StateProps {
  appicons: {
    play?: string,
    improve?: string,
    rent?: string,
    shop?: string,
  }
}

const initialState: StateProps = {
  appicons: {},
};

const settingsSlice = createSlice({
  name: 'settings',
  initialState: initialState,
  reducers: {
    saveAppicons(state, action) {
      state.appicons = action.payload;
    },
  },
});

export const { saveAppicons } = settingsSlice.actions;
export const getPlayIcon = (state: RootState) => state.settings.appicons.play;
export const getImproveIcon = (state: RootState) => state.settings.appicons.improve;
export const getRentIcon = (state: RootState) => state.settings.appicons.rent;
export const getShopIcon = (state: RootState) => state.settings.appicons.shop;

export default settingsSlice.reducer;
