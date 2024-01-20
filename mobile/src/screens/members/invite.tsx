import React, { FC, useCallback, useEffect, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { MemberProp, postMemberInvite } from '../../requests';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
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

const MemberInvite: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState<boolean>(false);
  const [message, setMessage] = useState<string>();
  const [email_share, setEmailShare] = useState<boolean>(true);
  const [phone_share, setPhoneShare] = useState<boolean>(true);
  const [disabled, setDisabled] = useState<boolean>(false);
  const { member } = route.params as { member: MemberProp };

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate(mainRoutes.Members as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  useEffect(() => {
    navigation.setOptions({ title: member.name });
    const disabled = member.friend_status === 'waiting';
    setLoading(false);
    setMessage(disabled ? `If ${ member.name } accepts, they will appear as a Friend!` : '');
    setEmailShare(true);
    setPhoneShare(true);
    setDisabled(disabled);
  }, [member]);

  const onAddFriend = () => {
    setLoading(true);
    postMemberInvite(member.memberID, { email_share, phone_share })
      .then(() => {
        setMessage('Your invitation has been sent!');
        setDisabled(true);
      })
      .finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[s.pX7]}>
        <ProfileCard style={[t.mT8]} member={member} />
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
          label={ email_share ? me.email : 'Not Shared' }
          disabled={disabled}
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
          disabled={disabled}
          value={phone_share}
          onChange={setPhoneShare}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          disabled={disabled}
          onPress={onAddFriend}
        >
          { disabled ? 'Friend invite pending...' : 'Add Friend' }
        </Button>
      </View>
    </Layouts>
  );
}

export default MemberInvite;
