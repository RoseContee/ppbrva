import React, { FC, useCallback, useState } from 'react';
import {
  FlatList,
  Linking,
  SafeAreaView,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import axios from 'axios';
import rssParser from 'react-native-rss-parser';
import Image from 'react-native-scalable-image';
import { useAppDispatch, useAppSelector } from '../store';
import { getMe } from '../store/user';
import { getEvents, saveEvents, IEventProps } from '../store/events';
import { dateFormat } from '../utils/lib';
import Loading from '../components/basic/loading';
import PageTitle from '../components/basic/page-title';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import imgEvent from '../assets/img/tmp/event.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface ItemProps {
  width: number,
  event: IEventProps,
}

const ItemComponent: FC<ItemProps> = ({width, event}): JSX.Element => {
  return (
    <View style={[s.pX7, t.mB4]}>
      <TouchableOpacity onPress={() => Linking.openURL(event.link)}>
        <Card style={[t.pX2, t.pY4]}>
          <Image source={event.image ? {uri: event.image} : imgEvent}
            width={width - 28 * 2 - 8 * 2}
          />
          <View style={[t.pX4, t.mT6]}>
            <Text style={[t.textBase, s.textGray]}>
              { dateFormat(event.date) }
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
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const events = useAppSelector(getEvents);
  const { width } = useWindowDimensions();
  const [loading, setLoading] = useState(false);

  useFocusEffect(
    useCallback(() => {
      setLoading(true);
      axios.get(`https://ppbrva.com/feed/`)
      .then(({ data }) => {
        rssParser.parse(data)
        .then(rss => {
          dispatch(saveEvents(
            rss.items.map(item => ({
              id: item.id,
              image: (item.enclosures[0] || {}).url,
              date: item.published,
              title: item.title,
              link: item.links[0].url
            }))
          ));
        }).finally(() => setLoading(false));
      }).finally(() => setLoading(false));
    }, [])
  );

  return (
    <>
      <Loading show={loading} />
      <SafeAreaView style={[t.bgWhite]}>
        <FlatList style={[t.hFull]}
          data={events}
          keyExtractor={item => item.id}
          ListHeaderComponent={() => <PageTitle title={me.name} style={[t.mB3]} />}
          ListEmptyComponent={() => {
            return (
              <Text style={[s.textGray, t.textXl, t.textCenter, s.pX7, t.pY10]}>
                Events not found.
              </Text>
            );
          }}
          renderItem={({ item }) => <ItemComponent width={width} event={item} />}
        />
      </SafeAreaView>
    </>
  );
};

export default Events;
