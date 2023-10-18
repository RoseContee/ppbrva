import React, { FC, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Layouts from '../../../components/layouts/auth-layouts';
import Message from '../../../components/basic/message';
import Button from '../../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../../utils/styles';

const ResetPassword: FC = (): JSX.Element => {
  const [message, setMessage] = useState<string>('Passwords does not match, please try again.');
  const [password, setPassword] = useState<string>();
  const [password_confirmation, setPasswordConfirmation] = useState<string>();
  const navigation = useNavigation();

  return (
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
          onPress={() => navigation.navigate('Login' as never)}
        >
          Save password
        </Button>
      </View>
    </Layouts>
  )
};

export default ResetPassword;
