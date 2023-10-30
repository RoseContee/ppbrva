import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import Layouts from '../../components/layouts/home';
import MemberCard from '../../components/basic/member-card';
import Text from '../../components/basic/text';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
import { MemberProps } from './members';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const FriendRequest: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const member = (route.params as any)?.member as MemberProps;

  useFocusEffect(
    useCallback(() => {
      navigation.setOptions({title: member.name});
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('PendingRequests' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <View style={[s.pX7]}>
        <MemberCard style={[t.mT5]}
          name={member.name} gender={member.gender} age={member.age}
          dupr={member.dupr} image={member.avatar}
          onPress={() => {}}
        />
        <Text style={[s.fontBodyBold, t.textXl, s.textTitle, t.textCenter, t.mT10]}>
          { member.name } wants to be your friend!
        </Text>
        <Text style={[s.fontBodyLight, t.textLg, s.textGray, t.textCenter, t.mT2]}>
          Choose which contact info you want to share with { member.name }:
        </Text>
        {
          member.email &&
          <Switch style={[t.justifyBetween, t.pX4, t.mT8]}
            labelStyle={[t.textLg, s.textGray]}
            label={ member.email }
            labelPosition="left"
            //value={true}
            onChange={() => {}}
          />
        }
        {
          member.phone &&
          <Switch style={[t.justifyBetween, t.pX4, s.mT7]}
            labelStyle={[t.textLg, s.textGray]}
            label={ member.phone }
            labelPosition="left"
            //value={true}
            onChange={() => {}}
          />
        }
        <Button style={[s.bgPrimary, t.mT10]}
          onPress={() => {
            navigation.navigate({
              name: 'AcceptedFriend',
              params: {member},
            } as never);
          }}
        >
          Add { member.name }
        </Button>
        <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
          onPress={() => navigation.navigate('PendingRequests' as never)}
        >
          Decline
        </Button>
        <View style={[t.mY8]} />
        <View style={[t.flexRow, t.itemsCenter, t.justifyCenter]}>
          <View style={[s.dot, t.mX1]} />
          <View style={[s.dot, s.bgPrimary, t.mX1]} />
          <View style={[s.dot, t.mX1]} />
        </View>
      </View>
    </Layouts>
  );
};

export default FriendRequest;
