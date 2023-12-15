import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  Dimensions,
  Linking,
  TextInput,
  View,
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { launchImageLibrary, Asset } from 'react-native-image-picker';
import Image from 'react-native-scalable-image';
import MaskInput from 'react-native-mask-input';
import store, { useAppDispatch, useAppSelector } from '../../store';
import { saveMe, getMe } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import { Genders, States } from '../../utils/lib';
import Layouts from '../../components/layouts';
import ProfileImage from '../../components/basic/profile-image';
import Message from '../../components/basic/message';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Select from '../../components/basic/select';
import Switch from '../../components/basic/switch';
import IconQuestion from '../../assets/img/icons/question.svg';

import imgDuprLogo from '../../assets/img/dupr-logo.png';

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
  const [firstname, setFirstname] = useState<string>(me.firstname);
  const [lastname, setLastname] = useState<string>(me.lastname);
  const [gender, setGender] = useState<string>(me.gender);
  const [email, setEmail] = useState<string>(me.email);
  const [phone, setPhone] = useState<string>(me.phone ?? '');
  const [dob, setDob] = useState<string>(me.dob ?? '');
  const [address, setAddress] = useState<string>(me.address ?? '');
  const [city, setCity] = useState<string>(me.city ?? '');
  const [state, setState] = useState<string>(me.state ?? '');
  const [zipcode, setZipcode] = useState<string>(me.zipcode ?? '');
  const [duprId, setDuprId] = useState<string>(me.profile?.dupr_id ?? '');
  const [share, setShare] = useState<boolean>(!!me.profile?.share_age_gender);
  const duprWidth = (Dimensions.get('window').width - 28 * 2) / 4 - 10;

  useFocusEffect(
    useCallback(() => {
      initStates();
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Profile' as never);
        return true;
      });
      return () => {
        subscribe.remove();
      }
    }, [])
  );

  const initStates = () => {
    const me = store.getState().user.me;
    setMessage('');
    setAvatar(me.avatar);
    setFirstname(me.firstname);
    setLastname(me.lastname);
    setGender(me.gender);
    setEmail(me.email);
    setPhone(me.phone ?? '');
    setDob(me.dob ?? '');
    setAddress(me.address ?? '');
    setCity(me.city ?? '');
    setState(me.state ?? '');
    setZipcode(me.zipcode ?? '');
    setDuprId(me.profile?.dupr_id ?? '');
    setShare(!!me.profile?.share_age_gender);
  }

  const chooseAvatar = () => {
    launchImageLibrary({mediaType: 'photo'}, (response) => {
      if (response.didCancel) setAvatar(me.avatar);
      else setAvatar(response.assets ? response.assets[0] : undefined);
    });
  };

  const updateProfile = () => {
    if (!firstname) {
      setMessage('The first name field is required.');
      return;
    }
    if (!lastname) {
      setMessage('The last name field is required.');
      return;
    }
    if (!gender) {
      setMessage('The gender field is required.');
      return;
    }
    if (!email) {
      setMessage('The email field is required.');
      return;
    }
    if (!dob) {
      setMessage('The date of birth field is required.');
      return;
    }
    if (!address) {
      setMessage('The address field is required.');
      return;
    }
    if (!city) {
      setMessage('The city field is required.');
      return;
    }
    if (!state) {
      setMessage('The state field is required.');
      return;
    }
    if (!zipcode) {
      setMessage('The zip code field is required.');
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
    formData.append('firstname', firstname);
    formData.append('lastname', lastname);
    formData.append('gender', gender);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('dob', dob);
    formData.append('address', address);
    formData.append('city', city);
    formData.append('state', state);
    formData.append('zipcode', zipcode);
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
          placeholder="First Name..." placeholderTextColor={theme.color.placeholder}
          value={firstname} onChangeText={setFirstname}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="Last Name..." placeholderTextColor={theme.color.placeholder}
          value={lastname} onChangeText={setLastname}
        />
        <Select style={[s.mT7]}
          placeholder="Gender..."
          data={Genders}
          value={Genders.find(el => el.value === gender)}
          onChange={value => setGender(value.value)}
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
        <MaskInput inputMode="text" style={[s.input, s.mT7]}
          keyboardType="number-pad"
          placeholder="Date of birth..." placeholderTextColor={theme.color.placeholder}
          mask={[/\d/, /\d/, '/', /\d/, /\d/, '/', /\d/, /\d/, /\d/, /\d/]}
          value={dob} onChangeText={masked => setDob(masked)}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="Address..." placeholderTextColor={theme.color.placeholder}
          value={address} onChangeText={setAddress}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="City..." placeholderTextColor={theme.color.placeholder}
          value={city} onChangeText={setCity}
        />
        <Select style={[s.mT7]}
          placeholder="State..."
          data={States}
          value={States.find(el => el.value === state)}
          onChange={value => setState(value.value)}
        />
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="Zip Code..." placeholderTextColor={theme.color.placeholder}
          value={zipcode} onChangeText={setZipcode}
        />
        <View style={[t.flexRow, t.itemsCenter, s.mT7]}>
          <View style={[t.w1_4]}>
            <Image source={imgDuprLogo} width={duprWidth} />
          </View>
          <TextInput inputMode="numeric" style={[s.input, t.w2_4]}
            keyboardType="number-pad"
            placeholder="DUPR ID#" placeholderTextColor={theme.color.placeholder}
            value={duprId} onChangeText={setDuprId}
          />
          <View style={[t.w1_4, t.pL3]}>
            <IconQuestion fill={theme.color.primary}
              width={theme.size.settingIcon} height={theme.size.settingIcon}
              onPress={() => Linking.openURL(me.profile?.dupr_link ?? 'https://ppbrva.com/dupr')}
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
            !firstname || !lastname || !gender || !email ||
            !dob || !address || !city || !state || !zipcode ||
            (
              avatar === me.avatar
              && firstname === me.firstname
              && lastname === me.lastname
              && gender === me.gender
              && email === me.email
              && phone === me.phone
              && dob === me.dob
              && address === me.address
              && city === me.city
              && state === me.state
              && zipcode === me.zipcode
              && duprId === me.profile?.dupr_id
              && share === !!me.profile?.share_age_gender
            )
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
