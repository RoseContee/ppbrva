import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import axios, { getErrorMessage } from '../../utils/axios';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const ResetPassword: FC = (): JSX.Element => {
  const route = useRoute();
  const navigation = useNavigation();
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [password, setPassword] = useState<string>();
  const [password_confirmation, setPasswordConfirmation] = useState<string>();
  const resetPasswordPage = route.name === 'ResetPassword';
  const email = (route.params as any)?.email;
  const code = (route.params as any)?.code;

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        if (resetPasswordPage) {
          navigation.navigate('Login' as never);
        } else {
          navigation.navigate('HomeScreen' as never);
        }
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const savePassword = () => {
    if (!password) {
      setMessage('The password field is required.');
      return;
    }
    if (password.length < 8) {
      setMessage('The password field must be at least 8 characters.');
      return;
    }
    if (password != password_confirmation) {
      setMessage('The password field confirmation does not match.');
      return;
    }
    setLoading(true);
    setMessage('');
    axios.post(`/${resetPasswordPage ? 'reset' : 'update'}-password`, {
      email, code, password, password_confirmation
    }).then(() => {
      if (resetPasswordPage) {
        navigation.navigate({
          name: 'Login',
          params: {
            message: 'Login with new password.',
          },
        } as never);
      } else {
        navigation.navigate('HomeScreen' as never);
      }
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  };

  return (
    <Layouts auth={true} loading={loading}>
      <Message style={[t.pX8]} text={message} />
      <View style={[t.pX8]}>
        <TextInput inputMode="text" style={[s.input, t.mT6]}
          secureTextEntry={true}
          placeholder="New Password..." placeholderTextColor={theme.color.placeholder}
          value={password} onChangeText={setPassword}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          secureTextEntry={true}
          placeholder="Confirm Password..." placeholderTextColor={theme.color.placeholder}
          value={password_confirmation} onChangeText={setPasswordConfirmation}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={savePassword}
        >
          Save password
        </Button>
      </View>
    </Layouts>
  );
};

export default ResetPassword;
