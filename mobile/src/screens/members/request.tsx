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
import MemberCard from '../../components/basic/member-card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
import { MemberProps } from './members';
import IconMail from '../../assets/img/icons/mail.svg';
import IconPhoneCall from '../../assets/img/icons/phone-call.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const FriendRequest: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [loading, setLoading] = useState<boolean>(false);
  const [message, setMessage] = useState<string>();
  const [member, setMember] = useState<MemberProps>();
  const [email_share, setEmailShare] = useState<boolean>(false);
  const [phone_share, setPhoneShare] = useState<boolean>(false);
  const [disabled, setDisabled] = useState<boolean>(false);
  const {memberID} = (route.params as any);

  useFocusEffect(
    useCallback(() => {
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
        } else if (member.friend_status !== 'pending') {
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
        navigation.navigate('PendingRequests' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const onAddFriend = () => {
    setLoading(true);
    axios.post(`members/${memberID}/accept`, {
      email_share,
      phone_share,
    }).then(() => {
      setMessage('Member has been added as a friend!');
      setDisabled(true);
    }).finally(() => setLoading(false));
  }

  const onDecline = () => {
    setLoading(true);
    axios.post(`members/${memberID}/decline`)
    .then(() => {
      setMessage('Invitation has been declined!');
      setDisabled(true);
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      {
        !member ? (
          <Message style={[s.mT7]} text={message} />
        ) : (
          <>
            <View style={[s.pX7]}>
              <MemberCard style={[t.mT5]} member={member} />
              <Text style={[s.fontBodyBold, t.textXl, s.textTitle, t.textCenter, t.mT10]}>
                { member.name } wants to be your friend!
              </Text>
              <Text style={[s.fontBodyLight, t.textLg, s.textGray, t.textCenter, t.mT2]}>
                Choose which contact info you want to share with { member.name }:
              </Text>
              <Title style={[t.textXl, s.mT7]}>Sharing Info:</Title>
            </View>
            <Message style={[s.mT7]} text={message} />
            <View style={[s.pX7]}>
              <Switch style={[t.pX1, s.mT7]}
                labelStyle={[s.textGray]}
                Icon={() => (
                  <IconMail fill={theme.color.primary}
                    width={theme.size.headerIcon} height={theme.size.headerIcon}
                  />
                )}
                label={ member.email_share ? member.email : 'Not Shared' }
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
                label={ member.phone_share ? member.phone : 'Not Shared' }
                value={phone_share}
                onChange={setPhoneShare}
              />
              {
                !disabled &&
                <>
                  <Button style={[s.bgPrimary, t.mT10]}
                    disabled={member.friend_status !== 'pending'}
                    onPress={onAddFriend}
                  >
                    Add { member.name }
                  </Button>
                  <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
                    disabled={member.friend_status !== 'pending'}
                    onPress={onDecline}
                  >
                    Decline
                  </Button>
                </>
              }
              <View style={[t.mY8]} />
              <View style={[t.flexRow, t.itemsCenter, t.justifyCenter]}>
                <View style={[s.dot, t.mX1]} />
                <View style={[s.dot, s.bgPrimary, t.mX1]} />
                <View style={[s.dot, t.mX1]} />
              </View>
            </View>
          </>
        )
      }
    </Layouts>
  );
};

export default FriendRequest;
