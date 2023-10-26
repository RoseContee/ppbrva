import React, { FC } from 'react';
import {
  StyleProp,
  ViewStyle
} from 'react-native';
import Text from './text';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  title: string,
}

const PageTitle: FC<IProps> = ({ style, title }): JSX.Element => {
  return (
    <Text style={[s.fontBodyLight, t.textBase, s.textTitle, s.pX7, style]}>
      { title }
    </Text>
  )
}

export default PageTitle;
