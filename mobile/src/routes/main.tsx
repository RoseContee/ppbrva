import React, { FC } from 'react';
import { BottomTabNavigationOptions, createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import HeaderOptions, { HideLeftButton } from '../components/header-options';
import BottomTabs from '../components/bottom-tabs';

import Dashboard from '../screens/dashboard';
import Activity from '../screens/activity';
import Events from '../screens/events';
import {
  Profile, MemberProfile, BillingProfile, MembershipPlan
} from '../screens/profile';
import ClubInfo from '../screens/club-info';
import {
  Members, MemberInvite, FriendRequest, AcceptedFriend
} from '../screens/members';
import KitchenBar from '../screens/kitchen-bar';
import InvoiceScreen from './invoice';


export const mainRoutes = {
  Dashboard: 'Dashboard',
  Activity: 'Activity',
  Friends: 'Friends',
  AcceptedFriend: 'AcceptedFriend',
  PendingRequests: 'PendingRequests',
  FriendRequest: 'FriendRequest',
  Events: 'Events',
  Profile: 'Profile',
  MemberProfile: 'MemberProfile',
  BillingProfile: 'BillingProfile',
  InvoiceScreen: 'InvoiceScreen',
  MembershipPlan: 'MembershipPlan',
  ClubInfo: 'ClubInfo',
  Members: 'Members',
  MemberInvite: 'MemberInvite',
  KitchenBar: 'KitchenBar',
}

const MainScreen: FC = (): JSX.Element => {
  const Tab = createBottomTabNavigator();
  const LeftButton = HideLeftButton as BottomTabNavigationOptions;

  return (
    <Tab.Navigator initialRouteName={mainRoutes.Dashboard}
      screenOptions={HeaderOptions as BottomTabNavigationOptions}
      tabBar={BottomTabs}
    >
      <Tab.Screen name={mainRoutes.Dashboard} component={Dashboard}
        options={{...LeftButton, title: 'Dashboard'}}
      />

      <Tab.Screen name={mainRoutes.Activity} component={Activity}
        options={{...LeftButton, title: 'Activity'}}
      />

      <Tab.Screen name={mainRoutes.Friends} component={Members}
        options={{...LeftButton, title: 'Friends'}}
      />
      <Tab.Screen name={mainRoutes.AcceptedFriend} component={AcceptedFriend}
        options={{title: 'Accepted Friend'}}
      />
      <Tab.Screen name={mainRoutes.PendingRequests} component={Members}
        options={{title: 'Pending Requests'}}
      />
      <Tab.Screen name={mainRoutes.FriendRequest} component={FriendRequest}
        options={{...LeftButton, title: 'Friend Request'}}
      />

      <Tab.Screen name={mainRoutes.Events} component={Events}
        options={{...LeftButton, title: 'Events'}}
      />

      <Tab.Screen name={mainRoutes.Profile} component={Profile}
        options={{...LeftButton, title: 'Profile'}}
      />
      <Tab.Screen name={mainRoutes.MemberProfile} component={MemberProfile}
        options={{title: 'Member Profile'}}
      />
      <Tab.Screen name={mainRoutes.BillingProfile} component={BillingProfile}
        options={{title: 'Billing Profile'}}
      />
      <Tab.Screen name={mainRoutes.InvoiceScreen} component={InvoiceScreen}
        options={{headerShown: false}}
      />
      <Tab.Screen name={mainRoutes.MembershipPlan} component={MembershipPlan}
        options={{title: 'Membership Plan'}}
      />

      <Tab.Screen name={mainRoutes.ClubInfo} component={ClubInfo}
        options={{...LeftButton, title: 'Club Info'}}
      />
      <Tab.Screen name={mainRoutes.Members} component={Members}
        options={{...LeftButton, title: 'Members'}}
      />
      <Tab.Screen name={mainRoutes.MemberInvite} component={MemberInvite}
        options={{title: 'Member Invite'}}
      />
      <Tab.Screen name={mainRoutes.KitchenBar} component={KitchenBar}
        options={{...LeftButton, title: 'Kitchen/Bar'}}
      />
    </Tab.Navigator>
  );
}

export default MainScreen;
