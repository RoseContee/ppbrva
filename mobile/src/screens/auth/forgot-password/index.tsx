import React, { FC, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import axios, { getErrorMessage } from '../../../utils/axios';
import Layouts from '../../../components/layouts/auth-layouts';
import Message from '../../../components/basic/message';
import Button from '../../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../../utils/styles';

const ForgotPassword: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [email, setEmail] = useState<string>();

  const sendResetCode = () => {
    if (!email) {
      setMessage('The email field is required.');
      return;
    }
    setLoading(true);
    axios.post(`/forgot-password`, {
      email
    }).then(() => {
      navigation.navigate({
        name: 'EnterCode',
        params: { email },
      } as never);
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[t.mT4]}>
        <Message style={[t.pX6]} text={message} />
      </View>
      <View style={[t.pX6]}>
        <TextInput inputMode="email" style={[s.input, t.mT4]}
          keyboardType="email-address"
          placeholder="Email address..."
          value={email} onChange={e => setEmail(e.nativeEvent.text)}
        />
        <Button style={[s.bgPrimary, t.mT4]}
          onPress={sendResetCode}
        >
          Send reset code
        </Button>
      </View>
    </Layouts>
  )
}

export default ForgotPassword;
