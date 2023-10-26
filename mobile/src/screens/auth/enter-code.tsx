import React, { FC, RefObject, createRef, useRef, useState } from 'react';
import {
  NativeSyntheticEvent,
  TextInput,
  TextInputChangeEventData,
  View
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import axios, { getErrorMessage } from '../../utils/axios';
import Layouts from '../../components/layouts/auth';
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

  const onChange = (i: number) => (e: NativeSyntheticEvent<TextInputChangeEventData>) => {
    const num = e.nativeEvent.text;
    setNums(nums => {
      nums[i] = num;
      return nums;
    });
    if (num) codeRefs.current[i + 1]?.current?.focus();
  };

  const validateCode = () => {
    let code = nums.reduce((code, num) => code + num, '');
    if (code.length < 6) {
      setMessage('Please input code.');
      return;
    }
    setLoading(true);
    setMessage('');
    axios.post(`validate-code`, {
      email, code
    }).then(() => {
      navigation.navigate({
        name: 'ResetPassword',
        params: { email, code },
      } as never);
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  };

  return (
    <Layouts loading={loading}>
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
              onChange={onChange(i)}
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
};

export default EnterCode;
