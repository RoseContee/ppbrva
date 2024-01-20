/**
 * @format
 */
import 'react-native-gesture-handler';
import { AppRegistry } from 'react-native';
import { Provider } from 'react-redux';
import PushNotificationIOS from '@react-native-community/push-notification-ios';
import PushNotification from 'react-native-push-notification';
import store, { dispatch } from './src/store';
import { setDeviceToken } from './src/store/settings';
import App from './App';
import { name as appName } from './app.json';

PushNotification.configure({
  senderID: '343774405997',
  permissions: {
    alert: true,
    badge: true,
    sound: true,
  },
  popInitialNotification: true,
  requestPermissions: true,

  onRegister: function ({ token }) {
    dispatch(setDeviceToken(token));
  },
  onRegistrationError: function(err) {
    console.error(err.message, err);
  },
  onNotification: function (notification) {
    console.log("NOTIFICATION:", notification);
    notification.finish(PushNotificationIOS.FetchResult.NoData);
  },
});

const ReduxProvider = () => {
  return(
    <Provider store={store}>
      <App />
    </Provider>
  );
}

AppRegistry.registerComponent(appName, () => ReduxProvider);
