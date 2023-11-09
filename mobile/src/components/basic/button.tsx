import React, { FC, ReactNode } from 'react';
import {
  StyleProp,
  Text,
  TextStyle,
  TouchableOpacity,
  View,
  ViewStyle
} from 'react-native';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  children: ReactNode,
  onPress: () => void,
  style?: StyleProp<ViewStyle>,
  titleStyle?: StyleProp<TextStyle>,
  disabled?: boolean,
}

const Button: FC<IProps> = ({
  children,
  onPress,
  style,
  titleStyle,
  disabled,
}): JSX.Element => {
  return (
    <>
      {
        disabled ?
        <View style={[s.btn, style, {opacity: 0.6}]}>
          <Text style={[s.fontButtonBold, t.textLg, t.textWhite, t.uppercase, titleStyle]}>
            { children }
          </Text>
        </View>
        :
        <TouchableOpacity style={[s.btn, style]} onPress={() => onPress()}>
          <Text style={[s.fontButtonBold, t.textLg, t.textWhite, t.uppercase, titleStyle]}>
            { children }
          </Text>
        </TouchableOpacity>
      }
    </>
  )
};

export default Button;
