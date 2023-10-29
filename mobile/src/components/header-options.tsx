import React, { FC } from 'react';
import {
  TouchableOpacity,
  View
} from 'react-native';
import { ParamListBase, RouteProp } from '@react-navigation/native';
import { SvgProps } from 'react-native-svg';
import Title from './basic/title';
import IconBack from '../assets/img/icons/back.svg';
import IconMenu from '../assets/img/icons/menu.svg';

import { t } from 'react-native-tailwindcss';
import theme from '../utils/theme';

interface IProps {
	route: RouteProp<ParamListBase, string>,
	navigation: any,
}

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

const HeaderLeft: FC<IProps> = ({ route: { name }, navigation }): JSX.Element => {
  const onBack = () => {
    if (name === 'ResetPassword') {
      navigation.navigate('Login');
    } else if (name === 'SetNewPassword') {
      navigation.navigate('HomeScreen');
    } else if ([
      'MemberProfile', 'BillingProfile', 'MembershipPlan',
    ].includes(name)) {
      navigation.navigate('Profile');
    } else if (name === 'Invoices') {
      navigation.navigate('BillingProfile');
    } else if (name === 'InvoiceDetail') {
      navigation.navigate('Invoices');
    } else if (['PendingRequests', 'AcceptedFriend'].includes(name)) {
      navigation.navigate('Friends');
    } else if (name === 'FriendRequest') {
      navigation.navigate('PendingRequests');
    } else if (name === 'MemberInvite') {
      navigation.navigate('Members');
    } else {
      navigation.goBack();
    }
  };

	return (
		<View style={[t.mL4]}>
			<MenuButton Icon={IconBack} onPress={onBack} />
		</View>
	);
};

const headerTitle: FC<IProps> = (): JSX.Element => {
	return (
		<Title style={[s.screenTitle]}>{ title }</Title>
	);
};


export { HeaderLeft };