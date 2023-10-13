import React, { FC, useState } from 'react';
import {
  TextInput,
  TouchableOpacity,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
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
  const [number, setNumber] = useState<string>();
  const [expires, setExpires] = useState<string>();
  const [cvv, setCvv] = useState<string>();
  const [address, setAddress] = useState<string>();
  const [zipcode, setZipcode] = useState<string>();
  const navigation = useNavigation();

  return (
    <Layouts>
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
      <Message style={[t.mT6]} text="New card added successfully" />
      <View style={[t.pX4]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT6]}>
          <Title>Add New Card</Title>
          <View style={[t.flexRow, t.itemsCenter]}>
            <IconVisa width={24} height={16} />
            <Text style={[s.textGray, t.textXs, t.pL2]}>
              **** 8704
            </Text>
          </View>
        </View>
        <TextInput inputMode="text" style={[s.input, t.mT4]}
          placeholder="Card number..."
          value={number} onChange={e => setNumber(e.nativeEvent.text)}
        />
        <View style={[t.flexRow, t.mT4]}>
          <View style={[t.w3_5, t.pR4]}>
            <TextInput inputMode="text" style={[s.input]}
              placeholder="Expires..."
              value={expires} onChange={e => setExpires(e.nativeEvent.text)}
            />
          </View>
          <View style={[t.w2_5]}>
            <TextInput inputMode="numeric" style={[s.input]}
              keyboardType="number-pad"
              placeholder="CVV codes..."
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
          onPress={() => {}}
        >
          Add Card
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileBilling;
