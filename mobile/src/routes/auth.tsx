import React, { FC } from 'react';
import { StackNavigationOptions, createStackNavigator } from '@react-navigation/stack';
import HeaderOptions from '../components/header-options';

import {
  Login, ForgotPassword, EnterCode, ResetPassword
} from '../screens/auth';


export const authRoutes = {
  Login: 'Login',
  ForgotPassword: 'ForgotPassword',
  EnterCode: 'EnterCode',
  ResetPassword: 'ResetPassword',
}

const AuthScreen: FC = (): JSX.Element => {
  const Stack = createStackNavigator();

  return (
    <Stack.Navigator initialRouteName={authRoutes.Login}
      screenOptions={HeaderOptions as StackNavigationOptions}
    >
      <Stack.Screen name={authRoutes.Login} component={Login}
        options={{headerShown: false}}
      />
      <Stack.Screen name={authRoutes.ForgotPassword} component={ForgotPassword}
        options={{title: 'Forgot Password', headerRight: () => <></>}}
      />
      <Stack.Screen name={authRoutes.EnterCode} component={EnterCode}
        options={{title: 'Enter Code', headerRight: () => <></>}}
      />
      <Stack.Screen name={authRoutes.ResetPassword} component={ResetPassword}
        options={{title: 'Reset Password', headerRight: () => <></>}}
      />
    </Stack.Navigator>
  );
}

export default AuthScreen;
