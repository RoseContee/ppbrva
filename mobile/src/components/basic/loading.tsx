import React, { FC } from 'react';
import {
  ActivityIndicator,
  StyleProp,
  View,
  ViewStyle
} from 'react-native';

import s from '../../utils/styles';
import theme from '../../utils/theme';

interface IProps {
  show?: boolean,
  style?: StyleProp<ViewStyle>,
  size?: 'small' | 'large'
}

const Loading: FC<IProps> = ({ show, style, size }): JSX.Element => {
  return (
    <>
      {
        show &&
        <View style={[s.loadingContainer, style]}>
          <View style={[s.loadingOverlay]} />
          <ActivityIndicator
            size={size || 'large'}
            color={theme.color.primary}
          />
        </View>
      }
    </>
  );
};

export default Loading;
