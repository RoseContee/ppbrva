import React, { FC, useCallback } from 'react';
import {
  BackHandler,
  Image,
  ImageSourcePropType,
  Linking,
  Platform,
  TouchableOpacity,
  View,
  useWindowDimensions
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { useAppDispatch, useAppSelector } from '../store';
import { getMe } from '../store/user';
import { getAppicons, saveAppicons } from '../store/settings';
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
    <TouchableOpacity onPress={onPress} style={[t.p2]}>
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
  const appicons = useAppSelector(getAppicons);
  const { width } = useWindowDimensions();
  const padding = 28; //t.p7
  const cardWidth = (width - (padding * 2) - padding) / 2;
  const cardImgSize = cardWidth - (16 * 2); //t.pX4
  const link = Platform.OS == 'android' ? 'https://play.google.com/store/apps/details?id=com.courtreserve'
          : 'https://apps.apple.com/us/app/courtreserve/id1392556575';

  useFocusEffect(
    useCallback(() => {
      axios.get(`settings/appicons`)
      .then(({ data: { appicons } }) => {
        dispatch(saveAppicons(appicons));
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
            image={appicons.play} imgSize={cardImgSize} text="Play"
            onPress={() => Linking.openURL(link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgImprove}
            image={appicons.improve} imgSize={cardImgSize} text="Improve"
            onPress={() => Linking.openURL(link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgRent}
            image={appicons.rent} imgSize={cardImgSize} text="Rent"
            onPress={() => Linking.openURL(link)}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgShop}
            image={appicons.shop} imgSize={cardImgSize} text="Shop"
            onPress={() => Linking.openURL(link)}
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
