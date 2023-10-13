import React, { FC } from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import Header from '../components/layouts/header';

import Login from '../screens/auth/login';
import ForgotPassword from '../screens/auth/forgot-password';
import EnterCode from '../screens/auth/enter-code';
import ResetPassword from '../screens/auth/reset-password';

const Stack = createStackNavigator();
const AuthStack: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="Login" screenOptions={{header: Header}}>
      <Stack.Screen name="Login" component={Login} options={{headerShown: false}} />
      <Stack.Screen name="ForgotPassword" component={ForgotPassword} options={{title: 'Forgot Password'}} />
      <Stack.Screen name="EnterCode" component={EnterCode} options={{title: 'Enter Code'}} />
      <Stack.Screen name="ResetPassword" component={ResetPassword} options={{title: 'Reset Password'}} />
    </Stack.Navigator>
  );
};

export default AuthStack;
