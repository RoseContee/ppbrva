import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  FlatList,
  View
} from 'react-native';
import {
  NavigationProp, useFocusEffect, useNavigation
} from '@react-navigation/native';
import axios from '../../utils/axios';
import { currencyFormat } from '../../utils/lib';
import Layouts from '../../components/layouts';
import SearchBar from '../../components/basic/search-bar';
import Message from '../../components/basic/message';
import SettingCard from '../../components/basic/setting-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface InvoiceItem {
  invoiceID: string,
  period: string,
  amount: string,
  period_timestamp: number
}

type SortType = 'newest' | 'oldest' | 'highest' | 'lowest';

interface IHeaderProps {
  keyword: string,
  onSearch: (keyword: string) => void,
  sort: SortType,
  onSort: (type: SortType) => void,
}

const HeaderComponent: FC<IHeaderProps> = ({
  keyword,
  onSearch,
  sort,
  onSort,
}): JSX.Element => {
  return (
    <SearchBar style={[t.mT10, t.mB3]}
      keyword={keyword}
      onSearch={onSearch}
      buttonText="Sort"
      items={[
        {value: 'newest', text: 'Newest First'},
        {value: 'oldest', text: 'Oldest First'},
        {value: 'highest', text: 'Highest Total First'},
        {value: 'lowest', text: 'Lowest Total First'},
      ]}
      activeMenu={sort}
      onMenuSelect={menu => onSort(menu as SortType)}
    />
  );
};

interface IItemProps {
  navigation: NavigationProp<ReactNavigation.RootParamList>,
  invoice: InvoiceItem,
}

const ItemComponent: FC<IItemProps> = ({navigation, invoice}): JSX.Element => {
  return (
    <View style={[s.pX7, t.mT6]}>
      <SettingCard title={ invoice.period }
        description={ currencyFormat(invoice.amount) }
        onPress={() => {
          navigation.navigate({
            name: 'InvoiceDetail',
            params: {
              title: invoice.period,
              invoiceID: invoice.invoiceID,
            },
          } as never);
        }}
      />
    </View>
  );
};

const Invoices: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const [loading, setLoading] = useState<boolean>(false);
  const [invoices, setInvoices] = useState<InvoiceItem[]>([]);
  const [keyword, setKeyword] = useState<string>('');
  const [sort, setSort] = useState<SortType>('newest');

  const filteredInvoices = invoices.filter(invoice => {
    const q = keyword.toLowerCase();
    return invoice.invoiceID.toLocaleLowerCase().includes(q)
      || invoice.amount.toLocaleLowerCase().includes(q)
      || invoice.period.toLocaleLowerCase().includes(q)
  });
  filteredInvoices.sort((a, b) => {
    if (sort === 'newest') {
      return b.period_timestamp - a.period_timestamp;
    } else if (sort === 'oldest') {
      return a.period_timestamp - b.period_timestamp;
    } else if (sort === 'highest') {
      return Number(b.amount) - Number(a.amount);
    } else {
      return Number(a.amount) - Number(b.amount);
    }
  });

  useFocusEffect(
    useCallback(() => {
      if (!invoices.length) setLoading(true);
      axios.get(`invoices`)
      .then(({ data }) => {
        setInvoices(data.invoices);
      }).finally(() => setLoading(false));
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('BillingProfile' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const renderListHeader = () => {
    return (
      <HeaderComponent
        keyword={keyword} onSearch={setKeyword}
        sort={sort} onSort={setSort}
      />
    );
  };

  return (
    <Layouts flatlist={true} loading={loading}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={filteredInvoices}
        keyExtractor={item => item.invoiceID}
        ListHeaderComponent={renderListHeader()}
        ListEmptyComponent={() => <Message style={[t.mT10]} text={'Invoices not found.'} />}
        renderItem={({item}) => <ItemComponent navigation={navigation} invoice={item} />}
      />
    </Layouts>
  );
};

export default Invoices;
