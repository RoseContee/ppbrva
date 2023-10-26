import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation, useRoute } from '@react-navigation/native';
import Layouts from '../../components/layouts/home';
import Button from '../../components/basic/button';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconPDF from '../../assets/img/icons/pdf.svg';
import { InvoiceProps } from './invoices';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const InvoiceDetail: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const invoice = (route.params as any)?.invoice as InvoiceProps;
  const items = [{
    name: 'Food & Beverage',
    price: 45.00,
  }, {
    name: 'Court Usage',
    price: 95.00,
  }, {
    name: 'Lessons',
    price: 95.00,
  }, {
    name: 'Rentals',
    price: 0.00,
  }, {
    name: 'Merchandise',
    price: 274.67,
  }];
  const total = items.reduce((e, t) => {
    return e + t.price;
  }, 0);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Invoices' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <View style={[s.pX7]}>
        <Card style={[s.mT7]}>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pX2, t.pT4, t.pB5]}>
            <View style={[t.flexShrink, t.pR2]}>
              <Title style={[t.textXl, s.textPrimary]}>
                Invoice #{ invoice && invoice.id }
              </Title>
              <Text style={[t.textBase, s.textGray, t.mT2]}>
                12/1/23 - 12/31/23
              </Text>
            </View>
            <IconPDF width={38} height={38} />
          </View>
          {items.map((item, index) => {
            return (
              <View key={index}
                style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY5]}>
                <Text style={[s.fontBodyLight, t.textBase, t.pR3]}>
                  { item.name }
                </Text>
                <Text style={[s.fontBodyLight, t.textBase]}>
                  ${ item.price.toFixed(2) }
                </Text>
              </View>
            )
          })}
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pT5, t.pB3]}>
            <Text style={[s.fontBodyBold, t.textBase, t.pR3]}>
              TOTAL
            </Text>
            <Text style={[s.fontBodyBold, t.textBase]}>
              ${ total.toFixed(2) }
            </Text>
          </View>
        </Card>
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={() => {}}
        >
          Download PDF
        </Button>
      </View>
    </Layouts>
  );
};

export default InvoiceDetail;
