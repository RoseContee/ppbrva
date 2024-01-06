import React, { FC, useCallback, useEffect, useState } from 'react';
import {
  BackHandler,
  Dimensions,
  Linking,
  TextInput,
  View,
} from 'react-native';
import {
  useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import { launchImageLibrary, Asset } from 'react-native-image-picker';
import { mainRoutes } from '../../routes';
import { deleteFamilyMember, fetchFamilyMember, postFamilyMember } from '../../requests';
import Image from 'react-native-scalable-image';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts';
import ProfileImage from '../../components/basic/profile-image';
import Message from '../../components/basic/message';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Title from '../../components/basic/title';
import Switch from '../../components/basic/switch';
import IconQuestion from '../../assets/img/icons/question.svg';

import imgDuprLogo from '../../assets/img/dupr-logo.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const FamilyMemberProfile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState('');
  const [originalAvatar, setOriginalAvatar] = useState('');
  const [avatar, setAvatar] = useState<Asset | string | undefined>('');
  const [firstname, setFirstname] = useState('');
  const [lastname, setLastname] = useState('');
  const [isChild, setIsChild] = useState(false);
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [duprId, setDuprId] = useState('');
  const [duprLink, setDuprLink] = useState('');
  const [share, setShare] = useState(false);
  const [password, setPassword] = useState('');
  const [password_confirmation, setConfirmation] = useState('');
  const {memberID} = (route.params as any);
  const duprWidth = (Dimensions.get('window').width - 28 * 2) / 4 - 10;

  const gotoMembershipPlan = () => {
    navigation.navigate(mainRoutes.MembershipPlan as never);
  }

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        gotoMembershipPlan();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  useEffect(() => {
    initStates();
  }, [memberID]);

  const initStates = () => {
    setLoading(true);
    setMessage('');
    fetchFamilyMember(memberID)
      .then(member => {
        setOriginalAvatar(member.avatar);
        setAvatar(member.avatar);
        setFirstname(member.firstname);
        setLastname(member.lastname);
        setIsChild(member.is_child);
        setEmail(member.email);
        setPhone(member.phone);
        setDuprId(member.profile.dupr_id);
        setDuprLink(member.profile.dupr_link);
        setShare(!!member.profile.share_age_gender);
        setPassword('');
        setConfirmation('');
      })
      .catch(error => {
        setMessage(error);
        gotoMembershipPlan();
      })
      .finally(() => setLoading(false));
  }

  const chooseAvatar = () => {
    launchImageLibrary({mediaType: 'photo'}, (response) => {
      if (response.didCancel) setAvatar(originalAvatar);
      else setAvatar(response.assets ? response.assets[0] : undefined);
    });
  }

  const onUpdate = () => {
    if (!isChild && (password || password_confirmation)) {
      if (!password) {
        return setMessage('The password field is required.');
      }
      if (password.length < 8) {
        return setMessage('The password field must be at least 8 characters.');
      }
      if (password != password_confirmation) {
        return setMessage('The password field confirmation does not match.');
      }
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
    if (!isChild) {
      formData.append('email', email);
      formData.append('phone', phone);
      formData.append('dupr', duprId);
      formData.append('share', share);
      formData.append('password', password);
      formData.append('password_confirmation', password_confirmation);
    }
    postFamilyMember(memberID, formData)
      .then(() => setMessage('Profile has been updated.'))
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  const onRemove = () => {
    setLoading(true);
    setMessage('');
    deleteFamilyMember(memberID)
      .then(() => {
        setMessage('Member has been removed.');
        gotoMembershipPlan();
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
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
        {
          !isChild &&
          <>
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
                  onPress={() => Linking.openURL(duprLink ?? 'https://ppbrva.com/dupr')}
                />
              </View>
            </View>
            <Switch style={[t.justifyCenter, t.mT8]}
              label="Share age/gender"
              labelRight={true}
              value={share} onChange={() => setShare(!share)}
            />
            <Title style={[t.textXl, t.mT10]}>
              Reset Password
            </Title>
            <TextInput inputMode="text" style={[s.input, s.mT7]}
              secureTextEntry={true}
              placeholder="New Password..." placeholderTextColor={theme.color.placeholder}
              value={password} onChangeText={setPassword}
            />
            <TextInput inputMode="text" style={[s.input, s.mT7]}
              secureTextEntry={true}
              placeholder="Confirm Password..." placeholderTextColor={theme.color.placeholder}
              value={password_confirmation} onChangeText={setConfirmation}
            />
          </>
        }
        <Button style={[s.bgPrimary, t.mT10]}
          disabled={!firstname || !lastname || !email}
          onPress={onUpdate}
        >
          Update
        </Button>
        <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
          onPress={onRemove}
        >
          Remove Member
        </Button>
      </View>
    </Layouts>
  );
}

export default FamilyMemberProfile;
