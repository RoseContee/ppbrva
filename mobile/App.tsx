import React, { FC, useEffect, useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { StackNavigationOptions, createStackNavigator } from '@react-navigation/stack';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { BottomTabNavigationOptions, createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { useAppDispatch } from './src/store';
import { saveAccessToken, saveMe } from './src/store/user';
import { getStorage } from './src/utils/storage';
import axios from './src/utils/axios';
import HeaderOptions, { HideLeftButton } from './src/components/header-options';
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
    <Stack.Navigator initialRouteName="Login"
      screenOptions={HeaderOptions as StackNavigationOptions}
    >
      <Stack.Screen name="Login" component={Login} options={{headerShown: false}} />
      <Stack.Screen name="ForgotPassword" component={ForgotPassword}
        options={{
          title: 'Forgot Password',
          headerRight: () => <></>
        }}
      />
      <Stack.Screen name="EnterCode" component={EnterCode}
        options={{
          title: 'Enter Code',
          headerRight: () => <></>
        }}
      />
      <Stack.Screen name="ResetPassword" component={ResetPassword}
        options={{
          title: 'Reset Password',
          headerRight: () => <></>
        }}
      />
    </Stack.Navigator>
  );
};

const MainScreen: FC = (): JSX.Element => {
  return (
    <Tab.Navigator initialRouteName="Dashboard"
      screenOptions={HeaderOptions as BottomTabNavigationOptions}
      tabBar={BottomTabs}
    >
      <Tab.Screen name="Dashboard" component={Dashboard}
        options={{...HideLeftButton, title: 'Dashboard'}}
      />

      <Tab.Screen name="Activity" component={Activity}
        options={{...HideLeftButton, title: 'Activity'}}
      />

      <Tab.Screen name="Friends" component={Members}
        options={{...HideLeftButton, title: 'Friends'}}
      />
      <Tab.Screen name="AcceptedFriend" component={AcceptedFriend} options={{title: 'Accepted Friend'}} />
      <Tab.Screen name="PendingRequests" component={Members} options={{title: 'Pending Requests'}} />
      <Tab.Screen name="FriendRequest" component={FriendRequest}
        options={{...HideLeftButton, title: 'Friend Request'}}
      />

      <Tab.Screen name="Events" component={Events}
        options={{...HideLeftButton, title: 'Events'}}
      />

      <Tab.Screen name="Profile" component={Profile}
        options={{
          ...HideLeftButton,
          title: 'Profile'
        }}
      />
      <Tab.Screen name="MemberProfile" component={MemberProfile} options={{title: 'Member Profile'}} />
      <Tab.Screen name="BillingProfile" component={BillingProfile} options={{title: 'Billing Profile'}} />
      <Tab.Screen name="Invoices" component={Invoices} options={{title: 'Invoices'}} />
      <Tab.Screen name="InvoiceDetail" component={InvoiceDetail} options={{title: 'Invoice Detail'}} />
      <Tab.Screen name="MembershipPlan" component={MembershipPlan} options={{title: 'Membership Plan'}} />

      <Tab.Screen name="ClubInfo" component={ClubInfo}
        options={{...HideLeftButton, title: 'Club Info'}}
      />
      <Tab.Screen name="Members" component={Members}
        options={{...HideLeftButton, title: 'Members'}}
      />
      <Tab.Screen name="MemberInvite" component={MemberInvite} options={{title: 'Member Invite'}} />
      <Tab.Screen name="KitchenBar" component={KitchenBar}
        options={{...HideLeftButton, title: 'Kitchen/Bar'}}
      />
    </Tab.Navigator>
  );
};

const HomeScreen: FC = (): JSX.Element => {
  return (
    <Drawer.Navigator initialRouteName="MainScreen"
      drawerContent={MainMenu}
      screenOptions={{ drawerStyle: {width: '100%'} }}
    >
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
      <Stack.Navigator initialRouteName={initialRoute}
        screenOptions={HeaderOptions as StackNavigationOptions}
      >
        <Stack.Screen name="AuthScreen" component={AuthScreen} options={{headerShown: false}} />
        <Stack.Screen name="SetNewPassword" component={ResetPassword}
          options={{
            title: 'Set New Password',
            headerRight: () => <></>
          }}
        />
        <Stack.Screen name="HomeScreen" component={HomeScreen} options={{headerShown: false}} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default App;
