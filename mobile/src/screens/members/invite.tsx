import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import Layouts from '../../components/layouts/home';
import Message from '../../components/basic/message';
import ProfileCard from '../../components/basic/profile-card';
import Button from '../../components/basic/button';
import { MemberProps } from './members';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const MemberInvite: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const member = (route.params as any)?.member as MemberProps;

  useFocusEffect(
    useCallback(() => {
      navigation.setOptions({title: member.name});
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Members' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <Message style={[s.mT7]}
        text={`If ${ member.name } accepts, ${member.gender == 'Male' ? 'he' : 'she'} will appear as a Friend!`}
      />
      <View style={[s.pX7]}>
        <ProfileCard style={[t.mT8]}
          image={member.avatar} dupr={member.dupr} gender={member.gender} age={member.age}
          matches={member.matches} wins={member.wins} losses={member.losses}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={() => navigation.navigate('Members' as never)}
        >
          Add Friend
        </Button>
      </View>
    </Layouts>
  );
};

export default MemberInvite;
