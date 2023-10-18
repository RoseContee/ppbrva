import React, { FC, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import axios, { getErrorMessage } from '../../utils/axios';
import Layouts from '../../components/layouts/auth-layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Loading from '../../components/basic/loading';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const SetNewPassword: FC = (): JSX.Element => {
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [password, setPassword] = useState<string>();
  const [password_confirmation, setPasswordConfirmation] = useState<string>();
  const navigation = useNavigation();

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
    axios.post(`/update-password`, {password, password_confirmation}).then(() => {
      navigation.navigate('HomeScreen' as never);
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  };

  return (
    <>
      <Loading show={loading} />
      <Layouts>
        <View style={[t.mT4]}>
          <Message style={[t.pX6]} text={message} />
        </View>
        <View style={[t.pX6]}>
          <TextInput inputMode="text" style={[s.input, t.mT4]}
            secureTextEntry={true}
            placeholder="New Password..."
            value={password} onChange={e => setPassword(e.nativeEvent.text)}
          />
          <TextInput inputMode="text" style={[s.input, t.mT4]}
            secureTextEntry={true}
            placeholder="Confirm Password..."
            value={password_confirmation}
            onChange={e => setPasswordConfirmation(e.nativeEvent.text)}
          />
          <Button style={[s.bgPrimary, t.mT4]}
            onPress={savePassword}
          >
            Save password
          </Button>
        </View>
      </Layouts>
    </>
  )
};

export default SetNewPassword;
