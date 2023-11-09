import { createSlice } from '@reduxjs/toolkit';
import { RootState } from '.';

export interface IEventProps {
  id: string
  image: string
  date: string
  title: string
  link: string
}

interface StateProps {
  events: IEventProps[],
}

const initialState: StateProps = {
  events: [],
};

const settingsSlice = createSlice({
  name: 'events',
  initialState: initialState,
  reducers: {
    saveEvents(state, action) {
      state.events = action.payload;
    },
  },
});

export const { saveEvents } = settingsSlice.actions;
export const getEvents = (state: RootState) => state.events.events;

export default settingsSlice.reducer;
