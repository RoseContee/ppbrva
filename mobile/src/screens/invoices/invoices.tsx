import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  FlatList,
  SafeAreaView,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import SearchBar from '../../components/basic/search-bar';
import SettingCard from '../../components/basic/setting-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IHeaderProps {
}

const HeaderComponent: FC<IHeaderProps> = ({}): JSX.Element => {
  return <SearchBar style={[t.mT10, t.mB3]} />
};

export interface InvoiceProps {
  id: string,
  date: string,
  amount: string,
}

const ItemComponent: FC<InvoiceProps> = (invoice): JSX.Element => {
  const navigation = useNavigation();
  return (
    <View style={[s.pX7, t.mT6]}>
      <SettingCard title={ invoice.date } description={ invoice.amount }
        onPress={() => {
          navigation.navigate({
            name: 'InvoiceDetail',
            params: {
              heaterTitle: invoice.date,
              invoice,
            },
          } as never);
        }}
      />
    </View>
  );
};

const Invoices: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const [invoices, setInvoices] = useState<InvoiceProps[]>([{
    id: 'bd7acbea',
    date: 'December 2023',
    amount: '$228.46',
  }, {
    id: '3ac68afc',
    date: 'November 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f',
    date: 'October 2023',
    amount: '$498.23',
  }, {
    id: '3ac68afc1',
    date: 'September 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f2',
    date: 'Auguest 2023',
    amount: '$498.23',
  }, {
    id: '3ac68afc3',
    date: 'July 2023',
    amount: '$175.29',
  }, {
    id: '58694a0f4',
    date: 'June 2023',
    amount: '$498.23',
  }]);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('BillingProfile' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={invoices}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  );
};

export default Invoices;
