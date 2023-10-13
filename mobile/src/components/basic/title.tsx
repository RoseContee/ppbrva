import React, { FC } from 'react';
import { Text, TextProps } from 'react-native';

import s from '../../utils/styles';

const Title: FC<TextProps> = (props): JSX.Element => {
  return (
    <Text {...props} style={[s.fontTitle, s.textTitle, props.style]}>
      { props.children }
    </Text>
  )
};

export default Title;
