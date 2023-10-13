import React, { FC } from 'react';
import {
  View,
  ViewProps
} from 'react-native';

import { t } from 'react-native-tailwindcss';

const Card: FC<ViewProps> = (props): JSX.Element => {
  return (
    <View {...props} style={[t.shadow, t.bgWhite, t.p3, props.style]}>
      { props.children }
    </View>
  )
};

export default Card;
