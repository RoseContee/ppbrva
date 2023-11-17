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

interface ILabelProps {
  right?: true,
  Icon?: () => JSX.Element,
  iconRight?: true,
  text: string,
  style?: StyleProp<TextStyle>,
}

const Label: FC<ILabelProps> = ({
  right,
  Icon,
  iconRight,
  text,
  style,
}): JSX.Element => {
  return (
    <View style={[t.flexShrink, t.flexRow, !right ? t.pR8 : t.pL3]}>
      {
        !iconRight && Icon &&
        <Icon />
      }
      <Text style={[t.textLg, !iconRight ? t.pL2 : t.pR2, style]}>
        { text }
      </Text>
      {
        iconRight && Icon &&
        <Icon />
      }
    </View>
  );
}

interface IProps {
  value?: boolean,
  onChange?: (value: boolean) => void,
  style?: StyleProp<ViewStyle>,
  Icon?: () => JSX.Element,
  iconRight?: true,
  label: string,
  labelRight?: true,
  labelStyle?: StyleProp<TextStyle>,
}

const Switch: FC<IProps> = ({
  value,
  onChange,
  style,
  Icon,
  iconRight,
  label,
  labelRight,
  labelStyle,
}): JSX.Element => {
  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, style]}>
      {
        !labelRight &&
        <Label right={labelRight}
          Icon={Icon}
          iconRight={iconRight}
          text={label}
          style={labelStyle}
        />
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
        labelRight && 
        <Label right={labelRight}
          Icon={Icon}
          iconRight={iconRight}
          text={label}
          style={labelStyle}
        />
      }
    </View>
  )
}

export default Switch;
