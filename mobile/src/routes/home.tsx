import React, { FC } from 'react';
import { createDrawerNavigator } from '@react-navigation/drawer';
import MainMenu from '../components/main-menu';

import MainScreen from './main';


export const homeRoutes = {
  MainScreen: 'MainScreen',
}

const HomeScreen: FC = (): JSX.Element => {
  const Drawer = createDrawerNavigator();

  return (
    <Drawer.Navigator initialRouteName={homeRoutes.MainScreen}
      drawerContent={MainMenu}
      screenOptions={{ drawerStyle: {width: '100%'} }}
    >
      <Drawer.Screen name={homeRoutes.MainScreen}
        component={MainScreen} options={{headerShown: false}}
      />
    </Drawer.Navigator>
  );
}

export default HomeScreen;
