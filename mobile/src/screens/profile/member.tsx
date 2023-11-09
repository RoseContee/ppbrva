import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { launchImageLibrary, Asset } from 'react-native-image-picker';
import store, { useAppDispatch, useAppSelector } from '../../store';
import { saveMe, getMe, getProfile } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts/home';
import ProfileImage from '../../components/basic/profile-image';
import Message from '../../components/basic/message';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const MemberProfile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const profile = useAppSelector(getProfile);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [avatar, setAvatar] = useState<Asset | string | undefined>(me.avatar);
  const [name, setName] = useState<string>(me.name);
  const [email, setEmail] = useState<string>(me.email);
  const [phone, setPhone] = useState<string>(me.phone);
  const [share, setShare] = useState<boolean>(!!profile.share_age_gender);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Profile' as never);
        return true;
      });
      return () => {
        const me = store.getState().user.me;
        setMessage('');
        setAvatar(me.avatar);
        setName(me.name);
        setEmail(me.email);
        setPhone(me.phone);
        setShare(!!((me || {}).profile || {}).share_age_gender);
        subscribe.remove();
      }
    }, [])
  );

  const chooseAvatar = () => {
    launchImageLibrary({mediaType: 'photo'}, (response) => {
      if (response.didCancel) setAvatar(me.avatar);
      else setAvatar(response.assets ? response.assets[0] : undefined);
    });
  };

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
    setMessage('');
    const formData = new FormData();
    if (avatar && typeof avatar !== 'string') {
      formData.append('avatar', {
        uri: avatar.uri,
        name: avatar.fileName,
        type: avatar.type
      });
    }
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('share', share);
    axios.post(`profile`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    }).then(({ data: { user } }) => {
      dispatch(saveMe(user));
      setMessage('Profile has been updated.');
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[t.itemsCenter, t.mT10]}>
        <ProfileImage image={avatar} style={[s.profileImage]} />
        <Link style={[t.textLg, t.mT3]}
          onPress={chooseAvatar}
        >
          Change Avatar
        </Link>
      </View>
      <Message style={[t.mT4]} text={message} />
      <View style={[s.pX7]}>
        <Title style={[t.textXl, t.mT10]}>
          Contact Info
        </Title>
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="Name..." placeholderTextColor={theme.color.placeholder}
          value={name} onChange={e => setName(e.nativeEvent.text)}
        />
        <TextInput inputMode="email" style={[s.input, s.mT7]}
          keyboardType="email-address"
          placeholder="Email..." placeholderTextColor={theme.color.placeholder}
          value={email} onChange={e => setEmail(e.nativeEvent.text)}
        />
        <MaskInput inputMode="tel" style={[s.input, s.mT7]}
          keyboardType="phone-pad"
          placeholder="Phone..." placeholderTextColor={theme.color.placeholder}
          mask={['(', /\d/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]}
          value={phone} onChangeText={masked => setPhone(masked)}
        />
        <Switch style={[t.mT8]}
          label="Share age/gender"
          value={share} onChange={() => setShare(!share)}
        />
        <Button style={[s.bgPrimary, t.mT10]}
          disabled={
            !name || !email ||
            (avatar === me.avatar
            && name === me.name
            && email === me.email
            && phone === me.phone
            && share === !!profile.share_age_gender)
          }
          onPress={updateProfile}
        >
          Update
        </Button>
      </View>
    </Layouts>
  );
};

export default MemberProfile;
