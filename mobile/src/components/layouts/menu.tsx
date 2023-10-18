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
import { useAppDispatch } from '../../store';
import { SaveAccessToken } from '../../store/user';
import { removeStorage } from '../../utils/storage';
import axios from '../../utils/axios';
import ScalableImage from 'react-native-scalable-image';
import Card from '../basic/card';
import Title from '../basic/title';
import Text from '../basic/text';
import IconClose from '../../assets/img/icons/close.svg';
import IconTwitter from '../../assets/img/icons/twitter.svg';
import IconYoutube from '../../assets/img/icons/youtube.svg';
import IconInstagram from '../../assets/img/icons/instagram.svg';

import imgClubInfo from '../../assets/img/menu/club-info.png';
import imgMembers from '../../assets/img/menu/members.png';
import imgKitchenBar from '../../assets/img/menu/kitchen-bar.png';
import imgLogout from '../../assets/img/menu/logout.png';
import imgLogo from '../../assets/img/logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface MenuItemProps {
  text: string,
  image: ImageSourcePropType,
  onPress: () => void,
}

const MenuItem: FC<MenuItemProps> = ({ text, image, onPress }): JSX.Element => {
  return (
    <TouchableOpacity style={[t.pX1, t.mB4]} onPress={onPress}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pX4]}>
        <Title style={[s.textPrimary, t.textXl]}>{ text }</Title>
        <Image source={image} resizeMode="contain" style={[s.menuImage]} />
      </Card>
    </TouchableOpacity>
  );
};

const Menu: FC<DrawerContentComponentProps> = (props): JSX.Element => {
  const dispatch = useAppDispatch();
  const { navigation } = props;
  const name = 'Richmond West';

  const logout = () => {
    axios.get(`/logout`);
    dispatch(SaveAccessToken(null));
    removeStorage('access_token');
    navigation.navigate('AuthScreen');
  };

  return (
    <DrawerContentScrollView {...props} contentContainerStyle={[t.minHFull]}>
      <View style={[t.flexGrow, t.pX4]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT4]}>
          <Title style={[t.textLg]}>Menu</Title>
          <TouchableOpacity onPress={navigation.closeDrawer}>
            <IconClose fill={theme.color.primary}
              width={theme.size.headerIcon} height={theme.size.headerIcon}
            />
          </TouchableOpacity>
        </View>
        <Text style={[s.fontBodyLight, t.textXs, s.textTitle, t.mT2]}>{ name }</Text>

        <View style={[t.mT8]} />

        <MenuItem text="Club Info" image={imgClubInfo}
          onPress={() => navigation.navigate('ClubInfo')}
        />
        <MenuItem text="Members" image={imgMembers}
          onPress={() => navigation.navigate('MembersScreen')}
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
        <View style={[t.itemsCenter, t.mY6]}>
          <ScalableImage source={imgLogo} width={theme.size.logo} />
        </View>
      </View>
    </DrawerContentScrollView>
  )
};

export default Menu;
