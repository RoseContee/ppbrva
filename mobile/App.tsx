import React, { FC } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import AuthStack from './src/navigations/auth-stack';
import DrawerStack from './src/navigations/drawer-stack';

const AppStack = createStackNavigator();
const App: FC = (): JSX.Element => {
  return (
    <NavigationContainer>
      <AppStack.Navigator initialRouteName="AuthScreen">
        <AppStack.Screen name="AuthScreen" component={AuthStack} options={{headerShown: false}} />
        <AppStack.Screen name="HomeScreen" component={DrawerStack} options={{headerShown: false}} />
      </AppStack.Navigator>
    </NavigationContainer>
  )
};

export default App;
