import React, { FC, RefObject, createRef, useRef, useState } from 'react';
import {
  NativeSyntheticEvent,
  TextInput,
  TextInputChangeEventData,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Layouts from '../../../components/layouts/auth-layouts';
import Message from '../../../components/basic/message';
import Button from '../../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../../utils/styles';

const EnterCode: FC = (): JSX.Element => {
  const codeRefs = useRef<RefObject<TextInput>[]>([]);
  const [code, setCode] = useState<string>();
  const [message, setMessage] = useState<string>();
  const navigation = useNavigation();

  codeRefs.current = Array(6).fill(0).map((_, i) => createRef<TextInput>());

  const onChange = (i: number) => (e: NativeSyntheticEvent<TextInputChangeEventData>) => {
    const next = codeRefs.current[i + 1];
    if (next?.current) {
      next.current.focus();
    }
  };

  return (
    <Layouts>
      <View style={[t.mT4]}>
        <Message style={[t.pX6]} text={message} />
      </View>
      <View style={[t.pX6]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT4]}>
          {Array(6).fill(0).map((el, i) => (
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
          onPress={() => navigation.navigate('ResetPassword' as never)}
        >
          Validate
        </Button>
      </View>
    </Layouts>
  )
}

export default EnterCode;
