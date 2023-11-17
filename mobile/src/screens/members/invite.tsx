import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import {
  useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
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

const MemberInvite: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState<boolean>(false);
  const [message, setMessage] = useState<string>();
  const [member, setMember] = useState<MemberProps>();
  const [email_share, setEmailShare] = useState<boolean>(true);
  const [phone_share, setPhoneShare] = useState<boolean>(true);
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
        if (member.friend_status === 'accepted') {
          navigation.navigate({
            name: 'AcceptedFriend',
            params: {
              title: member.name,
              memberID: member.memberID,
            },
          } as never);
        } else if (member.friend_status === 'pending') {
          navigation.navigate({
            name: 'FriendRequest',
            params: {
              memberID: member.memberID,
            },
          } as never);
        } else if (member.friend_status === 'waiting') {
          setMessage('You have already sent a friend invitation.');
        } else {
          const isMale = member.profile.gender.toLowerCase() === 'male';
          setMessage(`If ${ member.name } accepts, ${isMale ? 'he' : 'she'} will appear as a Friend!`);
        }
        setMember(member);
      }).catch(() => {
        setMessage('Something went wrong.');
      }).finally(() => setLoading(false));
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Members' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const onAddFriend = () => {
    setLoading(true);
    axios.post(`members/${memberID}/invite`, {
      email_share,
      phone_share,
    }).then(() => {
      setMessage('Your invitation has been sent!');
      setDisabled(true);
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <Message style={[s.mT7]} text={message} />
      {
        member ? (
          <View style={[s.pX7]}>
            <ProfileCard style={[t.mT8]} member={member} />
            <Switch style={[t.pX1, s.mT7]}
              labelStyle={[s.textGray]}
              Icon={() => (
                <IconMail fill={theme.color.primary}
                  width={theme.size.headerIcon} height={theme.size.headerIcon}
                />
              )}
              label={ email_share ? me.email : 'Not Shared' }
              value={email_share}
              onChange={setEmailShare}
            />
            <Switch style={[t.pX1, s.mT7]}
              labelStyle={[s.textGray]}
              Icon={() => (
                <IconPhoneCall fill={theme.color.primary}
                  width={theme.size.headerIcon} height={theme.size.headerIcon}
                />
              )}
              label={ phone_share ? me.phone : 'Not Shared' }
              value={phone_share}
              onChange={setPhoneShare}
            />
            <Button style={[s.bgPrimary, s.mT7]}
              disabled={!!member.friend_status || disabled}
              onPress={onAddFriend}
            >
              Add Friend
            </Button>
          </View>
        ) : (<></>)
      }
    </Layouts>
  );
};

export default MemberInvite;
