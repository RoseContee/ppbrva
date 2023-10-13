import React, { FC } from 'react';
import {
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Layouts from '../../components/layouts/home-layouts';
import MemberCard from '../../components/basic/member-card';
import Text from '../../components/basic/text';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const MembersRequest: FC = (): JSX.Element => {
  const navigation = useNavigation();

  return (
    <Layouts>
      <View style={[t.pX4]}>
        <MemberCard style={[t.mT4]}
          name={"Sally Dinks"} gender={"Female"} age={57}
          dupr={3.5} image={''}
        />
        <Text style={[s.fontBodyBold, s.textTitle, t.textCenter, t.mT6]}>
          Sally wants to be your friend!
        </Text>
        <Text style={[t.textXs, s.textGray, t.textCenter, t.mT2]}>
          Choose which contact info you want to share with Sally:
        </Text>
        <Switch style={[t.justifyBetween, t.pX4, t.mT8]}
          labelStyle={[t.textXs, s.textGray]}
          label="your@email.com"
          labelPosition="left"
          //value={true}
          onChange={() => {}}
        />
        <Switch style={[t.justifyBetween, t.pX4, t.mT4]}
          labelStyle={[t.textXs, s.textGray]}
          label="(805) 555-1234"
          labelPosition="left"
          //value={true}
          onChange={() => {}}
        />
        <Button style={[s.bgPrimary, t.mT8]}
          onPress={() => navigation.navigate('MembersAccepted' as never)}
        >
          Add Sally
        </Button>
        <Button style={[s.border, s.borderPrimary, t.mT4]} titleStyle={[s.textPrimary]}
          onPress={() => {}}
        >
          Decline
        </Button>
        <View style={[t.flexRow, t.itemsCenter, t.justifyCenter, t.mT12]}>
          <View style={[s.dot, t.mX1]} />
          <View style={[s.dot, s.bgPrimary, t.mX1]} />
          <View style={[s.dot, t.mX1]} />
        </View>
      </View>
    </Layouts>
  )
}

export default MembersRequest;
