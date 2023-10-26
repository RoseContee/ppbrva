import React, { FC } from 'react';
import {
  StyleProp,
  TextStyle,
  View,
  ViewStyle
} from 'react-native';
import { Switch as NativeSwitch } from 'react-native-switch';
import Text from './text';

import { t } from 'react-native-tailwindcss';
import theme from '../../utils/theme';

interface IProps {
  value?: boolean,
  onChange?: (value: boolean) => void,
  style?: StyleProp<ViewStyle>,
  label?: string,
  labelPosition?: 'left',
  labelStyle?: StyleProp<TextStyle>,
}

const Switch: FC<IProps> = ({
  value,
  onChange,
  style,
  label,
  labelPosition,
  labelStyle,
}): JSX.Element => {
  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyCenter, style]}>
      {
        label && labelPosition === 'left' &&
        <Text style={[t.textXs, t.pR3, labelStyle]}>
          { label }
        </Text>
      }
      <NativeSwitch
        activeText=""
        inActiveText=""
        backgroundActive={theme.color.active}
        backgroundInactive={theme.color.inactive}
        circleSize={18}
        barHeight={26}
        switchLeftPx={2}
        switchRightPx={2}
        circleBorderWidth={0}
        changeValueImmediately={true}
        switchWidthMultiplier={3}
        value={value}
        onValueChange={onChange}
      />
      {
        label && !labelPosition &&
        <Text style={[t.textLg, t.pL3, labelStyle]}>
          { label }
        </Text>
      }
    </View>
  )
}

export default Switch;
