import React, { FC, useState } from 'react';
import {
  Image,
  TextInput,
  View
} from 'react-native';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts/home-layouts';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';

import imgProfile from '../../assets/img/tmp/profile.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const ProfileMember: FC = (): JSX.Element => {
  const [name, setName] = useState<string>('Wally Pickles');
  const [email, setEmail] = useState<string>('wally@pickles.com');
  const [phone, setPhone] = useState<string>('(804) 315-9609');
  const [share, setShare] = useState<boolean>(true);

  return (
    <Layouts>
      <View style={[t.pX4]}>
        <View style={[t.itemsCenter, t.mT6]}>
          <Image source={imgProfile} style={[s.profileImage]} />
          <Link style={[t.textXs, t.mT2]}>
            Change Avatar
          </Link>
        </View>
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
          onPress={() => {}}
        >
          Update
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileMember;
