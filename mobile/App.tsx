import React, { FC, useEffect, useState } from 'react';
import { Provider } from 'react-redux';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import store, { useAppDispatch } from './src/store';
import { SaveAccessToken, SaveMe } from './src/store/user';
import { getStorage } from './src/utils/storage';
import axios from './src/utils/axios';
import Loading from './src/components/basic/loading';

import AuthStack from './src/navigations/auth-stack';
import DrawerStack from './src/navigations/drawer-stack';

const AppStack = createStackNavigator();
const App: FC = (): JSX.Element => {
  const [initialRoute, setInitialRoute] = useState<string>();
  const dispatch = useAppDispatch();

  useEffect(() => {
    getStorage('access_token').then(access_token => {
      if (!access_token) {
        setInitialRoute('AuthScreen');
        return;
      }
      dispatch(SaveAccessToken(access_token));
      axios.get(`/me`).then(({ data: { user } }) => {
        dispatch(SaveMe(user));
        setInitialRoute('HomeScreen');
      }).catch(() => {
        dispatch(SaveAccessToken(null));
        setInitialRoute('AuthScreen');
      })
    });
  }, []);

  if (!initialRoute) return <Loading show={true} />
  return (
    <Provider store={store}>
      <NavigationContainer>
        <AppStack.Navigator initialRouteName={initialRoute}>
          <AppStack.Screen name="AuthScreen" component={AuthStack} options={{headerShown: false}} />
          <AppStack.Screen name="HomeScreen" component={DrawerStack} options={{headerShown: false}} />
        </AppStack.Navigator>
      </NavigationContainer>
    </Provider>
  )
};

export default App;
