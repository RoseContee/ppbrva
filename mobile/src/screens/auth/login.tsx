import React, { FC, useCallback, useEffect, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import DeviceInfo from 'react-native-device-info';
import { useAppDispatch } from '../../store';
import { saveAccessToken, saveMe } from '../../store/user';
import { saveStorage } from '../../utils/storage';
import axios, { getErrorMessage } from '../../utils/axios';
import Image from 'react-native-scalable-image';
import Layouts from '../../components/layouts/auth';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Link from '../../components/basic/link';

import imgLogo from '../../assets/img/logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const Login: FC = (): JSX.Element => {
  const route = useRoute();
  const navigation = useNavigation();
  const dispatch = useAppDispatch();
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [email, setEmail] = useState<string>();
  const [password, setPassword] = useState<string>();
  const msg = (route.params as any)?.message;

  useFocusEffect(
    useCallback(() => {
      setMessage('');
      setEmail('');
      setPassword('');
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        BackHandler.exitApp();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  useEffect(() => {
    setMessage(msg);
  }, [msg]);

  const login = () => {
    if (!email) {
      setMessage('The email field is required.');
      return;
    }
    if (!password) {
      setMessage('The password field is required.');
      return;
    }
    setLoading(true);
    setMessage('');
    const device = DeviceInfo.getDeviceId() + '-' + email;
    axios.post(`/login`, {
      email, password, device
    }).then(({ data: { access_token, user }}) => {
      saveStorage('access_token', access_token);
      dispatch(saveAccessToken(access_token));
      dispatch(saveMe(user));
      if (user.original_pass) {
        navigation.navigate('SetNewPassword' as never);
      } else {
        navigation.navigate('HomeScreen' as never);
      }
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  };

  return (
    <Layouts loading={loading}>
      <View style={[t.itemsCenter, t.mT5, t.mB3]}>
        <Image source={imgLogo} width={theme.size.logo} />
      </View>
      <Message style={[t.pX8, t.mT3]} text={message} />
      <View style={[t.pX8]}>
        <TextInput inputMode="email" style={[s.input, t.mT6]}
          keyboardType="email-address"
          placeholder="Email address..." placeholderTextColor={theme.color.placeholder}
          value={email} onChange={e => setEmail(e.nativeEvent.text)}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          secureTextEntry={true}
          placeholder="Password..." placeholderTextColor={theme.color.placeholder}
          value={password} onChange={e => setPassword(e.nativeEvent.text)}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={login}
        >
          Login
        </Button>
        <Link style={[t.textLg, t.mT8]}
          onPress={() => navigation.navigate('ForgotPassword' as never)}
        >
          Reset Password
        </Link>
      </View>
    </Layouts>
  );
};

export default Login;
