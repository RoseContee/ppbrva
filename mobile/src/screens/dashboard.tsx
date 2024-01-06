import React, { FC, useCallback, useState } from 'react';
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
import { mainRoutes } from '../routes';
import {
  fetchDashboard, fetchLocation, fetchMe, fetchPlan
} from '../requests';
import { useAppSelector } from '../store';
import { getDashboard } from '../store/settings';
import { getMe, getPlan } from '../store/user';
import Layouts from '../components/layouts';
import PageTitle from '../components/basic/page-title';
import Modal from '../components/basic/modal';
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
}

const Dashboard: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const settings = useAppSelector(getDashboard);
  const me = useAppSelector(getMe);
  const plan = useAppSelector(getPlan);
  const { width } = useWindowDimensions();
  const [showModal, setShowModal] = useState(false);
  const [message, setMessage] = useState('');
  const status = me.status;
  const padding = 28; //t.p7
  const cardWidth = (width - (padding * 2) - padding) / 2;
  const cardImgSize = cardWidth - (16 * 2); //t.pX4

  useFocusEffect(
    useCallback(() => {
      fetchMe();
      fetchLocation();
      fetchPlan();
      fetchDashboard();
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        BackHandler.exitApp();
        return true;
      });
      return () => subscribe.remove();
    }, [])
  );

  const gotoScreen = (screen: string) => {
    navigation.navigate(screen as never);
  }

  const openBillingProfile = () => {
    gotoScreen('BillingProfile');
  }

  const openLink = (link: string) => {
    if (status === 'paused') {
      setMessage('Your account is in Paused status and cannot reserve courts at this time.');
      setShowModal(true);
      return;
    }
    if (status === 'suspended') {
      setMessage('Your account is in Suspended status and cannot reserve courts at this time. Please update your billing information or contact the front desk for assistance.');
      setShowModal(true);
      return;
    }
    Linking.openURL(link);
  }

  return (
    <Layouts>
      <Modal text={message}
        show={showModal} onClose={() => setShowModal(false)}
      />
      <PageTitle title={`Welcome back ${ me.name }!`} />
      {
        !me.card_last4 &&
        <Message style={[t.mT4]}>
          <Text style={[t.flexShrink, t.textBase, s.textGray, t.pR4]}>
            Please update your <Link onPress={openBillingProfile}>billing profile</Link>
          </Text>
          <Button style={[s.bgPrimary, s.messageBtn, t.pX5]} titleStyle={[t.textSm]}
            onPress={openBillingProfile}
          >
            Fix
          </Button>
        </Message>
      }
      <View style={[s.pX7]}>
        <View style={[t.flexRow, t.flexWrap, {gap: padding}, t.mT8]}>
          <CardWidget cardWidth={cardWidth} defaultImage={imgPlay}
            image={settings.play_icon} imgSize={cardImgSize} text="Play"
            onPress={() => openLink(settings.play_link ?? 'https://app.pingpod.com/')}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgImprove}
            image={settings.improve_icon} imgSize={cardImgSize} text="Improve"
            onPress={() => openLink(settings.improve_link ?? 'https://app.pingpod.com/')}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgRent}
            image={settings.rent_icon} imgSize={cardImgSize} text="Rent"
            onPress={() => openLink(settings.rent_link ?? 'https://app.pingpod.com/')}
          />
          <CardWidget cardWidth={cardWidth} defaultImage={imgShop}
            image={settings.shop_icon} imgSize={cardImgSize} text="Shop"
            onPress={() => openLink(settings.shop_link ?? 'https://ppbrva.com/shop/')}
          />
        </View>
        <View style={[t.mT8]}>
          <SettingCard title={plan.name} description={`Member #${ me.memberID }`}
            image={me.avatar}
            onPress={() => gotoScreen(mainRoutes.MembershipPlan)}
          />
        </View>
      </View>
    </Layouts>
  );
}

export default Dashboard;
