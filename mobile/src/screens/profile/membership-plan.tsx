import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe, getPlan } from '../../store/user';
import Layouts from '../../components/layouts/home';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import Link from '../../components/basic/link';
import Button from '../../components/basic/button';
import Select, { SelectItemProps } from '../../components/basic/select';
import ProfileImage from '../../components/basic/profile-image';
import IconPDF from '../../assets/img/icons/pdf.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const ProfileMembershipPlan: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const plan = useAppSelector(getPlan);
  const [plans, setPlans] = useState<SelectItemProps[]>([
    { label: 'Plan1', value: 'Plan1' },
    { label: 'Plan2', value: 'Plan2' },
  ]);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Profile' as never);
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <View style={[s.pX7]}>
        <Card style={[t.pY6, t.mY5]}>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mB2]}>
            <View style={[t.flexShrink, t.pR3]}>
              <Title style={[t.textXl, s.textPrimary]}>
                { plan.name }
              </Title>
              <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.mT1]}>
                Member #{ me.memberID }
              </Text>
            </View>
            <ProfileImage image={me.avatar} style={[s.membershipCardImage]} />
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT5]}>
            <IconPDF width={35} height={35} />
            <Link style={[t.textBase, t.pL4]}>
              Member Agreement
            </Link>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT5]}>
            <IconPDF width={35} height={35} />
            <Link style={[t.textBase, t.pL4]}>
              Another Doc
            </Link>
          </View>
        </Card>
        <Title style={[t.textXl, t.mT12]}>
          Update Plan
        </Title>
        <Select style={[t.mT5]}
          placeholder="Change plan..."
          data={plans}
          onChange={() => {}}
        />
        <Button style={[s.bgPrimary, s.mT7]}
          onPress={() => {}}
        >
          Request
        </Button>
      </View>
    </Layouts>
  );
};

export default ProfileMembershipPlan;
