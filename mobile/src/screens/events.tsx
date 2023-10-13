import React, { FC, useState } from 'react';
import {
  FlatList,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Image from 'react-native-scalable-image';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import imgEvent from '../assets/img/tmp/event.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

const HeaderComponent: FC = (): JSX.Element => {
  return (
    <Text style={[t.textXs, s.textTitle, t.pX4, t.mB2]}>
      Richmond West
    </Text>
  );
};

interface ItemProps {
  id: string,
  image: string,
  date: string,
  title: string,
}

const ItemComponent: FC<ItemProps> = (event): JSX.Element => {
  const {width} = useWindowDimensions();
  const imageWidth = width - 16 * 2 - 8 * 2;

  return (
    <View style={[t.pX4, t.mB4]}>
      <TouchableOpacity onPress={() => {}}>
        <Card style={[t.pX2]}>
          <Image source={event.image || imgEvent} width={imageWidth} />
          <Text style={[t.textXs, s.textGray, t.mT3]}>
            { event.date }
          </Text>
          <Title style={[t.textBase, t.mT1]}>
            { event.title }
          </Title>
        </Card>
      </TouchableOpacity>
    </View>
  );
};

const Events: FC = (): JSX.Element => {
  const [events, setEvents] = useState<ItemProps[]>([{
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28ba',
    image: '',
    date: '8/27/23',
    title: 'Omnitech Partnership Puts PPBRVA on the Cutting-Edge',
  }, {
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28bb',
    image: '',
    date: '8/27/23',
    title: 'Omnitech Partnership Puts PPBRVA on the Cutting-Edge',
  }, {
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28bc',
    image: '',
    date: '8/27/23',
    title: 'Omnitech Partnership Puts PPBRVA on the Cutting-Edge',
  }, {
    id: 'bd7acbea-c1b1-46c2-aed5-3ad53abb28bd',
    image: '',
    date: '8/27/23',
    title: 'Omnitech Partnership Puts PPBRVA on the Cutting-Edge',
  }])

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]}
        data={events}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  )
}

export default Events;
