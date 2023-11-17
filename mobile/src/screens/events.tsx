import React, { FC, useCallback, useState } from 'react';
import {
  FlatList,
  Linking,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import { parse as HtmlParse} from 'fast-html-parser';
import rssParser from 'react-native-rss-parser';
import _ from 'lodash';
import Image from 'react-native-scalable-image';
import axios from 'axios';
import { useAppSelector } from '../store';
import { getMe } from '../store/user';
import { dateFormat } from '../utils/lib';
import Layouts from '../components/layouts';
import Message from '../components/basic/message';
import PageTitle from '../components/basic/page-title';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import imgEvent from '../assets/img/event.jpg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface EventItem {
  id: string
  image: string | null
  date: string
  title: string
  link: string
}

interface IHeaderProps {
  width: number,
  event: EventItem,
}

const ItemComponent: FC<IHeaderProps> = ({width, event}): JSX.Element => {
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
  const me = useAppSelector(getMe);
  const { width } = useWindowDimensions();
  const [loading, setLoading] = useState<boolean>(false);
  const [events, setEvents] = useState<EventItem[]>([]);

  useFocusEffect(
    useCallback(() => {
      if (!events.length) setLoading(true);
      axios.get(`https://ppbrva.com/feed/`)
      .then(({ data }) => {
        rssParser.parse(data)
        .then(rss => {
          setEvents(rss.items.map(item => {
            const img = HtmlParse(item.content).querySelector('#rss-image img');
            return {
              id: item.id,
              image: img ? (_.trim(img.rawAttributes.src, '"<')) : null,
              date: item.published,
              title: item.title,
              link: item.links[0].url
            };
          }));
        }).finally(() => setLoading(false));
      }).finally(() => setLoading(false));
    }, [])
  );

  return (
    <Layouts flatlist={true} loading={loading}>
      <FlatList style={[t.hFull]}
        data={events}
        keyExtractor={(item, index) => index + '-' + item.id}
        ListHeaderComponent={() => <PageTitle title={me.name} style={[t.mB3]} />}
        ListEmptyComponent={() => <Message style={[t.mT10]} text={'Events not found.'} />}
        renderItem={({ item }) => <ItemComponent width={width} event={item} />}
      />
    </Layouts>
  );
};

export default Events;
