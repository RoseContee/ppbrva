import React, { FC } from 'react';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import Header from '../components/layouts/header';
import BottomTabs from '../components/layouts/bottom-tabs';

import Dashboard from '../screens/dashboard';
import Activity from '../screens/activity';
import Friends from '../screens/friends';
import Events from '../screens/events';
import ProfileStack from './profile-stack';

import ClubInfo from '../screens/club-info';
import MembersStack from './members-stack';
import KitchenBar from '../screens/kitchen-bar';

const Tab = createBottomTabNavigator();
const TabStack: FC = (): JSX.Element => {
  return (
    <Tab.Navigator initialRouteName="Dashboard" screenOptions={{header: Header}} tabBar={BottomTabs}>
      <Tab.Screen name="Dashboard" component={Dashboard} options={{title: 'Dashboard'}} />
      <Tab.Screen name="Activity" component={Activity} options={{title: 'Activity'}} />
      <Tab.Screen name="Friends" component={Friends} options={{title: 'Friends'}} />
      <Tab.Screen name="Events" component={Events} options={{title: 'Events'}} />
      <Tab.Screen name="ProfileScreen" component={ProfileStack} options={{headerShown: false}} />

      <Tab.Screen name="ClubInfo" component={ClubInfo} options={{title: 'Club Info'}} />
      <Tab.Screen name="MembersScreen" component={MembersStack} options={{headerShown: false}} />
      <Tab.Screen name="KitchenBar" component={KitchenBar} options={{title: 'Kitchen/Bar'}} />
    </Tab.Navigator>
  );
};

export default TabStack;
