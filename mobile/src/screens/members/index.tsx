import React, { FC, useState } from 'react';
import {
  FlatList,
  TouchableOpacity,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { SafeAreaView } from 'react-native-safe-area-context';
import SearchInput from '../../components/basic/searchinput';
import MemberCard from '../../components/basic/member-card';
import Button from '../../components/basic/button';
import Text from '../../components/basic/text';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IHeaderProps {
  keyword: string,
  onSort: () => void,
}

const HeaderComponent: FC<IHeaderProps> = ({ keyword, onSort }): JSX.Element => {
  const [text, setText] = useState<string>(keyword);
  return (
    <>
      <Text style={[s.fontBodyLight, t.textXs, s.textTitle, t.pX4]}>
        Richmond West
      </Text>
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
            SORT
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

const ItemComponent: FC<ItemProps> = (member): JSX.Element => {
  const navigation = useNavigation();
  return (
    <View style={[t.pX4, t.mB4]}>
      <TouchableOpacity onPress={() => navigation.navigate('MembersInvite' as never)}>
        <MemberCard name={member.name} gender={member.gender} age={member.age}
          dupr={member.dupr} image={member.avatar}
        />
      </TouchableOpacity>
    </View>
  );
};

const Members: FC = (): JSX.Element => {
  const [keyword, setKeyword] = useState<string>('');
  const [members, setMembers] = useState<ItemProps[]>([{
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
        data={members}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent keyword={keyword} onSort={() => {}} />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  )
}

export default Members;
