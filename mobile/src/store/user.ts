import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

interface StateProps {
  access_token: string | null,
  me: any
};

const initialState: StateProps = {
  access_token: null,
  me: null,
};

const userSlice = createSlice({
  name: 'user',
  initialState: initialState,
  reducers: {
    SaveAccessToken(state, action) {
      state.access_token = action.payload;
    },
    SaveMe(state, action) {
      state.me = action.payload;
    },
  },
});

export const { SaveAccessToken, SaveMe } = userSlice.actions;
export const getMe = (state: RootState) => state.user.me || {};
export const getProfile = (state: RootState) => (state.user.me || {}).profile || {};
export const getPlan = (state: RootState) => (state.user.me || {}).plan || {};
export const getLocation = (state: RootState) => (state.user.me || {}).location || {};

export default userSlice.reducer;
