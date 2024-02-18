import React, { FC, useState } from 'react';
import {
  View
} from 'react-native';
import { postFirstPayment } from '../../requests';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import { currencyFormat } from '../../utils/lib';
import Layouts from '../../components/layouts';
import Message from '../../components/basic/message';
import Text from '../../components/basic/text';
import Card from '../../components/basic/card';
import Title from '../../components/basic/title';
import CardBrand from '../../components/basic/card-brand';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const BillingProfile: FC = (): JSX.Element => {
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [paid, setPaid] = useState(false);

  const onPay = () => {
    setLoading(true);
    setMessage('');
    postFirstPayment()
      .then(() => {
        setMessage('Payment made successfully!');
        setPaid(true);
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <Message style={[t.mT8]} text={message} />
      {
        !paid &&
        <View style={[s.pX7]}>
          <View style={[s.mT7]}>
            {
              me.first_payment?.alert.split('\n').map((text, index) => (
                <Text key={index} style={[t.textBase]}>
                  { text.trim() }
                </Text>
              ))
            }
          </View>
          <Card style={[t.flexRow, t.justifyBetween, t.itemsCenter, s.mT7]}>
            <Title style={[t.textXl]}>Total: { currencyFormat(me.first_payment?.amount || 0) }</Title>
            <CardBrand brand={me.card_type} last4={me.card_last4} />
          </Card>
          <Button style={[s.bgPrimary, s.mT7]}
            onPress={onPay}
          >
            Pay ${me.first_payment?.amount}
          </Button>
        </View>
      }
    </Layouts>
  );
}

export default BillingProfile;
