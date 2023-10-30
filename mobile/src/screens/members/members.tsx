import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  FlatList,
  SafeAreaView,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import PageTitle from '../../components/basic/page-title';
import Message from '../../components/basic/message';
import Text from '../../components/basic/text';
import Button from '../../components/basic/button';
import SearchBar from '../../components/basic/search-bar';
import MemberCard from '../../components/basic/member-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IHeaderProps {
}

const HeaderComponent: FC<IHeaderProps> = ({}): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const me = useAppSelector(getMe);

  return (
    <>
      <PageTitle title={ me.name } />
      {
        route.name === 'Friends' &&
        <Message style={[t.mT4]}>
          <Text style={[t.flexShrink, t.textBase, s.textGray, t.pR4]}>
            You have 3 pending requests!
          </Text>
          <Button style={[s.bgPrimary, s.messageBtn, t.pX5]} titleStyle={[t.textSm]}
            onPress={() => navigation.navigate('PendingRequests' as never)}
          >
            View
          </Button>
        </Message>
      }
      <SearchBar style={[t.mT8, t.mB4]} />
    </>
  );
};

export interface MemberProps {
  id: string,
  name: string,
  email?: string,
  phone?: string,
  gender: string,
  age: number,
  dupr: number,
  avatar: string,
  matches: number,
  wins: number,
  losses: number,
}

const ItemComponent: FC<MemberProps> = (member): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();

  return (
    <View style={[s.pX7, t.mT6]}>
      <MemberCard name={member.name} gender={member.gender} age={member.age}
        dupr={member.dupr} image={member.avatar}
        onPress={() => {
          if (route.name === 'Friends') {
            navigation.navigate({
              name: 'AcceptedFriend',
              params: {member},
            } as never);
          } else if (route.name === 'PendingRequests') {
            navigation.navigate({
              name: 'FriendRequest',
              params: { member },
            } as never);
          } else if (route.name === 'Members') {
            navigation.navigate({
              name: 'MemberInvite',
              params: {member},
            } as never);
          }
        }}
      />
    </View>
  );
};

const Members: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [members, setMembers] = useState<MemberProps[]>([{
    id: 'bd7acbea',
    name: 'Jorge Warsh',
    email: 'jorge@warsh.com',
    phone: '(805) 555-1234',
    gender: 'Male',
    age: 64,
    dupr: 3.9,
    avatar: '',
    matches: 24,
    wins: 14,
    losses: 10,
  }, {
    id: '3ac68afc',
    name: 'Tatiana Leland',
    email: 'tatiana@leland.com',
    gender: 'Female',
    age: 55,
    dupr: 3.8,
    avatar: '',
    matches: 15,
    wins: 14,
    losses: 1,
  }, {
    id: '58694a0f',
    name: 'Ken Derson',
    phone: '(956) 874-1234',
    gender: 'Male',
    age: 32,
    dupr: 4.0,
    avatar: '',
    matches: 8,
    wins: 0,
    losses: 8,
  }]);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        if (route.name === 'PendingRequests') {
          navigation.navigate('Friends' as never);
          return true;
        }
        return false;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={members}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  );
};

export default Members;
