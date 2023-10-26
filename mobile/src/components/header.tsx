import React, { FC } from 'react';
import {
  TouchableOpacity,
  View
} from 'react-native';
import { DrawerActions } from '@react-navigation/native';
import { StackHeaderProps } from '@react-navigation/stack';
import { BottomTabHeaderProps } from "@react-navigation/bottom-tabs";
import { SvgProps } from 'react-native-svg';
import Title from './basic/title';
import IconBack from '../assets/img/icons/back.svg';
import IconMenu from '../assets/img/icons/menu.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

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
  const navigation = props.navigation;
  const route = props.route.name;
  const title = (props.route.params as any)?.headerTitle || props.options.title;
  const showBack = ![
    'Activity', 'Friends', 'Dashboard', 'Events', 'Profile',
    'ClubInfo', 'Members', 'KitchenBar', 'PendingRequests', 'FriendRequest',
  ].includes(route);
  const showMenu = ![
    'Login', 'ForgotPassword', 'EnterCode', 'ResetPassword', 'SetNewPassword'
  ].includes(route);

  const onBack = () => {
    if (route === 'ResetPassword') {
      navigation.navigate('Login');
    } else if (route === 'SetNewPassword') {
      navigation.navigate('HomeScreen');
    } else if ([
      'MemberProfile', 'BillingProfile', 'MembershipPlan',
    ].includes(route)) {
      navigation.navigate('Profile');
    } else if (route === 'Invoices') {
      navigation.navigate('BillingProfile');
    } else if (route === 'InvoiceDetail') {
      navigation.navigate('Invoices');
    } else if (['PendingRequests', 'AcceptedFriend'].includes(route)) {
      navigation.navigate('Friends');
    } else if (route === 'FriendRequest') {
      navigation.navigate('PendingRequests');
    } else if (route === 'MemberInvite') {
      navigation.navigate('Members');
    } else {
      navigation.goBack();
    }
  };

  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.bgWhite, t.pX4, t.pT8, t.pB2, [!showBack && s.pL7]]}>
      {
        showBack &&
        <MenuButton Icon={IconBack} onPress={onBack} />
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
