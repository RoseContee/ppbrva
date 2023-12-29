import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  TextInput,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { postUpdateBilling } from '../../requests';
import { useAppDispatch, useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts';
import SettingCard from '../../components/basic/setting-card';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import Brand from '../../components/basic/card-brand';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const BillingProfile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>();
  const [number, setNumber] = useState<string>();
  const [expires, setExpires] = useState<string>();
  const [cvv, setCvv] = useState<string>();
  const [address, setAddress] = useState<string>();
  const [zipcode, setZipcode] = useState<string>();

  useFocusEffect(
    useCallback(() => {
      initStates();
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate(mainRoutes.Profile as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const initStates = () => {
    setMessage('');
    setNumber('');
    setExpires('');
    setCvv('');
    setAddress('');
    setZipcode('');
  }

  const addCard = () => {
    setLoading(true);
    setMessage('');
    postUpdateBilling({ number, expires, cvv, address, zipcode })
      .then(() => {
        initStates();
        setMessage('New card added successfully');
      })
      .catch(setMessage)
      .finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[s.pX7, t.mT5]}>
        <SettingCard title="Monthly Invoices" description="View your billing history"
          onPress={() => navigation.navigate(mainRoutes.InvoiceScreen as never)}
        />
      </View>
      <Message style={[t.mT8]} text={message} />
      <View style={[s.pX7]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT10]}>
          <Title style={[t.textXl, t.pB1]}>Add New Card</Title>
          {
            me.card_last4 &&
            <View style={[t.flexRow, t.itemsCenter]}>
              <Brand brand={me.card_type} />
              <Text style={[s.textGray, t.textXl, t.pL2]}>**** { me.card_last4 }</Text>
            </View>
          }
        </View>
        <MaskInput inputMode="numeric" style={[s.input, s.mT7]}
          keyboardType="number-pad"
          placeholder="Enter card number..." placeholderTextColor={theme.color.placeholder}
          mask={[/\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/]}
          value={number} onChangeText={masked => setNumber(masked)}
        />
        <View style={[t.flexRow, s.mT7]}>
          <View style={[t.w3_5, s.pR7]}>
            <MaskInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="MM/YY" placeholderTextColor={theme.color.placeholder}
              mask={[/\d/, /\d/, '/', /\d/, /\d/]}
              value={expires} onChangeText={masked => setExpires(masked)}
            />
          </View>
          <View style={[t.w2_5]}>
            <TextInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="CVV" placeholderTextColor={theme.color.placeholder}
              value={cvv} onChangeText={setCvv}
            />
          </View>
        </View>
        <TextInput inputMode="text" style={[s.input, s.mT7]}
          placeholder="Billing address..." placeholderTextColor={theme.color.placeholder}
          value={address} onChangeText={setAddress}
        />
        <View style={[t.flexRow, s.mT7]}>
          <View style={[t.w3_5, t.pR4]}>
            <TextInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="Zip code..." placeholderTextColor={theme.color.placeholder}
              value={zipcode} onChangeText={setZipcode}
            />
          </View>
        </View>
        <Button style={[s.bgPrimary, s.mT7]}
          disabled={!number || !expires || !cvv || !address || !zipcode}
          onPress={addCard}
        >
          Add Card
        </Button>
      </View>
    </Layouts>
  );
}

export default BillingProfile;
