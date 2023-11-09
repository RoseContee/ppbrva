import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

interface StateProps {
  access_token: string | null,
  me: any
}

const initialState: StateProps = {
  access_token: null,
  me: null,
};

const userSlice = createSlice({
  name: 'user',
  initialState: initialState,
  reducers: {
    saveAccessToken(state, action) {
      state.access_token = action.payload;
    },
    saveMe(state, action) {
      state.me = action.payload;
    },
  },
});

export const { saveAccessToken, saveMe } = userSlice.actions;
export const getMe = (state: RootState) => state.user.me || {};
export const getProfile = (state: RootState) => (state.user.me || {}).profile || {};
export const getPlan = (state: RootState) => (state.user.me || {}).plan || {};
export const getLocation = (state: RootState) => (state.user.me || {}).location || {};
export const getName = (state: RootState) => (state.user.me || {}).name;

export default userSlice.reducer;
