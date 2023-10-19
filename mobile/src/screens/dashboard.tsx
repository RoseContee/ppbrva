import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  Image,
  ImageSourcePropType,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../store';
import { getMe, getPlan } from '../store/user';
import Layouts from '../components/layouts/home-layouts';
import Message from '../components/basic/message';
import Link from '../components/basic/link';
import Button from '../components/basic/button';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import imgPlay from '../assets/img/dashboard/play.png';
import imgImprove from '../assets/img/dashboard/improve.png';
import imgRent from '../assets/img/dashboard/rent.png';
import imgShop from '../assets/img/dashboard/shop.png';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface CardProps {
  cardWidth: number,
  image: ImageSourcePropType,
  imgSize: number,
  text: string,
}

const CardWidget: FC<CardProps> = ({
  cardWidth,
  image,
  imgSize,
  text,
}): JSX.Element => {
  return (
    <Card style={[t.itemsCenter, {width: cardWidth}]}>
      <Image source={image} resizeMode="contain"
        style={{width: imgSize, height: imgSize}}
      />
      <Title style={[s.textGray, t.textBase, t.mT1]}>
        { text }
      </Title>
    </Card>
  );
};

const Dashboard: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const plan = useAppSelector(getPlan);
  const { width } = useWindowDimensions();
  const padding = 16; //t.p4
  const cardWidth = (width - (padding * 2) - padding) / 2;
  const cardImgSize = cardWidth - (padding * 2);

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener("hardwareBackPress", () => {
        BackHandler.exitApp();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <Text style={[s.fontBodyLight, s.textTiny, s.textTitle, t.pX4]}>
        Welcome back { me.name }!
      </Text>
      {
        !me.card_id &&
        <Message style={[t.mT4]}>
          <Text style={[t.flexShrink, s.textTiny, s.textGray, t.pR2]}>
            Please update your <Link onPress={() => navigation.navigate('ProfileScreen' as never)}>billing profile</Link>
          </Text>
          <Button style={[s.bgPrimary, s.messageBtn]} titleStyle={[s.textTiny]}
            onPress={() => navigation.navigate('ProfileScreen' as never)}
          >
            Fix
          </Button>
        </Message>
      }
      <View style={[t.pX4]}>
        <View style={[t.flexRow, t.flexWrap, {gap: padding}, t.mT6]}>
          <CardWidget cardWidth={cardWidth}
            image={imgPlay} imgSize={cardImgSize}
            text="Play"
          />
          <CardWidget cardWidth={cardWidth}
            image={imgImprove} imgSize={cardImgSize}
            text="Improve"
          />
          <CardWidget cardWidth={cardWidth}
            image={imgRent} imgSize={cardImgSize}
            text="Rent"
          />
          <CardWidget cardWidth={cardWidth}
            image={imgShop} imgSize={cardImgSize}
            text="Shop"
          />
        </View>
        <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mT6]}>
          <View style={[t.flexShrink]}>
            <Title style={[s.textPrimary, t.textSm]}>
              { plan.name }
            </Title>
            <Text style={[s.fontBodyLight, s.textTiny, s.textGray, t.mT1]}>
              Member #{ me.memberID }
            </Text>
          </View>
          <Image source={{uri: me.avatar}} style={[s.cardListImage]} />
        </Card>
      </View>
    </Layouts>
  )
}

export default Dashboard;
