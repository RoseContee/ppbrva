import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

export interface MeProps {
  id: number,
  memberID: string,
  firstname: string,
  lastname: string,
  name: string,
  email: string,
  original_pass: boolean,
  phone: string,
  gender: string,
  dob: string,
  address: string,
  city: string,
  state: string,
  zipcode: string,
  avatar: string,
  card_type: string,
  card_last4: string,
  status: string,
  is_child: boolean,
  profile: {
    share_age_gender: boolean,
    dupr_id: string,
    dupr_link: string,
    gender: string,
    age: string,
    rating: number,
    matches: number,
    wins: number,
    losses: number,
  },
}

interface LocationProps {
  name: string,
  address: string,
  lat: number,
  lng: number,
  phone: string,
  email: string,
  website: string,
  image: string,
}

interface PlanProps {
  id: string,
  name: string,
  family: boolean,
}

interface StateProps {
  me: MeProps,
  location: LocationProps,
  plan: PlanProps,
}

const initialState: StateProps = {
  me: {} as MeProps,
  location: {} as LocationProps,
  plan: {} as PlanProps,
}

const userSlice = createSlice({
  name: 'user',
  initialState: initialState,
  reducers: {
    saveMe(state, action) {
      state.me = action.payload;
    },
    saveLocation(state, action) {
      state.location = action.payload;
    },
    savePlan(state, action) {
      state.plan = action.payload;
    },
  },
});

export const { saveMe, saveLocation, savePlan } = userSlice.actions;
export const getMe = (state: RootState) => state.user.me;
export const getLocation = (state: RootState) => state.user.location;
export const getPlan = (state: RootState) => state.user.plan;

export default userSlice.reducer;
