import React, { FC, useEffect, useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { useAppDispatch, useAppSelector } from './src/store';
import { getName, saveAccessToken, saveMe } from './src/store/user';
import { getStorage } from './src/utils/storage';
import axios from './src/utils/axios';
import Header from './src/components/header';
import BottomTabs from './src/components/bottom-tabs';
import MainMenu from './src/components/main-menu';

import Loading from './src/components/basic/loading';

import {
  Login, ForgotPassword, EnterCode, ResetPassword
} from './src/screens/auth';
import Dashboard from './src/screens/dashboard';
import Activity from './src/screens/activity';
import Events from './src/screens/events';
import {
  Profile, MemberProfile, BillingProfile, MembershipPlan
} from './src/screens/profile';
import {
  Invoices, InvoiceDetail
} from './src/screens/invoices';
import ClubInfo from './src/screens/club-info';
import {
  Members, MemberInvite, FriendRequest, AcceptedFriend
} from './src/screens/members';
import KitchenBar from './src/screens/kitchen-bar';

const Stack = createStackNavigator();
const Tab = createBottomTabNavigator();
const Drawer = createDrawerNavigator();

const AuthScreen: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="Login" screenOptions={{header: Header}}>
      <Stack.Screen name="Login" component={Login} options={{headerShown: false}} />
      <Stack.Screen name="ForgotPassword" component={ForgotPassword} options={{title: 'Forgot Password'}} />
      <Stack.Screen name="EnterCode" component={EnterCode} options={{title: 'Enter Code'}} />
      <Stack.Screen name="ResetPassword" component={ResetPassword} options={{title: 'Reset Password'}} />
    </Stack.Navigator>
  );
};

const MainScreen: FC = (): JSX.Element => {
  const name = useAppSelector(getName);

  return (
    <Tab.Navigator initialRouteName="Dashboard" screenOptions={{header: Header}} tabBar={BottomTabs}>
      <Tab.Screen name="Dashboard" component={Dashboard} options={{title: 'Dashboard'}} />

      <Tab.Screen name="Activity" component={Activity} options={{title: 'Activity'}} />

      <Tab.Screen name="Friends" component={Members} options={{title: 'Friends'}} />
      <Tab.Screen name="AcceptedFriend" component={AcceptedFriend} options={{title: 'Accepted Friend'}} />
      <Tab.Screen name="PendingRequests" component={Members} options={{title: 'Pending Requests'}} />
      <Tab.Screen name="FriendRequest" component={FriendRequest} options={{title: 'Friend Request'}} />

      <Tab.Screen name="Events" component={Events} options={{title: 'Events'}} />

      <Tab.Screen name="Profile" component={Profile} options={{title: name}} />
      <Tab.Screen name="MemberProfile" component={MemberProfile} options={{title: 'Member Profile'}} />
      <Tab.Screen name="BillingProfile" component={BillingProfile} options={{title: 'Billing Profile'}} />
      <Tab.Screen name="Invoices" component={Invoices} options={{title: 'Invoices'}} />
      <Tab.Screen name="InvoiceDetail" component={InvoiceDetail} options={{title: 'Invoice Detail'}} />
      <Tab.Screen name="MembershipPlan" component={MembershipPlan} options={{title: 'Membership Plan'}} />

      <Tab.Screen name="ClubInfo" component={ClubInfo} options={{title: 'Club Info'}} />
      <Tab.Screen name="Members" component={Members} options={{title: 'Members'}} />
      <Tab.Screen name="MemberInvite" component={MemberInvite} options={{title: 'Member Invite'}} />
      <Tab.Screen name="KitchenBar" component={KitchenBar} options={{title: 'Kitchen/Bar'}} />
    </Tab.Navigator>
  );
};

const HomeScreen: FC = (): JSX.Element => {
  return (
    <Drawer.Navigator initialRouteName="MainScreen" drawerContent={MainMenu} screenOptions={{ drawerStyle: {width: '100%'} }}>
      <Drawer.Screen name="MainScreen" component={MainScreen} options={{headerShown: false}} />
    </Drawer.Navigator>
  );
};

const App: FC = (): JSX.Element => {
  const dispatch = useAppDispatch();
  const [initialRoute, setInitialRoute] = useState<string>();

  useEffect(() => {
    getStorage('access_token').then(access_token => {
      const gotoLogin = () => {
        dispatch(saveAccessToken(null));
        setInitialRoute('AuthScreen');
      };
      if (!access_token) {
        gotoLogin();
        return;
      }
      dispatch(saveAccessToken(access_token));
      axios.get(`/me`).then(({ data: { user } }) => {
        dispatch(saveMe(user));
        if (!user) gotoLogin();
        else if (user.original_pass) setInitialRoute('SetNewPassword');
        else setInitialRoute('HomeScreen');
      }).catch(() => gotoLogin());
    });
  }, []);

  if (!initialRoute) return <Loading show={true} />
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName={initialRoute} screenOptions={{header: Header}}>
        <Stack.Screen name="AuthScreen" component={AuthScreen} options={{headerShown: false}} />
        <Stack.Screen name="SetNewPassword" component={ResetPassword} options={{title: 'Set New Password'}} />
        <Stack.Screen name="HomeScreen" component={HomeScreen} options={{headerShown: false}} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default App;
