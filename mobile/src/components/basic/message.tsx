import React, { FC, ReactNode } from 'react';
import {
  View,
  StyleProp,
  ViewStyle,
} from 'react-native';
import Text from './text';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  children?: ReactNode,
  text?: string,
  style?: StyleProp<ViewStyle>,
}

const Message: FC<IProps> = ({
  children,
  text,
  style,
}): JSX.Element => {
  return (
    <>
    {
      (text || children) &&
      <View style={[s.message, s.pX7, t.pY5, style]}>
        {
          text ? ( <Text style={[s.messageText]}>{ text }</Text> )
          : ( children )
        }
      </View>
    }
    </>
  )
};

export default Message;
