import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { postAddChildMember, postInviteMember } from '../../requests';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Link from '../../components/basic/link';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const InviteMember: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const [loading, setLoading] = useState(false);
  const [inviteMsg, setInviteMsg] = useState('');
  const [email, setEmail] = useState('');
  const [openAddForm, setOpenAddForm] = useState(false);
  const [addMsg, setAddMsg] = useState('');
  const [firstname, setFirstname] = useState('');
  const [lastname, setLastname] = useState('');
  const [dob, setDob] = useState('');

  const gotoMembershipPlan = () => {
    navigation.navigate(mainRoutes.MembershipPlan as never);
  }

  useFocusEffect(
    useCallback(() => {
      initStates();
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        gotoMembershipPlan();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const initStates = () => {
    setInviteMsg('');
    setEmail('');
    setOpenAddForm(false);
    setAddMsg('');
    setFirstname('');
    setLastname('');
    setDob('');
  }

  const onInvite = () => {
    setLoading(true);
    setInviteMsg('');
    postInviteMember({ email })
      .then(() => {
        setInviteMsg('Invite sent successfully!');
        setEmail('');
      })
      .catch(setInviteMsg)
      .finally(() => setLoading(false));
  }

  const onAddMember = () => {
    setLoading(true);
    setAddMsg('');
    postAddChildMember({ firstname, lastname, dob })
      .then(() => {
        setAddMsg('New member has been added successfully.');
        gotoMembershipPlan();
      })
      .catch(setAddMsg)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <Message style={[t.mT6]} text={inviteMsg} />
      <View style={[s.pX7]}>
        <TextInput inputMode="email" style={[s.input, s.mT7]}
          keyboardType="email-address"
          placeholder="Email..." placeholderTextColor={theme.color.placeholder}
          value={email} onChangeText={setEmail}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          disabled={!email}
          onPress={onInvite}
        >
          Send Invite
        </Button>
        <Title style={[t.textXl, t.textCenter, s.mT7]}>OR</Title>
        {
          !openAddForm &&
          <Link style={[t.textBase, t.noUnderline, t.textCenter, t.mT3]}
            onPress={() => setOpenAddForm(true)}
          >
            Create Child Account (No Email)
          </Link>
        }
      </View>
      {
        openAddForm &&
        <>
          <Message style={[t.mT6]} text={addMsg} />
          <View style={[s.pX7]}>
            <TextInput inputMode="text" style={[s.input, s.mT7]}
              placeholder="First Name..." placeholderTextColor={theme.color.placeholder}
              value={firstname} onChangeText={setFirstname}
            />
            <TextInput inputMode="text" style={[s.input, s.mT7]}
              placeholder="Last Name..." placeholderTextColor={theme.color.placeholder}
              value={lastname} onChangeText={setLastname}
            />
            <MaskInput inputMode="text" style={[s.input, s.mT7]}
              keyboardType="number-pad"
              placeholder="Date of birth..." placeholderTextColor={theme.color.placeholder}
              mask={[/\d/, /\d/, '/', /\d/, /\d/, '/', /\d/, /\d/, /\d/, /\d/]}
              value={dob} onChangeText={masked => setDob(masked)}
            />
            <Button style={[s.bgPrimary, s.mT7]}
              disabled={!firstname || !lastname || !dob}
              onPress={onAddMember}
            >
              Add Member
            </Button>
          </View>
        </>
      }
    </Layouts>
  );
}

export default InviteMember;
