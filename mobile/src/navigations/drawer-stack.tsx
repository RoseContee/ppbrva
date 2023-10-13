import React, { FC } from 'react';
import { createDrawerNavigator } from '@react-navigation/drawer';
import MainMenu from '../components/layouts/menu';

import TabStack from './tab-stack';

const Drawer = createDrawerNavigator();
const DrawerStack: FC = (): JSX.Element => {
  return (
    <Drawer.Navigator initialRouteName="MainScreen" drawerContent={MainMenu}
      screenOptions={{ drawerStyle: {width: '100%'} }}
    >
      <Drawer.Screen name="MainScreen" component={TabStack} options={{headerShown: false}} />
    </Drawer.Navigator>
  );
};

export default DrawerStack;
