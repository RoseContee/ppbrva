import React, { FC } from 'react';
import {
  Text as BaseText,
  TextProps
} from 'react-native';

import s from '../../utils/styles';

const Text: FC<TextProps> = (props): JSX.Element => {
  return (
    <BaseText {...props} style={[s.fontBody, s.textBody, props.style]}>
      { props.children }
    </BaseText>
  )
};

export default Text;
