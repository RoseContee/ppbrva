import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  FlatList,
  View
} from 'react-native';
import {
  NavigationProp, useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { MemberProp, fetchMembers } from '../../requests';
import { useAppSelector } from '../../store';
import { getLocation, getMe } from '../../store/user';
import Layouts from '../../components/layouts';
import PageTitle from '../../components/basic/page-title';
import Message from '../../components/basic/message';
import Text from '../../components/basic/text';
import Button from '../../components/basic/button';
import SearchBar from '../../components/basic/search-bar';
import MemberCard from '../../components/basic/member-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IHeaderProps {
  keyword: string,
  onSearch: (keyword: string) => void,
  filter: string,
  onFilter: (type: string) => void,
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
  const location = useAppSelector(getLocation);

  return (
    <>
      <PageTitle title={location.name} />
      {
        route.name === mainRoutes.Friends && pending ? (
          <Message style={[t.mT4]}>
            <Text style={[t.flexShrink, t.textBase, s.textGray, t.pR4]}>
              You have { pending } pending requests!
            </Text>
            <Button style={[s.bgPrimary, s.messageBtn, t.pX5]} titleStyle={[t.textSm]}
              onPress={() => navigation.navigate(mainRoutes.PendingRequests as never)}
            >
              View
            </Button>
          </Message>
        ) : (<></>)
      }
      <SearchBar style={[t.mT8, t.mB4]}
        keyword={keyword}
        onSearch={onSearch}
        buttonText="Sort"
        items={[
          {value: ''        , text: 'Clear'},
          {value: 'highest' , text: 'Highest DUPR first'},
          {value: 'lowest'  , text: 'Lowest DUPR first'},
          {value: 'men'     , text: 'Only Men'},
          {value: 'women'   , text: 'Only Women'},
          {value: 'oldest'  , text: 'Oldest first'},
          {value: 'youngest', text: 'Youngest first'},
          {value: '18-30'   , text: 'Age 18-30'},
          {value: '31-50'   , text: 'Age 31-50'},
          {value: '51-60'   , text: 'Age 51-60'},
          {value: '61-70'   , text: 'Age 61-70'},
          {value: '70+'     , text: 'Age 70+'},
        ]}
        activeMenu={filter}
        onMenuSelect={onFilter}
      />
    </>
  );
}

interface IItemProps {
  navigation: NavigationProp<ReactNavigation.RootParamList>,
  route: string,
  member: MemberProp,
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
          if (route === mainRoutes.Friends) {
            navigation.navigate({
              name: mainRoutes.AcceptedFriend,
              params: {
                title: member.name,
                memberID: member.memberID,
              },
            } as never);
          } else if (route === mainRoutes.PendingRequests) {
            navigation.navigate({
              name: mainRoutes.FriendRequest,
              params: {
                memberID: member.memberID,
              },
            } as never);
          } else if (route === mainRoutes.Members) {
            navigation.navigate({
              name: mainRoutes.MemberInvite,
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
}

const Members: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [loading, setLoading] = useState<boolean>(false);
  const [members, setMembers] = useState<MemberProp[]>([]);
  const [pending, setPending] = useState<number>();
  const [keyword, setKeyword] = useState<string>('');
  const [filter, setFilter] = useState<string>('');

  const filteredMembers = members.filter(member => {
    const q = keyword.toLowerCase();
    const profile = member.profile;
    return member.name.toLowerCase().includes(q)
      && (['', 'highest', 'lowest', 'oldest', 'youngest'].includes(filter)
        || (filter === 'men' && profile.share_age_gender && profile.gender.toLocaleLowerCase() === 'male')
        || (filter === 'women' && profile.share_age_gender && profile.gender.toLocaleLowerCase() === 'female')
        || (filter === '18-30' && 18 <= profile.age && profile.age <= 30)
        || (filter === '31-50' && 31 <= profile.age && profile.age <= 50)
        || (filter === '51-60' && 51 <= profile.age && profile.age <= 60)
        || (filter === '61-70' && 61 <= profile.age && profile.age <= 70)
        || (filter === '70+' && 71 <= profile.age)
      );
  });
  if (['highest', 'lowest', 'oldest', 'youngest'].includes(filter)) {
    filteredMembers.sort((a, b) => {
      if (filter === 'highest') return b.profile.rating - a.profile.rating;
      if (filter === 'lowest') return a.profile.rating - b.profile.rating;
      if (filter === 'oldest') return b.profile.age - a.profile.age;
      return a.profile.age - b.profile.age;
    });
  }

  useFocusEffect(
    useCallback(() => {
      if (!members.length) setLoading(true);
      const url = route.name === mainRoutes.Members ? '/members'
        : route.name === mainRoutes.Friends ? '/friends'
        : '/pending-friends';
      fetchMembers(url)
        .then(data => {
          setMembers(data.members);
          setPending(data.pending_requests);
        })
        .finally(() => setLoading(false));
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        if (route.name === mainRoutes.PendingRequests) {
          navigation.navigate(mainRoutes.Friends as never);
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
  }

  return (
    <Layouts flatlist={true} loading={loading}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={filteredMembers}
        keyExtractor={item => item.memberID}
        ListHeaderComponent={renderListHeader()}
        ListEmptyComponent={() => (
          <Message style={[t.mT10]}
            text={members.length
              ? `${ route.name === mainRoutes.Friends ? 'Friends' : 'Members' } not found.`
              : `No ${ route.name === mainRoutes.Friends ? 'friends' : 'members' } yet...`
            }
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
}

export default Members;
