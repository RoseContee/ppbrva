import React, { FC } from 'react';
import {
  Linking,
  View,
  useWindowDimensions
} from 'react-native';
import openMap from 'react-native-open-maps';
import Image from 'react-native-scalable-image';
import { useAppSelector } from '../store';
import { getLocation, getMe } from '../store/user';
import Layouts from '../components/layouts/home';
import PageTitle from '../components/basic/page-title';
import Link from '../components/basic/link';
import Text from '../components/basic/text';
import Button from '../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

const Dashboard: FC = (): JSX.Element => {
  const me = useAppSelector(getMe);
  const location = useAppSelector(getLocation);
  const { width } = useWindowDimensions();

  return (
    <Layouts>
      <PageTitle title={me.name} />
      <Image source={{uri: location.image}} width={width} style={[t.mT5]} />
      <View style={[s.pX7, t.mT3, t.mB2]}>
        <Text style={[t.textXl, t.textCenter, t.mT10]}>
          Performace Pickleball RVA
        </Text>
        <Text style={[s.fontBodyLight, t.textXl, t.textCenter, t.mT2]}>
          { location.address }
        </Text>
        <Link style={[s.fontBodyLight, t.textXl, t.textCenter, t.mT2]}
          onPress={() => Linking.openURL('https://ppbrva.com/')}
        >
          www.ppbrva.com
        </Link>
        <View style={[t.mY3]} />
        <Button style={[s.bgPrimary, t.mT10]}
          onPress={() => openMap({latitude: Number(location.lat), longitude: Number(location.lng)})}
        >
          Directions
        </Button>
        <Button style={[s.border, s.borderPrimary, s.mT7]} titleStyle={[s.textPrimary]}
          onPress={() => Linking.openURL(`tel:${location.phone}`)}
        >
          Call Front Desk
        </Button>
      </View>
    </Layouts>
  );
};

export default Dashboard;
