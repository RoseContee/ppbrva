import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import {
  useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import axios from '../../utils/axios';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import ProfileCard from '../../components/basic/profile-card';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
import { MemberProps } from './members';
import IconMail from '../../assets/img/icons/mail.svg';
import IconPhoneCall from '../../assets/img/icons/phone-call.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const AcceptedFriend: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [loading, setLoading] = useState<boolean>(false);
  const [message, setMessage] = useState<string>();
  const [member, setMember] = useState<MemberProps>();
  const [email_share, setEmailShare] = useState<boolean>(false);
  const [phone_share, setPhoneShare] = useState<boolean>(false);
  const [disabled, setDisabled] = useState<boolean>(false);
  const {title, memberID} = (route.params as any);

  useFocusEffect(
    useCallback(() => {
      navigation.setOptions({title: title});
      setMessage('');
      setDisabled(false);
      setLoading(true);
      axios.get(`members/${memberID}`)
      .then(({ data }) => {
        const member = data.member as MemberProps;
        if (member.friend_status === 'pending') {
          navigation.navigate({
            name: 'FriendRequest',
            params: {
              memberID: member.memberID,
            },
          } as never);
        } else if (member.friend_status !== 'accepted') {
          navigation.navigate({
            name: 'MemberInvite',
            params: {
              title: member.name,
              memberID: member.memberID,
            },
          } as never);
        }
        setMember(member);
        setEmailShare(member.my_email_share);
        setPhoneShare(member.my_phone_share);
      }).catch(() => {
        setMessage('Something went wrong.');
      }).finally(() => setLoading(false));
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Friends' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const onSettingChange = (setting: {email_share: boolean, phone_share: boolean}) => {
    setLoading(true);
    setEmailShare(setting.email_share);
    setPhoneShare(setting.phone_share)
    axios.post(`members/${memberID}/share-setting`, {
      ...setting
    }).finally(() => setLoading(false));
  }

  const onRemoveFriend = () => {
    setLoading(true);
    axios.post(`members/${memberID}/remove`)
    .then(() => {
      setMessage('Member has been removed as a friend!');
      setDisabled(true);
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <Message style={[t.mT8]} text={message} />
      {
        member ? (
          <View style={[s.pX7]}>
            <ProfileCard style={[t.mT8]} member={member} />
            <Switch style={[t.pX1, s.mT7]}
              labelStyle={[s.textTitle]}
              Icon={() => (
                <IconMail fill={theme.color.primary}
                  width={theme.size.headerIcon} height={theme.size.headerIcon}
                />
              )}
              label={ member.email_share ? member.email : 'Not Shared' }
              value={email_share}
              onChange={() => {
                onSettingChange({
                  email_share: !email_share,
                  phone_share,
                });
              }}
            />
            <Switch style={[t.pX1, s.mT7]}
              labelStyle={[s.textTitle]}
              Icon={() => (
                <IconPhoneCall fill={theme.color.primary}
                  width={theme.size.headerIcon} height={theme.size.headerIcon}
                />
              )}
              label={ member.phone_share ? member.phone : 'Not Shared' }
              value={phone_share}
              onChange={() => {
                onSettingChange({
                  email_share,
                  phone_share: !phone_share,
                });
              }}
            />
            <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
              disabled={member.friend_status !== 'accepted' || disabled}
              onPress={onRemoveFriend}
            >
              Remove Friend
            </Button>
          </View>
        ) : (<></>)
      }
    </Layouts>
  );
};

export default AcceptedFriend;
