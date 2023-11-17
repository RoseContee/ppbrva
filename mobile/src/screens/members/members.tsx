import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  FlatList,
  View
} from 'react-native';
import {
  NavigationProp, useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import axios from '../../utils/axios';
import Layouts from '../../components/layouts';
import PageTitle from '../../components/basic/page-title';
import Message from '../../components/basic/message';
import Text from '../../components/basic/text';
import Button from '../../components/basic/button';
import SearchBar from '../../components/basic/search-bar';
import MemberCard from '../../components/basic/member-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

export interface MemberProps {
  memberID: string,
  name: string,
  email: string,
  phone: string,
  avatar: string,
  profile: {
    share_age_gender: boolean,
    age: string,
    gender: string,
    rating: string,
    matches: number,
    wins: number,
    losses: number,
  },

  email_share: boolean,
  phone_share: boolean,
  my_email_share: boolean,
  my_phone_share: boolean,
  friend_status: '' | 'pending' | 'waiting' | 'accepted',
}

type FilterType = 'all' | 'males' | 'females' | '2.0' | '3.0' | '4.0' | '5.0';

interface IHeaderProps {
  keyword: string,
  onSearch: (keyword: string) => void,
  filter: FilterType,
  onFilter: (type: FilterType) => void,
  pending?: number,
}

const HeaderComponent: FC<IHeaderProps> = ({
  keyword,
  onSearch,
  filter,
  onFilter,
  pending,
}): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const me = useAppSelector(getMe);

  return (
    <>
      <PageTitle title={ me.name } />
      {
        route.name === 'Friends' && pending ? (
          <Message style={[t.mT4]}>
            <Text style={[t.flexShrink, t.textBase, s.textGray, t.pR4]}>
              You have { pending } pending requests!
            </Text>
            <Button style={[s.bgPrimary, s.messageBtn, t.pX5]} titleStyle={[t.textSm]}
              onPress={() => navigation.navigate('PendingRequests' as never)}
            >
              View
            </Button>
          </Message>
        ) : (<></>)
      }
      <SearchBar style={[t.mT8, t.mB4]}
        keyword={keyword}
        onSearch={onSearch}
        buttonText="Filter"
        items={[
          {value: 'all', text: 'All'},
          {value: 'males', text: 'Only Males'},
          {value: 'females', text: 'Only Females'},
          {value: '2.0', text: 'DUPR 2.0-2.9'},
          {value: '3.0', text: 'DUPR 3.0-3.9'},
          {value: '4.0', text: 'DUPR 4.0-4.9'},
          {value: '5.0', text: 'DUPR 5.0+'},
        ]}
        activeMenu={filter}
        onMenuSelect={menu => onFilter(menu as FilterType)}
      />
    </>
  );
};

interface IItemProps {
  navigation: NavigationProp<ReactNavigation.RootParamList>,
  route: string,
  member: MemberProps,
}

const ItemComponent: FC<IItemProps> = ({
  navigation,
  route,
  member,
}): JSX.Element => {
  return (
    <View style={[s.pX7, t.mT6]}>
      <MemberCard member={member}
        onPress={() => {
          if (route === 'Friends') {
            navigation.navigate({
              name: 'AcceptedFriend',
              params: {
                title: member.name,
                memberID: member.memberID,
              },
            } as never);
          } else if (route === 'PendingRequests') {
            navigation.navigate({
              name: 'FriendRequest',
              params: {
                memberID: member.memberID,
              },
            } as never);
          } else if (route === 'Members') {
            navigation.navigate({
              name: 'MemberInvite',
              params: {
                title: member.name,
                memberID: member.memberID,
              },
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
  const [loading, setLoading] = useState<boolean>(false);
  const [members, setMembers] = useState<MemberProps[]>([]);
  const [pending, setPending] = useState<number>();
  const [keyword, setKeyword] = useState<string>('');
  const [filter, setFilter] = useState<FilterType>('all');

  const filteredMembers = members.filter(member => {
    const q = keyword.toLowerCase();
    const profile = member.profile || {
      share_age_gender: false,
      gender: '',
      rating: 0,
    };
    const rating = Number(profile.rating);
    return member.name.toLowerCase().includes(q)
      && (filter === 'all'
        || (filter === 'males' && profile.share_age_gender && profile.gender.toLocaleLowerCase() === 'male')
        || (filter === 'females' && profile.share_age_gender && profile.gender.toLocaleLowerCase() === 'female')
        || (filter === '2.0' && 2.0 <= rating && rating < 3)
        || (filter === '3.0' && 3.0 <= rating && rating < 4)
        || (filter === '4.0' && 4.0 <= rating && rating < 5)
        || (filter === '5.0' && 5.0 <= rating)
      );
  });

  useFocusEffect(
    useCallback(() => {
      if (!members.length) setLoading(true);
      const url = route.name === 'Members' ? '/members'
        : route.name === 'Friends' ? '/friends'
        : '/pending-friends';
      axios.get(url)
      .then(({ data }) => {
        setMembers(data.members);
        setPending(data.pending_requests);
      }).finally(() => setLoading(false));
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

  const renderListHeader = () => {
    return (
      <HeaderComponent
        keyword={keyword} onSearch={setKeyword}
        filter={filter} onFilter={setFilter}
        pending={pending}
      />
    );
  };

  return (
    <Layouts flatlist={true} loading={loading}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={filteredMembers}
        keyExtractor={item => item.memberID}
        ListHeaderComponent={renderListHeader()}
        ListEmptyComponent={() => (
          <Message style={[t.mT10]}
            text={`${ route.name === 'Friends' ? 'Friends' : 'Members' } not found.`}
          />
        )}
        renderItem={({item}) => (
          <ItemComponent navigation={navigation}
            route={route.name}
            member={item}
          />
        )}
      />
    </Layouts>
  );
};

export default Members;
