import React, { FC } from 'react';
import {
  View,
  ViewProps
} from 'react-native';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const Card: FC<ViewProps> = (props): JSX.Element => {
  return (
    <View {...props} style={[s.card, t.p5, props.style]}>
      { props.children }
    </View>
  )
};

export default Card;
