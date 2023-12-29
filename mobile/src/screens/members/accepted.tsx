import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import {
  MemberProp, fetchMemberDetail, postMemberRemove, postMemberShareSetting
} from '../../requests';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import ProfileCard from '../../components/basic/profile-card';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
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
  const [member, setMember] = useState<MemberProp>();
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
      fetchMemberDetail(memberID)
        .then(member => {
          if (member.friend_status === 'pending') {
            navigation.navigate({
              name: mainRoutes.FriendRequest,
              params: {
                memberID: member.memberID,
              },
            } as never);
          } else if (member.friend_status !== 'accepted') {
            navigation.navigate({
              name: mainRoutes.MemberInvite,
              params: {
                title: member.name,
                memberID: member.memberID,
              },
            } as never);
          }
          setMember(member);
          setEmailShare(member.my_email_share);
          setPhoneShare(member.my_phone_share);
        })
        .finally(() => setLoading(false));
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate(mainRoutes.Friends as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const onSettingChange = (setting: {email_share: boolean, phone_share: boolean}) => {
    setLoading(true);
    setEmailShare(setting.email_share);
    setPhoneShare(setting.phone_share)
    postMemberShareSetting(memberID, {...setting})
      .finally(() => setLoading(false));
  }

  const onRemoveFriend = () => {
    setLoading(true);
    postMemberRemove(memberID)
      .then(() => {
        setMessage('Member has been removed as a friend!');
        setDisabled(true);
      })
      .finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      {
        !member ? (
          <Message style={[s.mT7]} text={message} />
        ) : (
          <>
            <View style={[s.pX7]}>
              <ProfileCard style={[t.mT8]} member={member} />
              <Title style={[t.textXl, s.mT7]}>Sharing Info:</Title>
            </View>
            <Message style={[t.mT7]} text={message} />
            <View style={[s.pX7]}>
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
              {
                !disabled &&
                <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
                  disabled={member.friend_status !== 'accepted'}
                  onPress={onRemoveFriend}
                >
                  Remove Friend
                </Button>
              }
            </View>
          </>
        )
      }
    </Layouts>
  );
}

export default AcceptedFriend;
