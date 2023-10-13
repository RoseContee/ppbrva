import React, { FC, useState } from 'react';
import {
  Image,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import Layouts from '../../components/layouts/home-layouts';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Select, { SelectItemProps } from '../../components/basic/select';
import IconPDF from '../../assets/img/icons/pdf.svg';

import imgProfile from '../../assets/img/tmp/profile.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const ProfileMembershipPlan: FC = (): JSX.Element => {
  const [plans, setPlans] = useState<SelectItemProps[]>([
    { label: 'Plan1', value: 'Plan1' },
    { label: 'Plan2', value: 'Plan2' },
  ]);
  const navigation = useNavigation();

  return (
    <Layouts>
      <View style={[t.pX4]}>
        <Card style={[t.pY4, t.mT5]}>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mB2]}>
            <View style={[t.flexShrink]}>
              <Title style={[t.textXs, s.textPrimary]}>
                Elite Team Membership
              </Title>
              <Text style={[s.fontBodyLight, s.textTiny, s.textGray, t.mT1]}>
                Member #PB1054
              </Text>
            </View>
            <Image source={imgProfile} style={[s.cardListImage]} />
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT2]}>
            <IconPDF width={25} height={25} />
            <Link style={[t.pL3, t.textXs]}>
              Member Agreement
            </Link>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT2]}>
            <IconPDF width={25} height={25} />
            <Link style={[t.pL3, t.textXs]}>
              Another Doc
            </Link>
          </View>
        </Card>
        <Title style={[t.mT10]}>
          Update Plan
        </Title>
        <Select style={[t.mT4]}
          placeholder="Change plan..."
          data={plans}
          onChange={() => {}}
        />
        <Button style={[s.bgPrimary, t.mT4]}
          onPress={() => {}}
        >
          Request
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileMembershipPlan;
