import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import Layouts from '../../components/layouts/home';
import ProfileCard from '../../components/basic/profile-card';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
import IconMail from '../../assets/img/icons/mail.svg';
import IconPhoneCall from '../../assets/img/icons/phone-call.svg';
import { MemberProps } from './members';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const AcceptedFriend: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const member = (route.params as any)?.member as MemberProps;

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Friends' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <View style={[s.pX7]}>
        <ProfileCard style={[t.mT8]}
          image={member.avatar} dupr={member.dupr} gender={member.gender} age={member.age}
          matches={member.matches} wins={member.wins} losses={member.losses}
        />
        {
          member.email &&
          <View style={[t.flexRow, t.itemsCenter, t.pX1, t.mT8]}>
            <IconMail fill={theme.color.primary}
              width={theme.size.headerIcon} height={theme.size.headerIcon}
            />
            <Switch style={[t.justifyBetween, t.flexGrow, t.pL2]}
              labelStyle={[t.textLg, s.textTitle]}
              label={ member.email }
              labelPosition="left"
              //value={true}
              onChange={() => {}}
            />
          </View>
        }
        {
          member.phone &&
          <View style={[t.flexRow, t.itemsCenter, t.pX1, t.mT5]}>
            <IconPhoneCall fill={theme.color.primary}
              width={theme.size.headerIcon} height={theme.size.headerIcon}
            />
            <Switch style={[t.justifyBetween, t.flexGrow, t.pL2]}
              labelStyle={[t.textLg, s.textTitle]}
              label={ member.phone }
              labelPosition="left"
              //value={true}
              onChange={() => {}}
            />
          </View>
        }
        <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
          onPress={() => navigation.navigate('Friends' as never)}
        >
          Remove Friend
        </Button>
      </View>
    </Layouts>
  );
};

export default AcceptedFriend;
