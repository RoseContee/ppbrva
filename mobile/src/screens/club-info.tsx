import React, { FC, useCallback } from 'react';
import {
  Linking,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import { fetchLocation } from '../requests';
import { useAppSelector } from '../store';
import { getLocation } from '../store/user';
import Image from 'react-native-scalable-image';
import Layouts from '../components/layouts';
import PageTitle from '../components/basic/page-title';
import Link from '../components/basic/link';
import Text from '../components/basic/text';
import Button from '../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

const ClubInfo: FC = (): JSX.Element => {
  const location = useAppSelector(getLocation);
  const { width } = useWindowDimensions();
  const lat = Number(location.lat);
  const lng = Number(location.lng);
  const map_link = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&dir_action=navigate`;

  useFocusEffect(
    useCallback(() => {
      fetchLocation();
    }, [])
  );

  return (
    <Layouts>
      <PageTitle title={location.name} />
      <Image source={{uri: location.image}} width={width} style={[t.mT5]} />
      <View style={[s.pX7, t.mT3, t.mB2]}>
        <Text style={[t.textXl, t.textCenter, t.mT10]}>
          Performance Pickleball RVA
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
          onPress={() => Linking.openURL(map_link)}
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
}

export default ClubInfo;
