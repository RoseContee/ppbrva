import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  Image,
  ImageSourcePropType,
  Linking,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { useAppDispatch, useAppSelector } from '../store';
import { getMe } from '../store/user';
import {
  getDashboardIcons, getDashboardLinks, saveDashboard
} from '../store/settings';
import axios from '../utils/axios';
import Layouts from '../components/layouts';
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
  image?: string,
  defaultImage: ImageSourcePropType,
  imgSize: number,
  text: string,
  onPress: () => void,
}

const CardWidget: FC<CardProps> = ({
  cardWidth,
  image,
  defaultImage,
  imgSize,
  text,
  onPress,
}): JSX.Element => {
  return (
    <TouchableOpacity onPress={onPress}>
      <Card style={[t.itemsCenter, t.p4, {width: cardWidth}]}>
        <Image source={image ? {uri: image} : defaultImage}
          resizeMode="contain"
          style={{width: imgSize, height: imgSize}}
        />
        <Title style={[s.textGray, t.text2xl]}>
          { text }
        </Title>
      </Card>
    </TouchableOpacity>
  );
};

const Dashboard: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const dispatch = useAppDispatch();
  const me = useAppSelector(getMe);
  const icons = useAppSelector(getDashboardIcons);
  const links = useAppSelector(getDashboardLinks);
  const { width } = useWindowDimensions();
  const padding = 28; //t.p7
  const cardWidth = (width - (padding * 2) - padding) / 2;
  const cardImgSize = cardWidth - (16 * 2); //t.pX4
  const play_link = 'https://app.pingpod.com/';
  const improve_link = 'https://app.pingpod.com/';
  const rent_link = 'https://app.pingpod.com/';
  const shop_link = 'https://ppbrva.com/shop/';

  useFocusEffect(
    useCallback(() => {
      axios.get(`settings/dashboard`)
      .then(({ data }) => {
        dispatch(saveDashboard(data));
      });
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
        !me.card_last4 &&
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
          <CardWidget cardWidth={cardWidth} defaultImage={imgPlay}
            image={icons.play} imgSize={cardImgSize} text="Play"
            onPress={() => Linking.openURL(links.play_link ?? play_link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgImprove}
            image={icons.improve} imgSize={cardImgSize} text="Improve"
            onPress={() => Linking.openURL(links.improve_link ?? improve_link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgRent}
            image={icons.rent} imgSize={cardImgSize} text="Rent"
            onPress={() => Linking.openURL(links.rent_link ?? rent_link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgShop}
            image={icons.shop} imgSize={cardImgSize} text="Shop"
            onPress={() => Linking.openURL(links.shop_link ?? shop_link)}
          />
        </View>
        <View style={[t.mT8]}>
          <SettingCard title={me.plan?.name} description={`Member #${ me.memberID }`}
            image={me.avatar}
            onPress={() => navigation.navigate('MembershipPlan' as never)}
          />
        </View>
      </View>
    </Layouts>
  );
};

export default Dashboard;
