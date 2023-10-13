import React, { FC, useState } from 'react';
import {
  FlatList,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Message from '../components/basic/message';
import SearchInput from '../components/basic/searchinput';
import Button from '../components/basic/button';
import MemberCard from '../components/basic/member-card';
import Text from '../components/basic/text';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface IHeaderProps {
  keyword: string,
  onSort: () => void,
}

const HeaderComponent: FC<IHeaderProps> = ({ keyword, onSort }): JSX.Element => {
  const [text, setText] = useState<string>(keyword);
  const navigation = useNavigation();

  return (
    <>
      <Text style={[s.fontBodyLight, s.textTiny, s.textTitle, t.pX4]}>
        Richmond West
      </Text>
      <Message style={[t.mT4]}>
        <Text style={[t.flexShrink, s.textTiny, s.textGray, t.pR2]}>
          You have 3 pending requests!
        </Text>
        <Button style={[s.bgPrimary, s.messageBtn]} titleStyle={[s.textTiny]}
          onPress={() => navigation.navigate('Members' as never)}
        >
          View
        </Button>
      </Message>
      <View style={[t.flexRow, t.itemsCenter, t.pX4, t.mY4]}>
        <View style={[t.w3_4, t.pR3]}>
          <SearchInput value={text}
            onChange={e => setText(e.nativeEvent.text)}
          />
        </View>
        <View style={[t.w1_4]}>
          <Button style={[s.bgPrimary, {paddingVertical: 9}]} titleStyle={[s.textTiny]}
            onPress={onSort}
          >
            Sort
          </Button>
        </View>
      </View>
    </>
  )
}

interface ItemProps {
  id: string,
  name: string,
  gender: string,
  age: number,
  dupr: number,
  avatar: string,
}

const ItemComponent: FC<ItemProps> = (friend): JSX.Element => {
  return (
    <View style={[t.pX4, t.mB4]}>
      <MemberCard name={friend.name} gender={friend.gender} age={friend.age}
        dupr={friend.dupr} image={friend.avatar}
      />
    </View>
  );
};

const Friends: FC = (): JSX.Element => {
  const [keyword, setKeyword] = useState<string>('');
  const [friends, setFriends] = useState<ItemProps[]>([{
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
    name: 'Jorge Warsh',
    gender: 'Male',
    age: 64,
    dupr: 3.9,
    avatar: '',
  }, {
    id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f63',
    name: 'Tatiana Leland',
    gender: 'Female',
    age: 55,
    dupr: 3.8,
    avatar: '',
  }, {
    id: '58694a0f-3da1-471f-bd96-145571e29d72',
    name: 'Ken Derson',
    gender: 'Male',
    age: 32,
    dupr: 4.0,
    avatar: '',
  }]);

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]}
        data={friends}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent keyword={keyword} onSort={() => {}} />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  )
}

export default Friends;
