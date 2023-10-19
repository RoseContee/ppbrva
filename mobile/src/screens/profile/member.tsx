import React, { FC, useState } from 'react';
import {
  Image,
  TextInput,
  View
} from 'react-native';
import { useAppDispatch, useAppSelector } from '../../store';
import { SaveMe, getMe, getProfile } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts/home-layouts';
import Message from '../../components/basic/message';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const ProfileMember: FC = (): JSX.Element => {
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const profile = useAppSelector(getProfile);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [name, setName] = useState<string>(me.name);
  const [email, setEmail] = useState<string>(me.email);
  const [phone, setPhone] = useState<string>(me.phone);
  const [share, setShare] = useState<boolean>(!!profile.share_age_gender);

  const updateProfile = () => {
    if (!name) {
      setMessage('The name field is required.');
      return;
    }
    if (!email) {
      setMessage('The email field is required.');
      return;
    }
    setLoading(true);
    axios.post(`profile`, {
      name, email, phone, share
    }).then(({ data: { user } }) => {
      dispatch(SaveMe(user));
      setMessage('Profile has been updated.');
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[t.itemsCenter, t.mT6]}>
        <Image source={{ uri: me.avatar }} style={[s.profileImage]} />
        <Link style={[t.textXs, t.mT2]}>
          Change Avatar
        </Link>
      </View>
      <Message style={[t.mT4]} text={message} />
      <View style={[t.pX4]}>
        <Title style={[t.mT6]}>
          Contact Info
        </Title>
        <TextInput inputMode="text" style={[s.input, t.mT4]}
          placeholder="Name..."
          value={name} onChange={e => setName(e.nativeEvent.text)}
        />
        <TextInput inputMode="email" style={[s.input, t.mT4]}
          keyboardType="email-address"
          placeholder="Email..."
          value={email} onChange={e => setEmail(e.nativeEvent.text)}
        />
        <MaskInput inputMode="tel" style={[s.input, t.mT4]}
          keyboardType="phone-pad"
          placeholder="Phone..."
          mask={['(', /\d/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]}
          value={phone} onChangeText={(masked, unmasked) => setPhone(masked)}
        />
        <Switch style={[t.mT5]}
          label="Share age/gender"
          value={share}
          onChange={() => setShare(!share)}
        />
        <Button style={[s.bgPrimary, t.mT6]}
          onPress={updateProfile}
        >
          Update
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileMember;
