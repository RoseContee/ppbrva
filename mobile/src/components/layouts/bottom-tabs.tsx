import React, { FC } from 'react';
import {
  ColorValue,
  TouchableOpacity,
  View
} from 'react-native';
import { BottomTabBarProps } from "@react-navigation/bottom-tabs";
import { SvgProps } from 'react-native-svg';
import Image from 'react-native-scalable-image';
import Text from '../basic/text';
import IconActivity from '../../assets/img/icons/activity.svg';
import IconFriends from '../../assets/img/icons/friends.svg';
import IconEvents from '../../assets/img/icons/events.svg';
import IconProfile from '../../assets/img/icons/profile.svg';

import imgLogo from '../../assets/img/logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface MenuItemProps {
  color: ColorValue,
  Icon: FC<SvgProps>,
  text: string,
  onPress: () => void,
}

const MenuItem: FC<MenuItemProps> = ({
  color,
  Icon,
  text,
  onPress
}): JSX.Element => {
  return (
    <TouchableOpacity style={[t.itemsCenter, t.mT3, t.mB2]} onPress={onPress}>
      <Icon fill={color}
        width={theme.size.bottomIcon} height={theme.size.bottomIcon}
      />
      <Text style={[s.fontBodyLight, {color: color}, s.textTiny, t.mT1]}>
        { text }
      </Text>
    </TouchableOpacity>
  );
};

const BottomTabs: FC<BottomTabBarProps> = (props): JSX.Element => {
  const { navigation, state: { index } } = props;

  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.bgWhite, t.pX2]}>
      <MenuItem Icon={IconActivity} text="Activity"
        color={index === 1 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Activity')}
      />
      <MenuItem Icon={IconFriends} text="Friends"
        color={index === 2 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Friends')}
      />
      <Image source={imgLogo} height={52}
        onPress={() => navigation.navigate('Dashboard')}
      />
      <MenuItem Icon={IconEvents} text="Events"
        color={index === 3 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Events')}
      />
      <MenuItem Icon={IconProfile} text="Profile"
        color={index === 4 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('ProfileScreen')}
      />
    </View>
  );
};

export default BottomTabs;
