import React, { FC, useCallback, useEffect, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import DeviceInfo from 'react-native-device-info';
import { appRoutes, authRoutes } from '../../routes';
import { postLogin } from '../../requests';
import Image from 'react-native-scalable-image';
import Layouts from '../../components/layouts';
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
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>('');
  const [email, setEmail] = useState<string>('');
  const [password, setPassword] = useState<string>('');
  const msg = (route.params as any)?.message;

  useFocusEffect(
    useCallback(() => {
      initStates();
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

  const initStates = () => {
    setMessage('');
    setEmail('');
    setPassword('');
  }

  const login = () => {
    setLoading(true);
    setMessage('');
    const device = DeviceInfo.getDeviceId() + '-' + email;
    postLogin({ email, password, device })
      .then(user => {
        const screen = user.original_pass
          ? appRoutes.SetNewPassword
          : appRoutes.HomeScreen;
        navigation.navigate(screen as never);
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts auth={true} loading={loading}>
      <View style={[t.itemsCenter, t.mT5, t.mB3]}>
        <Image source={imgLogo} width={theme.size.logo} />
      </View>
      <Message style={[t.pX8, t.mT3]} text={message} />
      <View style={[t.pX8]}>
        <TextInput inputMode="email" style={[s.input, t.mT6]}
          keyboardType="email-address"
          placeholder="Email address..." placeholderTextColor={theme.color.placeholder}
          value={email} onChangeText={setEmail}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          secureTextEntry={true}
          placeholder="Password..." placeholderTextColor={theme.color.placeholder}
          value={password} onChangeText={setPassword}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          disabled={!email || !password}
          onPress={login}
        >
          Login
        </Button>
        <Link style={[t.textLg, t.mT8]}
          onPress={() => navigation.navigate(authRoutes.ForgotPassword as never)}
        >
          Reset Password
        </Link>
      </View>
    </Layouts>
  );
}

export default Login;
