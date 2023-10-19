import React, { FC, useState } from 'react';
import {
  FlatList,
  TouchableOpacity,
  View
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useNavigation } from '@react-navigation/native';
import SearchInput from '../../components/basic/searchinput';
import Button from '../../components/basic/button';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconSettings from '../../assets/img/icons/settings.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface IHeaderProps {
  keyword: string,
  onSort: () => void,
}

const HeaderComponent: FC<IHeaderProps> = ({ keyword, onSort }): JSX.Element => {
  const [text, setText] = useState<string>(keyword);

  return (
    <View style={[t.flexRow, t.itemsCenter, t.pX4, t.mY6]}>
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
  )
}

interface ItemProps {
  id: string,
  date: string,
  amount: string,
}

const ItemComponent: FC<ItemProps> = (invoice): JSX.Element => {
  const navigation = useNavigation();

  return (
    <View style={[t.pX4, t.mB4]}>
      <TouchableOpacity onPress={() => navigation.navigate('ProfileInvoicesDetail' as never)}>
        <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
          <View style={[t.flexShrink, t.pR3]}>
            <Title style={[t.textSm, s.textPrimary]}>
              { invoice.date }
            </Title>
            <Text style={[s.fontBodyLight, t.textXs, s.textGray, t.mT1]}>
              { invoice.amount }
            </Text>
          </View>
          <IconSettings fill={theme.color.primary}
            width={theme.size.cardIcon} height={theme.size.cardIcon}
          />
        </Card>
      </TouchableOpacity>
    </View>
  );
};

const ProfileInvoices: FC = (): JSX.Element => {
  const [keyword, setKeyword] = useState<string>('');
  const [invoices, setInvoices] = useState<ItemProps[]>([{
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
    date: 'December 2023',
    amount: '$228.46',
  }, {
    id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f63',
    date: 'November 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f-3da1-471f-bd96-145571e29d72',
    date: 'October 2023',
    amount: '$498.23',
  }, {
    id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f64',
    date: 'September 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f-3da1-471f-bd96-145571e29d74',
    date: 'Auguest 2023',
    amount: '$498.23',
  }, {
    id: '3ac68afc-c605-48d3-a4f8-fbd91aa97f65',
    date: 'July 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f-3da1-471f-bd96-145571e29d75',
    date: 'June 2023',
    amount: '$498.23',
  }]);

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]}
        data={invoices}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent keyword={keyword} onSort={() => {}} />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  )
}

export default ProfileInvoices;
