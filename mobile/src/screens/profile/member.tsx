import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  Linking,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { launchImageLibrary, Asset } from 'react-native-image-picker';
import store, { useAppDispatch, useAppSelector } from '../../store';
import { saveMe, getMe } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts';
import ProfileImage from '../../components/basic/profile-image';
import Message from '../../components/basic/message';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';
import IconQuestion from '../../assets/img/icons/question.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const MemberProfile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [avatar, setAvatar] = useState<Asset | string | undefined>(me.avatar);
  const [name, setName] = useState<string>(me.name);
  const [email, setEmail] = useState<string>(me.email);
  const [phone, setPhone] = useState<string>(me.phone);
  const [duprId, setDuprId] = useState<string>(me.profile?.dupr_id);
  const [share, setShare] = useState<boolean>(!!me.profile?.share_age_gender);

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
        const profile = (me || {}).profile || {};
        setDuprId(profile.dupr_id);
        setShare(!!profile.share_age_gender);
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
    formData.append('dupr', duprId);
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
          value={name} onChangeText={setName}
        />
        <TextInput inputMode="email" style={[s.input, s.mT7]}
          keyboardType="email-address"
          placeholder="Email..." placeholderTextColor={theme.color.placeholder}
          value={email} onChangeText={setEmail}
        />
        <MaskInput inputMode="tel" style={[s.input, s.mT7]}
          keyboardType="phone-pad"
          placeholder="Phone..." placeholderTextColor={theme.color.placeholder}
          mask={['(', /\d/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]}
          value={phone} onChangeText={masked => setPhone(masked)}
        />
        <View style={[t.flexRow, t.itemsCenter, s.mT7]}>
          <TextInput inputMode="numeric" style={[s.input, t.w4_5]}
            keyboardType="number-pad"
            placeholder="DUPR ID#" placeholderTextColor={theme.color.placeholder}
            value={duprId} onChangeText={setDuprId}
          />
          <View style={[t.w1_5, t.pL3]}>
            <IconQuestion fill={theme.color.primary}
              width={theme.size.settingIcon} height={theme.size.settingIcon}
              onPress={() => Linking.openURL('https://ppbrva.com/dupr')}
            />
          </View>
        </View>
        <Switch style={[t.justifyCenter, t.mT8]}
          label="Share age/gender"
          labelRight={true}
          value={share} onChange={() => setShare(!share)}
        />
        <Button style={[s.bgPrimary, t.mT10]}
          disabled={
            !name || !email ||
            (avatar === me.avatar
            && name === me.name
            && email === me.email
            && phone === me.phone
            && duprId === me.profile?.dupr_id
            && share === !!me.profile?.share_age_gender)
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
