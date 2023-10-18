import React, { FC } from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import Header from '../components/layouts/header';

import ForgotPassword from '../screens/auth/forgot-password';
import EnterCode from '../screens/auth/forgot-password/enter-code';
import ResetPassword from '../screens/auth/forgot-password/reset-password';

const Stack = createStackNavigator();
const ForgotPasswordStack: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="ForgotPassword" screenOptions={{header: Header}}>
      <Stack.Screen name="ForgotPassword" component={ForgotPassword} options={{title: 'Forgot Password'}} />
      <Stack.Screen name="EnterCode" component={EnterCode} options={{title: 'Enter Code'}} />
      <Stack.Screen name="ResetPassword" component={ResetPassword} options={{title: 'Reset Password'}} />
    </Stack.Navigator>
  );
};

export default ForgotPasswordStack;
