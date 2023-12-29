import React, { FC } from 'react';
import { TextProps } from 'react-native';
import Text from './text';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const Link: FC<TextProps> = (props): JSX.Element => {
  return (
    <Text {...props} style={[s.textPrimary, t.underline, props.style]}>
      { props.children }
    </Text>
  )
}

export default Link;
