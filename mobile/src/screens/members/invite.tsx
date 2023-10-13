import React, { FC } from 'react';
import {
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Layouts from '../../components/layouts/home-layouts';
import Message from '../../components/basic/message';
import ProfileCard from '../../components/basic/profile-card';
import Button from '../../components/basic/button';

import imgProfile from '../../assets/img/tmp/profile.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const MembersInvite: FC = (): JSX.Element => {
  const navigation = useNavigation();

  return (
    <Layouts>
      <Message style={[t.mT4]} text="If Sally accepts she will appear as a Friend!" />
      <View style={[t.pX4]}>
        <ProfileCard style={[t.mT5]}
          image={imgProfile} dupr={3.5} gender={"Female"} age={57}
          matches={27} wins={19} losses={8}
        />
        <Button style={[s.bgPrimary, t.mT4]}
          onPress={() => navigation.navigate('MembersRequest' as never)}
        >
          Add Friend
        </Button>
      </View>
    </Layouts>
  )
}

export default MembersInvite;
