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
export const getMe = (state: RootState) => state.user.me || {profile: {}, plan: {}, location: {}};

export default userSlice.reducer;
