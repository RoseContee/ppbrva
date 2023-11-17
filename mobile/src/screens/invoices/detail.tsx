import React, { FC, useCallback, useEffect, useState } from 'react';
import {
  PermissionsAndroid,
  Platform,
  View
} from 'react-native';
import {
  useFocusEffect, useNavigation, useRoute
} from '@react-navigation/native';
import axios, { downloadInvoice } from '../../utils/axios';
import { currencyFormat } from '../../utils/lib';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconPDF from '../../assets/img/icons/pdf.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface InvoiceItem {
  amount: string,
  plan_name: string,
  plan_price: string,
  from: string,
  to: string,
  activities: {
    category: string,
    detail: string,
    price: string
  }[],
}

const InvoiceDetail: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const route = useRoute();
  const [loading, setLoading] = useState<boolean>(false);
  const [invoice, setInvoice] = useState<InvoiceItem>();
  const { title, invoiceID } = route.params as any;

  useFocusEffect(
    useCallback(() => {
      setLoading(true);
      axios.get(`invoices/${invoiceID}`)
      .then(({ data }) => {
        setInvoice(data.invoice);
      }).finally(() => setLoading(false));
    }, [])
  );

  useEffect(() => {
    navigation.setOptions({title: title});
  }, [title]);

  const downloadPDF = async () => {
    if (Platform.OS === 'ios') {
      downloadInvoice(invoiceID).catch(err => console.log(err));
    } else {
      try {
        const granted = await PermissionsAndroid.request(
          PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE
        );
        if (granted === PermissionsAndroid.RESULTS.GRANTED) {
          downloadInvoice(invoiceID).catch(err => console.log(err));
        }
      } catch (err) {}
    }
  }

  return (
    <Layouts loading={loading}>
      {
        !invoice ? (
          <Message style={[t.mT10]} text={!loading ? 'Invoice not found.' : ''} />
        ) : (
          <View style={[s.pX7]}>
            <Card style={[s.mT7]}>
              <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pX2, t.pT4, t.pB5]}>
                <View style={[t.flexShrink, t.pR2]}>
                  <Title style={[t.textXl, s.textPrimary]}>
                    Invoice #{ invoiceID }
                  </Title>
                  <Text style={[t.textBase, s.textGray, t.mT2]}>
                    { invoice.from } - { invoice.to }
                  </Text>
                </View>
                <IconPDF width={38} height={38} />
              </View>
              {invoice.activities.map((activity, index) => {
                return (
                  <View key={index}
                    style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY5]}>
                    <Text style={[t.flexShrink, s.fontBodyLight, t.textBase, t.pR3]}>
                      { activity.category } - { activity.detail }
                    </Text>
                    <Text style={[s.fontBodyLight, t.textBase]}>
                      { currencyFormat(activity.price) }
                    </Text>
                  </View>
                )
              })}
              <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY5]}>
                <Text style={[s.fontBodyLight, t.textBase, t.pR3]}>
                  { invoice.plan_name }
                </Text>
                <Text style={[s.fontBodyLight, t.textBase]}>
                  { currencyFormat(invoice.plan_price) }
                </Text>
              </View>
              <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pT5, t.pB3]}>
                <Text style={[s.fontBodyBold, t.textBase, t.pR3]}>
                  TOTAL
                </Text>
                <Text style={[s.fontBodyBold, t.textBase]}>
                  { currencyFormat(invoice.amount) }
                </Text>
              </View>
            </Card>
            <Button style={[s.bgPrimary, s.mT7]}
              onPress={downloadPDF}
            >
              Download PDF
            </Button>
          </View>
        )
      }
    </Layouts>
  );
};

export default InvoiceDetail;
