import React, { FC } from 'react';
import {
  TouchableOpacity,
  View
} from 'react-native';
import { DrawerActions } from '@react-navigation/native';
import { StackHeaderProps } from '@react-navigation/stack';
import { BottomTabHeaderProps } from "@react-navigation/bottom-tabs";
import { SvgProps } from 'react-native-svg';
import Title from '../basic/title';
import IconBack from '../../assets/img/icons/back.svg';
import IconMenu from '../../assets/img/icons/menu.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface MenuButtonProps {
  Icon: FC<SvgProps>,
  onPress: () => void,
}

const MenuButton: FC<MenuButtonProps> = ({ Icon, onPress }): JSX.Element => {
  return (
    <TouchableOpacity onPress={onPress}>
      <Icon fill={theme.color.primary}
        width={theme.size.headerIcon} height={theme.size.headerIcon}
      />
    </TouchableOpacity>
  );
};

const Header: FC<StackHeaderProps | BottomTabHeaderProps> = (props): JSX.Element => {
  //console.log(props.route);
  const navigation = props.navigation;
  const route = props.route.name;
  const title = props.options.title;
  const showBack = ![
    'Activity', 'Friends', 'Dashboard', 'Events', 'Profile',
    'ClubInfo', 'Members', 'MembersRequest', 'KitchenBar',
  ].includes(route);
  const showMenu = ![
    'Login', 'ForgotPassword', 'EnterCode', 'ResetPassword'
  ].includes(route);

  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.bgWhite, t.p4, t.pB2]}>
      {
        showBack &&
        <MenuButton Icon={IconBack} onPress={navigation.goBack} />
      }
      <Title style={[s.screenTitle]}>{ title }</Title>
      {
        showMenu ?
          <MenuButton Icon={IconMenu}
            onPress={() => navigation.dispatch(DrawerActions.openDrawer())}
          />
        :
        <View style={{width: theme.size.headerIcon, height: theme.size.headerIcon}} />
      }
    </View>
  );
};

export default Header;
