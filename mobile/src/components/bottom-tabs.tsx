import React, { FC } from 'react';
import {
  ColorValue,
  TouchableOpacity,
  View
} from 'react-native';
import { BottomTabBarProps } from "@react-navigation/bottom-tabs";
import { SvgProps } from 'react-native-svg';
import Image from 'react-native-scalable-image';
import Text from './basic/text';
import IconActivity from '../assets/img/icons/activity.svg';
import IconFriends from '../assets/img/icons/friends.svg';
import IconEvents from '../assets/img/icons/events.svg';
import IconProfile from '../assets/img/icons/profile.svg';

import imgLogo from '../assets/img/logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

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
    <TouchableOpacity style={[t.itemsCenter]} onPress={onPress}>
      <Icon fill={color}
        width={theme.size.bottomIcon} height={theme.size.bottomIcon}
      />
      <Text style={[s.fontBodyLight, {color: color}, t.textSm, t.mT1]}>
        { text }
      </Text>
    </TouchableOpacity>
  );
};

const BottomTabs: FC<BottomTabBarProps> = (props): JSX.Element => {
  const { navigation, state: { index } } = props;

  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.bgWhite, t.pX6, t.pT3, t.pB5]}>
      <MenuItem Icon={IconActivity} text="Activity"
        color={index === 1 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Activity')}
      />
      <MenuItem Icon={IconFriends} text="Friends"
        color={2 <= index && index <= 5 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Friends')}
      />
      <Image source={imgLogo} height={78}
        onPress={() => navigation.navigate('Dashboard')}
      />
      <MenuItem Icon={IconEvents} text="Events"
        color={index === 6 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Events')}
      />
      <MenuItem Icon={IconProfile} text="Profile"
        color={7 <= index && index <= 12 ? theme.color.active : theme.color.title}
        onPress={() => navigation.navigate('Profile')}
      />
    </View>
  );
};

export default BottomTabs;
