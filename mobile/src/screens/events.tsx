import React, { FC, useState } from 'react';
import {
  FlatList,
  SafeAreaView,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import Image from 'react-native-scalable-image';
import { useAppSelector } from '../store';
import { getMe } from '../store/user';
import PageTitle from '../components/basic/page-title';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import imgEvent from '../assets/img/tmp/event.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

const HeaderComponent: FC = (): JSX.Element => {
  const me = useAppSelector(getMe);

  return (
    <>
      <PageTitle title={me.name} style={[t.mB3]} />
    </>
  );
};

interface ItemProps {
  id: string,
  image: string,
  date: string,
  title: string,
}

const ItemComponent: FC<ItemProps> = (event): JSX.Element => {
  const { width } = useWindowDimensions();
  const imageWidth = width - 28 * 2 - 8 * 2;

  return (
    <View style={[s.pX7, t.mB4]}>
      <TouchableOpacity onPress={() => {}}>
        <Card style={[t.pX2, t.pY4]}>
          <Image source={event.image || imgEvent} width={imageWidth} />
          <View style={[t.pX4, t.mT6]}>
            <Text style={[t.textBase, s.textGray]}>
              { event.date }
            </Text>
            <Title style={[t.text2xl, t.mT1]}>
              { event.title }
            </Title>
          </View>
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
  );
};

export default Events;
