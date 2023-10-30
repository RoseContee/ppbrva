import React, { FC } from 'react';
import {
	StyleProp,
  TouchableOpacity,
  View,
	ViewStyle
} from 'react-native';
import {
	DrawerActions,
	ParamListBase,
	RouteProp
} from '@react-navigation/native';
import { StackNavigationOptions } from '@react-navigation/stack';
import { BottomTabNavigationOptions } from '@react-navigation/bottom-tabs';
import Title from './basic/title';
import IconBack from '../assets/img/icons/back.svg';
import IconMenu from '../assets/img/icons/menu.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

interface IHeaderButtonProps {
	route: RouteProp<ParamListBase, string>,
	navigation: any,
}

const HeaderLeft: FC<IHeaderButtonProps> = ({ route, navigation }): JSX.Element => {
  const onBack = () => {
    if (route.name === 'ResetPassword') {
      navigation.navigate('Login');
    } else if (route.name === 'SetNewPassword') {
      navigation.navigate('HomeScreen');
    } else if ([
      'MemberProfile', 'BillingProfile', 'MembershipPlan',
    ].includes(route.name)) {
      navigation.navigate('Profile');
    } else if (route.name === 'Invoices') {
      navigation.navigate('BillingProfile');
    } else if (route.name === 'InvoiceDetail') {
      navigation.navigate('Invoices');
    } else if ([
			'PendingRequests', 'AcceptedFriend'
		].includes(route.name)) {
      navigation.navigate('Friends');
    } else if (route.name === 'FriendRequest') {
      navigation.navigate('PendingRequests');
    } else if (route.name === 'MemberInvite') {
      navigation.navigate('Members');
    } else {
      navigation.goBack();
    }
  };

	return (
		<View style={[t.mL4]}>
			<TouchableOpacity onPress={onBack}>
				<IconBack fill={theme.color.primary}
					width={theme.size.headerIcon} height={theme.size.headerIcon}
				/>
			</TouchableOpacity>
		</View>
	);
};

const HeaderRight: FC<IHeaderButtonProps> = ({ navigation }): JSX.Element => {
	return (
		<View style={[t.mR4]}>
			<TouchableOpacity onPress={() => navigation.dispatch(DrawerActions.openDrawer())}>
				<IconMenu fill={theme.color.primary}
					width={theme.size.headerIcon} height={theme.size.headerIcon}
				/>
			</TouchableOpacity>
		</View>
	);
};

interface IHeaderTitleProps {
	title: string,
	style?: StyleProp<ViewStyle>,
}

const HeaderTitle: FC<IHeaderTitleProps> = ({ title, style }): JSX.Element => {
	return (
		<Title style={[s.screenTitle, style]}>{ title }</Title>
	);
};

const HeaderOptions = ({
	route, navigation
}: {
	route: RouteProp<ParamListBase, string>,
	navigation: any,
}) => {
	return {
		headerShadowVisible: false,
		headerStyle: {height: theme.size.headerHeight},
		headerLeftContainerStyle: {...t.justifyEnd, ...t.pB2},
		headerLeft: () => <HeaderLeft route={route} navigation={navigation} />,
		headerTitleAlign: 'center',
		headerTitleContainerStyle: {...t.justifyEnd, ...t.pB2},
		headerTitle: ({ children }) => <HeaderTitle title={children} />,
		headerRightContainerStyle: {...t.justifyEnd, ...t.pB2},
		headerRight: () => <HeaderRight route={route} navigation={navigation} />
	} as StackNavigationOptions | BottomTabNavigationOptions;
};

export const HideLeftButton = {
	headerLeft: () => <></>,
	headerTitleAlign: 'left',
	headerLeftContainerStyle: {...t.pL3},
} as BottomTabNavigationOptions;

export default HeaderOptions;
