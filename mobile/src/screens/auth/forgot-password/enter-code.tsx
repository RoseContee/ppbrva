import React, { FC, RefObject, createRef, useRef, useState } from 'react';
import {
  NativeSyntheticEvent,
  TextInput,
  TextInputChangeEventData,
  View
} from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';
import axios, { getErrorMessage } from '../../../utils/axios';
import Layouts from '../../../components/layouts/auth-layouts';
import Message from '../../../components/basic/message';
import Button from '../../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../../utils/styles';

const EnterCode: FC = (): JSX.Element => {
  const route = useRoute();
  const navigation = useNavigation();
  const codeRefs = useRef<RefObject<TextInput>[]>([]);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>('Reset code has been sent to your email.');
  const [nums, setNums] = useState<string[]>(['', '', '', '', '', '']);

  codeRefs.current = Array(6).fill(0).map((_, i) => createRef<TextInput>());

  const onChange = (i: number) => (e: NativeSyntheticEvent<TextInputChangeEventData>) => {
    setNums(nums => {
      nums[i] = e.nativeEvent.text;
      return nums;
    })
    const next = codeRefs.current[i + 1];
    if (nums[i] && next?.current) {
      next.current.focus();
    }
  };

  const validateCode = () => {
    let code = '';
    Array(6).fill(0).map((_, i) => {
      code += nums[i];
    });
    if (code.length < 6) {
      setMessage('Please input code.');
      return;
    }
    const email = (route.params as any)?.email;
    setLoading(true);
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
      <View style={[t.mT4]}>
        <Message style={[t.pX6]} text={message} />
      </View>
      <View style={[t.pX6]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT4]}>
          {Array(6).fill(0).map((_, i) => (
            <TextInput key={i} inputMode="numeric" style={[s.input, s.inputOne]}
              keyboardType="number-pad"
              maxLength={1} textAlign="center" placeholder={(i + 1).toString()}
              selectTextOnFocus={true}
              ref={codeRefs.current[i]}
              onChange={onChange(i)}
            />
          ))}
        </View>
        <Button style={[s.bgPrimary, t.mT4]}
          onPress={validateCode}
        >
          Validate
        </Button>
      </View>
    </Layouts>
  )
}

export default EnterCode;
