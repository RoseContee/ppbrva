import React, { FC } from 'react';
import {
  StyleProp,
  TouchableOpacity,
  View,
ViewStyle
} from 'react-native';
import { DrawerActions, ParamListBase, RouteProp } from '@react-navigation/native';
import Title from './basic/title';
import IconBack from '../assets/img/icons/back.svg';
import IconMenu from '../assets/img/icons/menu.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';
import { appRoutes, authRoutes, invoiceRoutes, mainRoutes } from '../routes';
import { useAppSelector } from '../store';
import { getFirstPayment } from '../store/user';
import { fetchLocation, fetchSocial } from '../requests';

interface IHeaderButtonProps {
  route: RouteProp<ParamListBase, string>,
  navigation: any,
}

const HeaderLeft: FC<IHeaderButtonProps> = ({ route, navigation }): JSX.Element => {
  const gotoScreen = (screen: string) => {
    navigation.navigate(screen);
  }

  const onBack = () => {
    if (route.name === authRoutes.ResetPassword) {
      gotoScreen(authRoutes.Login);
    } else if (route.name === appRoutes.SetNewPassword) {
      gotoScreen(appRoutes.HomeScreen);
    } else if ([
      mainRoutes.MemberProfile, mainRoutes.BillingProfile, mainRoutes.MembershipPlan,
    ].includes(route.name)) {
      gotoScreen(mainRoutes.Profile);
    } else if (route.name === invoiceRoutes.Invoices) {
      gotoScreen(mainRoutes.BillingProfile);
    } else if ([
      mainRoutes.ProfileInviteMember, mainRoutes.FamilyMemberProfile,
    ].includes(route.name)) {
      gotoScreen(mainRoutes.MembershipPlan);
    } else if ([
      mainRoutes.PendingRequests, mainRoutes.AcceptedFriend,
    ].includes(route.name)) {
      gotoScreen(mainRoutes.Friends);
    } else if (route.name === mainRoutes.FriendRequest) {
      gotoScreen(mainRoutes.PendingRequests);
    } else if (route.name === mainRoutes.MemberInvite) {
      gotoScreen(mainRoutes.Members);
    } else {
      navigation.goBack();
    }
  }

  return (
    <View style={[t.mL4]}>
      <TouchableOpacity onPress={onBack}>
        <IconBack fill={theme.color.primary}
          width={theme.size.headerIcon} height={theme.size.headerIcon}
        />
      </TouchableOpacity>
    </View>
  );
}

const HeaderRight: FC<IHeaderButtonProps> = ({ navigation }): JSX.Element => {
  const first_payment = useAppSelector(getFirstPayment);

  const onMenuOpen = () => {
    if (first_payment) {
      navigation.navigate(mainRoutes.FirstPayment);
    } else {
      navigation.dispatch(DrawerActions.openDrawer());
      fetchLocation();
      fetchSocial();
    }
  }

  return (
    <View style={[t.mR4]}>
      <TouchableOpacity onPress={onMenuOpen}>
        <IconMenu fill={theme.color.primary}
          width={theme.size.headerIcon} height={theme.size.headerIcon}
        />
      </TouchableOpacity>
    </View>
  );
}

interface IHeaderTitleProps {
  title: string,
  style?: StyleProp<ViewStyle>,
}

const HeaderTitle: FC<IHeaderTitleProps> = ({ title, style }): JSX.Element => {
  return (
    <Title style={[s.screenTitle, style]}>{ title }</Title>
  );
}

const HeaderOptions = ({
  route, navigation
}: {
  route: RouteProp<ParamListBase, string>,
  navigation: any,
}) => {
  return {
    headerShadowVisible: false,
    headerLeft: () => <HeaderLeft route={route} navigation={navigation} />,
    headerTitleAlign: 'center',
    headerTitle: ({ children }: { children: string }) => <HeaderTitle title={children} />,
    headerRight: () => <HeaderRight route={route} navigation={navigation} />
  }
}

export const HideLeftButton = {
  headerLeft: () => <></>,
  headerTitleAlign: 'left',
  headerLeftContainerStyle: {...t.pL3},
}

export default HeaderOptions;
