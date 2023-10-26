import React, { FC } from 'react';
import {
  Image,
  ImageSourcePropType,
  TouchableOpacity,
  View
} from 'react-native';
import {
  DrawerContentComponentProps,
  DrawerContentScrollView
} from '@react-navigation/drawer';
import { useAppDispatch, useAppSelector } from '../store';
import { saveAccessToken, getMe } from '../store/user';
import { removeStorage } from '../utils/storage';
import axios from '../utils/axios';
import ScalableImage from 'react-native-scalable-image';
import PageTitle from './basic/page-title';
import Card from './basic/card';
import Title from './basic/title';
import IconClose from '../assets/img/icons/close.svg';
import IconTwitter from '../assets/img/icons/twitter.svg';
import IconYoutube from '../assets/img/icons/youtube.svg';
import IconInstagram from '../assets/img/icons/instagram.svg';

import imgClubInfo from '../assets/img/menu/club-info.png';
import imgMembers from '../assets/img/menu/members.png';
import imgKitchenBar from '../assets/img/menu/kitchen-bar.png';
import imgLogout from '../assets/img/menu/logout.png';
import imgLogo from '../assets/img/logo.png';

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
};

const MainMenu: FC<DrawerContentComponentProps> = (props): JSX.Element => {
  const me = useAppSelector(getMe);
  const dispatch = useAppDispatch();
  const { navigation } = props;

  const logout = async () => {
    removeStorage('access_token');
    navigation.closeDrawer();
    navigation.navigate('AuthScreen');
    axios.get(`/logout`).finally(() => {
      dispatch(saveAccessToken(null));
    });
  };

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
          title={me.name}
        />
        <View style={[t.mY8]} />
        <MenuItem text="Club Info" image={imgClubInfo}
          onPress={() => navigation.navigate('ClubInfo')}
        />
        <MenuItem text="Members" image={imgMembers}
          onPress={() => navigation.navigate('Members')}
        />
        <MenuItem text="Kitchen/Bar" image={imgKitchenBar}
          onPress={() => navigation.navigate('KitchenBar')}
        />
        <MenuItem text="Logout" image={imgLogout}
          onPress={logout}
        />
      </View>
      <View style={[t.pX4]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyAround, t.pX8, t.mT4]}>
          <IconTwitter fill={theme.color.social}
            width={theme.size.socialIcon} height={theme.size.socialIcon}
          />
          <IconYoutube stroke={theme.color.social}
            width={theme.size.socialIcon} height={theme.size.socialIcon}
          />
          <IconInstagram fill={theme.color.social}
            width={theme.size.socialIcon} height={theme.size.socialIcon}
          />
        </View>
        <View style={[t.itemsCenter, t.mY8]}>
          <ScalableImage source={imgLogo} width={theme.size.logo} />
        </View>
      </View>
    </DrawerContentScrollView>
  );
};

export default MainMenu;
