import React, { FC } from 'react';
import { Text as CoreText, TextProps } from 'react-native';

import s from '../../utils/styles';

const Text: FC<TextProps> = (props): JSX.Element => {
  return (
    <CoreText {...props} style={[s.fontBody, s.textBody, props.style]}>
      { props.children }
    </CoreText>
  )
};

export default Text;
