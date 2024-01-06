import React, { FC, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { authRoutes } from '../../routes';
import { postForgotPassword } from '../../requests';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const ForgotPassword: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [email, setEmail] = useState<string>();

  const sendResetCode = () => {
    setLoading(true);
    setMessage('');
    postForgotPassword({ email })
      .then(() => {
        navigation.navigate({
          name: authRoutes.EnterCode,
          params: { email },
        } as never);
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts auth={true} loading={loading}>
      <Message style={[t.pX8]} text={message} />
      <View style={[t.pX8]}>
        <TextInput inputMode="email" style={[s.input, t.mT6]}
          keyboardType="email-address"
          placeholder="Email address..." placeholderTextColor={theme.color.placeholder}
          value={email} onChangeText={setEmail}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          disabled={!email}
          onPress={sendResetCode}
        >
          Send reset code
        </Button>
      </View>
    </Layouts>
  );
}

export default ForgotPassword;
