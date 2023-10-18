import React, { FC } from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import Header from '../components/layouts/header';

import Login from '../screens/auth/login';
import ForgotPasswordStack from './forgot-password-stack';
import SetNewPassword from '../screens/auth/set-new-password';

const Stack = createStackNavigator();
const AuthStack: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="Login" screenOptions={{header: Header}}>
      <Stack.Screen name="Login" component={Login} options={{headerShown: false}} />
      <Stack.Screen name="SetNewPassword" component={SetNewPassword} options={{title: 'Set New Password'}} />
      <Stack.Screen name="ForgotPasswordScreen" component={ForgotPasswordStack} options={{headerShown: false}} />
    </Stack.Navigator>
  );
};

export default AuthStack;
