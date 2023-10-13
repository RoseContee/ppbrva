import React, { FC } from 'react';
import {
  View,
  useWindowDimensions
} from 'react-native';
import Image from 'react-native-scalable-image';
import Layouts from '../components/layouts/home-layouts';
import Link from '../components/basic/link';
import Text from '../components/basic/text';
import Button from '../components/basic/button';

import imgClub from '../assets/img/tmp/club.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

const Dashboard: FC = (): JSX.Element => {
  const {width} = useWindowDimensions();

  return (
    <Layouts>
      <Text style={[s.fontBodyLight, t.textXs, s.textTitle, t.pX4]}>
        Richmond West
      </Text>
      <Image source={imgClub} width={width} style={[t.mT4]} />
      <View style={[t.pX4, t.mB2]}>
        <Text style={[t.textCenter, t.mT8]}>Performace Pickleball RVA</Text>
        <Text style={[s.fontBodyLight, t.textCenter, t.mT1]}>8641 Quioccasin Rd</Text>
        <Text style={[s.fontBodyLight, t.textCenter, t.mT1]}>Henrico, VA 23229</Text>
        <Link style={[s.fontBodyLight, t.textCenter, t.mT1]}>www.ppbrva.com</Link>
        <Button style={[s.bgPrimary, t.mT10]}
          onPress={() => {}}
        >
          Directions
        </Button>
        <Button style={[s.border, s.borderPrimary, t.mT4]} titleStyle={[s.textPrimary]}
          onPress={() => {}}
        >
          Call Front Desk
        </Button>
      </View>
    </Layouts>
  )
}

export default Dashboard;
