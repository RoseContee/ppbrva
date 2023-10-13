import React, { FC } from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import Header from '../components/layouts/header';

import Profile from '../screens/profile';
import ProfileMember from '../screens/profile/member';
import ProfileBilling from '../screens/profile/billing';
import ProfileInvoices from '../screens/profile/invoices';
import ProfileInvoicesDetail from '../screens/profile/invoices-detail';
import ProfileMembershipPlan from '../screens/profile/membership-plan';

const Stack = createStackNavigator();
const ProfileStack: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="Profile" screenOptions={{header: Header}}>
      <Stack.Screen name="Profile" component={Profile} options={{title: 'Wally Pickles'}} />
      <Stack.Screen name="ProfileMember" component={ProfileMember} options={{title: 'Member Profile'}} />
      <Stack.Screen name="ProfileBilling" component={ProfileBilling} options={{title: 'Billing Profile'}} />
      <Stack.Screen name="ProfileInvoices" component={ProfileInvoices} options={{title: 'Invoices'}} />
      <Stack.Screen name="ProfileInvoicesDetail" component={ProfileInvoicesDetail} options={{title: 'December 2023'}} />
      <Stack.Screen name="ProfileMembershipPlan" component={ProfileMembershipPlan} options={{title: 'Membership Plan'}} />
    </Stack.Navigator>
  );
};

export default ProfileStack;
