import React, { FC } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { StackNavigationOptions, createStackNavigator } from '@react-navigation/stack';
import HeaderOptions from '../components/header-options';

import AuthScreen from './auth';
import { ResetPassword } from '../screens/auth';
import HomeScreen from './home';


export const appRoutes = {
  AuthScreen: 'AuthScreen',
  SetNewPassword: 'SetNewPassword',
  HomeScreen: 'HomeScreen',
}

interface IProps {
  screen: string
}

const AppScreen: FC<IProps> = ({ screen }): JSX.Element => {
  const Stack = createStackNavigator();

  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName={screen}
        screenOptions={HeaderOptions as StackNavigationOptions}
      >
        <Stack.Screen name={appRoutes.AuthScreen} component={AuthScreen}
          options={{headerShown: false}}
        />
        <Stack.Screen name={appRoutes.SetNewPassword} component={ResetPassword}
          options={{title: 'Set New Password', headerRight: () => <></>}}
        />
        <Stack.Screen name={appRoutes.HomeScreen} component={HomeScreen}
          options={{headerShown: false}}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default AppScreen;
