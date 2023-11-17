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

export const { saveAppicons } = settingsSlice.actions || {};
export const getAppicons = (state: RootState) => state.settings.appicons;

export default settingsSlice.reducer;
