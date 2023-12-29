import React, { FC, RefObject, createRef, useRef, useState } from 'react';
import {
  TextInput,
  View
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import { postVaildateCode } from '../../requests';
import { authRoutes } from '../../routes';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const EnterCode: FC = (): JSX.Element => {
  const route = useRoute();
  const navigation = useNavigation();
  const codeRefs = useRef<RefObject<TextInput>[]>(Array(6).fill(0).map(() => createRef<TextInput>()));
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>('Reset code has been sent to your email.');
  const [nums, setNums] = useState<string[]>(Array(6).fill(''));
  const email = (route.params as any)?.email;

  const onChangeText = (i: number) => (num: string) => {
    setNums(nums => {
      nums[i] = num;
      return nums;
    });
    if (num) codeRefs.current[i + 1]?.current?.focus();
  }

  const validateCode = () => {
    let code = nums.reduce((code, num) => code + num, '');
    if (code.length < 6) {
      return setMessage('Please input code.');
    }
    setLoading(true);
    setMessage('');
    postVaildateCode({ email, code })
      .then(() => {
        navigation.navigate({
          name: authRoutes.ResetPassword,
          params: { email, code },
        } as never);
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts auth={true} loading={loading}>
      <Message style={[t.pX8]} text={message} />
      <View style={[t.pX8]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT6]}>
          {Array(6).fill(0).map((_, i) => (
            <TextInput key={i} inputMode="numeric" style={[s.input, s.inputOne]}
              keyboardType="number-pad"
              maxLength={1} textAlign="center"
              placeholder={(i + 1).toString()} placeholderTextColor={theme.color.placeholder}
              selectTextOnFocus={true}
              ref={codeRefs.current[i]}
              onChangeText={onChangeText(i)}
            />
          ))}
        </View>
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={validateCode}
        >
          Validate
        </Button>
      </View>
    </Layouts>
  );
}

export default EnterCode;
