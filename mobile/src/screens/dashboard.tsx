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
import Layouts from '../components/layouts/home';
import PageTitle from '../components/basic/page-title';
import Message from '../components/basic/message';
import Link from '../components/basic/link';
import Button from '../components/basic/button';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';
import SettingCard from '../components/basic/setting-card';

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
    <Card style={[t.itemsCenter, t.p4, {width: cardWidth}]}>
      <Image source={image} resizeMode="contain"
        style={{width: imgSize, height: imgSize}}
      />
      <Title style={[s.textGray, t.text2xl]}>
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
  const padding = 28; //t.p7
  const cardWidth = (width - (padding * 2) - padding) / 2;
  const cardImgSize = cardWidth - (16 * 2); //t.pX4

  useFocusEffect(
    useCallback(() => {
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        BackHandler.exitApp();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  return (
    <Layouts>
      <PageTitle title={`Welcome back ${ me.name }!`} />
      {
        !me.card_id &&
        <Message style={[t.mT4]}>
          <Text style={[t.flexShrink, t.textBase, s.textGray, t.pR4]}>
            Please update your <Link onPress={() => navigation.navigate('BillingProfile' as never)}>billing profile</Link>
          </Text>
          <Button style={[s.bgPrimary, s.messageBtn, t.pX5]} titleStyle={[t.textSm]}
            onPress={() => navigation.navigate('BillingProfile' as never)}
          >
            Fix
          </Button>
        </Message>
      }
      <View style={[s.pX7]}>
        <View style={[t.flexRow, t.flexWrap, {gap: padding}, t.mT8]}>
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
        <View style={[t.mT8]}>
          <SettingCard title={plan.name} description={`Member #${ me.memberID }`}
            image={me.avatar}
            onPress={() => navigation.navigate('MembershipPlan' as never)}
          />
        </View>
      </View>
    </Layouts>
  );
};

export default Dashboard;
