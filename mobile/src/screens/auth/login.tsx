import React, { FC, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import DeviceInfo from 'react-native-device-info';
import { useAppDispatch } from '../../store';
import { SaveAccessToken, SaveMe } from '../../store/user';
import { saveStorage } from '../../utils/storage';
import axios, { getErrorMessage } from '../../utils/axios';
import Image from 'react-native-scalable-image';
import Layouts from '../../components/layouts/auth-layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Link from '../../components/basic/link';
import Loading from '../../components/basic/loading';

import imgLogo from '../../assets/img/logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const Login: FC = (): JSX.Element => {
  const [loading, setLoading] = useState(false);
  const [email, setEmail] = useState<string>();
  const [password, setPassword] = useState<string>();
  const [message, setMessage] = useState<string>();
  const dispatch = useAppDispatch();
  const navigation = useNavigation();

  const login = () => {
    if (!email) {
      setMessage('The email field is required.');
      return;
    }
    if (!password) {
      setMessage('The password field is required.');
      return;
    }
    const device = DeviceInfo.getDeviceId() + '-' + email;
    setLoading(true);
    axios.post(`/login`, {email, password, device}).then(({ data: { access_token, user }}) => {
      dispatch(SaveAccessToken(access_token));
      dispatch(SaveMe(user));
      saveStorage('access_token', access_token);
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
    <>
      <Loading show={loading} />
      <Layouts>
        <View style={[t.itemsCenter, t.mT8]}>
          <Image source={imgLogo} width={theme.size.logo} />
        </View>
        <Message style={[t.pX6, t.mT3]} text={message} />
        <View style={[t.pX6]}>
          <TextInput inputMode="email" style={[s.input, t.mT4]}
            keyboardType="email-address"
            placeholder="Email address..."
            value={email} onChange={e => setEmail(e.nativeEvent.text)}
          />
          <TextInput inputMode="text" style={[s.input, t.mT4]}
            secureTextEntry={true}
            placeholder="Password..."
            value={password} onChange={e => setPassword(e.nativeEvent.text)}
          />
          <Button style={[s.bgPrimary, t.mT4]}
            onPress={login}
          >
            Login
          </Button>
          <Link style={[t.textXs, t.mT5]}
            onPress={() => navigation.navigate('ForgotPassword' as never)}
          >
            Reset Password
          </Link>
        </View>
      </Layouts>
    </>
  );
};

export default Login;
