import React, { FC, useEffect, useState } from 'react';
import { useAppDispatch } from './src/store';
import { saveAccessToken } from './src/store/settings';
import { getStorage } from './src/utils/storage';
import { fetchMe } from './src/requests/ppbrva-auth';
import Loading from './src/components/basic/loading';
import AppScreen from './src/routes/app';
import { appRoutes } from './src/routes';


const App: FC = (): JSX.Element => {
  const dispatch = useAppDispatch();
  const [initialRoute, setInitialRoute] = useState<string>();

  useEffect(() => {
    getStorage('access_token').then(access_token => {
      const gotoLogin = () => {
        dispatch(saveAccessToken(null));
        setInitialRoute(appRoutes.AuthScreen);
      }
      if (!access_token) return gotoLogin();
      dispatch(saveAccessToken(access_token));
      fetchMe()
        .then(user => {
          if (!user) return gotoLogin();
          const screen = user.original_pass
            ? appRoutes.SetNewPassword
            : appRoutes.HomeScreen;
          setInitialRoute(screen);
        })
        .catch(() => gotoLogin());
    });
  }, []);

  if (!initialRoute) {
    return <Loading show={true} />
  }
  return <AppScreen screen={initialRoute} />
}

export default App;
