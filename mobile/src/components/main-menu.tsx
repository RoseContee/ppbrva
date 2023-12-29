import React, { FC, useCallback } from 'react';
import {
  Image,
  ImageSourcePropType,
  Linking,
  TouchableOpacity,
  View
} from 'react-native';
import { DrawerContentComponentProps, DrawerContentScrollView } from '@react-navigation/drawer';
import { useFocusEffect } from '@react-navigation/native';
import { appRoutes, mainRoutes } from '../routes';
import {
  fetchLocation, fetchSocial, logout as requestLogout
} from '../requests';
import { useAppSelector } from '../store';
import { getSocial } from '../store/settings';
import { getLocation } from '../store/user';
import { removeStorage } from '../utils/storage';
import ScalableImage from 'react-native-scalable-image';
import PageTitle from './basic/page-title';
import Card from './basic/card';
import Title from './basic/title';
import IconClose from '../assets/img/icons/close.svg';

import imgClubInfo from '../assets/img/menu/club-info.png';
import imgMembers from '../assets/img/menu/members.png';
import imgKitchenBar from '../assets/img/menu/kitchen-bar.png';
import imgLogout from '../assets/img/menu/logout.png';
import imgLogo from '../assets/img/logo.png';
import imgSocial1 from '../assets/img/social/1.png';
import imgSocial2 from '../assets/img/social/2.png';
import imgSocial3 from '../assets/img/social/3.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

interface MenuItemProps {
  text: string,
  image: ImageSourcePropType,
  onPress: () => void,
}

const MenuItem: FC<MenuItemProps> = ({ text, image, onPress }): JSX.Element => {
  return (
    <TouchableOpacity style={[t.pX1, t.mB6]} onPress={onPress}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY4]}>
        <Title style={[s.textPrimary, t.text3xl]}>{ text }</Title>
        <Image source={image} resizeMode="contain" style={[s.menuImage]} />
      </Card>
    </TouchableOpacity>
  );
}

const MainMenu: FC<DrawerContentComponentProps> = (props): JSX.Element => {
  const location = useAppSelector(getLocation);
  const social = useAppSelector(getSocial);
  const { navigation } = props;
  const social1_link = 'https://twitter.com/PPBRVA/';
  const social2_link = 'https://www.youtube.com/@ppbrva/';
  const social3_link = 'https://www.instagram.com/ppbrva/';

  useFocusEffect(
    useCallback(() => {
      fetchLocation();
      fetchSocial();
    }, [])
  );

  const gotoScreen = (screen: string) => {
    navigation.navigate(screen);
  }

  const logout = async () => {
    removeStorage('access_token');
    navigation.closeDrawer();
    navigation.navigate(appRoutes.AuthScreen);
    requestLogout();
  }

  return (
    <DrawerContentScrollView {...props} contentContainerStyle={[t.minHFull]}>
      <View style={[t.flexGrow, s.pX7]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT4]}>
          <Title style={[t.text3xl]}>Menu</Title>
          <TouchableOpacity onPress={navigation.closeDrawer}>
            <IconClose fill={theme.color.primary}
              width={theme.size.headerIcon} height={theme.size.headerIcon}
            />
          </TouchableOpacity>
        </View>
        <PageTitle style={[t.pX0, t.mT2]}
          title={location.name}
        />
        <View style={[t.mY8]} />
        <MenuItem text="Club Info" image={imgClubInfo}
          onPress={() => gotoScreen(mainRoutes.ClubInfo)}
        />
        <MenuItem text="Members" image={imgMembers}
          onPress={() => gotoScreen(mainRoutes.Members)}
        />
        <MenuItem text="Kitchen/Bar" image={imgKitchenBar}
          onPress={() => gotoScreen(mainRoutes.KitchenBar)}
        />
        <MenuItem text="Logout" image={imgLogout}
          onPress={logout}
        />
      </View>
      <View style={[t.pX4]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyAround, t.pX8, t.mT4]}>
          <ScalableImage source={social.social1_icon ? {uri: social.social1_icon} : imgSocial1}
            height={theme.size.socialIcon}
            onPress={() => Linking.openURL(social.social1_link || social1_link)}
          />
          <ScalableImage source={social.social2_icon ? {uri: social.social2_icon} : imgSocial2}
            height={theme.size.socialIcon}
            onPress={() => Linking.openURL(social.social2_link || social2_link)}
          />
          <ScalableImage source={social.social3_icon ? {uri: social.social3_icon} : imgSocial3}
            height={theme.size.socialIcon}
            onPress={() => Linking.openURL(social.social3_link || social3_link)}
          />
        </View>
        <View style={[t.itemsCenter, t.mY8]}>
          <ScalableImage source={imgLogo} width={theme.size.logo} />
        </View>
      </View>
    </DrawerContentScrollView>
  );
}

export default MainMenu;
