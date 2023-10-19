import React, { FC, useState } from 'react';
import {
  TextInput,
  TouchableOpacity,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { useAppDispatch, useAppSelector } from '../../store';
import { SaveMe, getMe } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import MaskInput from 'react-native-mask-input';
import Layouts from '../../components/layouts/home-layouts';
import Message from '../../components/basic/message';
import Button from '../../components/basic/button';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconSettings from '../../assets/img/icons/settings.svg';
import IconVisa from '../../assets/img/icons/cards/visa.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const ProfileBilling: FC = (): JSX.Element => {
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

  const addCard = () => {
    if (!number) {
      setMessage('The card number field is required.');
      return;
    }
    if (!expires) {
      setMessage('The expires field is required.');
      return;
    }
    if (!cvv) {
      setMessage('The cvv field is required.');
      return;
    }
    if (!address) {
      setMessage('The address field is required.');
      return;
    }
    if (!zipcode) {
      setMessage('The zipcode field is required.');
      return;
    }
    setLoading(true);
    axios.post(`update-card`, {
      number, expires, cvv, address, zipcode
    }).then(({ data: { user } }) => {
      dispatch(SaveMe(user));
      setMessage('New card added successfully');
    }).catch(error => {
      console.log(error);
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  };

  return (
    <Layouts loading={loading}>
      <View style={[t.pX4, t.mT5]}>
        <TouchableOpacity onPress={() => navigation.navigate('ProfileInvoices' as never)}>
          <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
            <View style={[t.flexShrink, t.pR3]}>
                <Title style={[t.textXs, s.textPrimary]}>
                  Monthly Invoices
                </Title>
                <Text style={[s.textTiny, s.textGray, t.mT1]}>
                  View your billing history
                </Text>
            </View>
            <IconSettings fill={theme.color.primary}
              width={theme.size.cardIcon} height={theme.size.cardIcon}
            />
          </Card>
        </TouchableOpacity>
      </View>
      <Message style={[t.mT6]} text={message} />
      <View style={[t.pX4]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT6]}>
          <Title>Add New Card</Title>
          {
            me.card_id &&
            <View style={[t.flexRow, t.itemsCenter]}>
              <IconVisa width={24} height={16} />
              <Text style={[s.textGray, t.textXs, t.pL2]}>
                **** { me.card_last4 }
              </Text>
            </View>
          }
        </View>
        <MaskInput inputMode="numeric" style={[s.input, t.mT4]}
          keyboardType="number-pad"
          placeholder="1234 1234 1234 1234"
          mask={[/\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/, ' ', /\d/, /\d/, /\d/, /\d/]}
          value={number} onChangeText={(masked, unmasked) => setNumber(masked)}
        />
        <View style={[t.flexRow, t.mT4]}>
          <View style={[t.w3_5, t.pR4]}>
            <MaskInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="MM/YY"
              mask={[/\d/, /\d/, '/', /\d/, /\d/]}
              value={expires} onChangeText={(masked, unmasked) => setExpires(masked)}
            />
          </View>
          <View style={[t.w2_5]}>
            <TextInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="CVV"
              value={cvv} onChange={e => setCvv(e.nativeEvent.text)}
            />
          </View>
        </View>
        <TextInput inputMode="text" style={[s.input, t.mT4]}
          placeholder="Billing address..."
          value={address} onChange={e => setAddress(e.nativeEvent.text)}
        />
        <View style={[t.flexRow, t.mT4]}>
          <View style={[t.w3_5, t.pR4]}>
            <TextInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="Zip code..."
              value={zipcode} onChange={e => setZipcode(e.nativeEvent.text)}
            />
          </View>
        </View>
        <Button style={[s.bgPrimary, t.mT4]}
          onPress={addCard}
        >
          Add Card
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileBilling;
