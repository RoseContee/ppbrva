import React, { FC } from 'react';
import {
  Image,
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';

import imgProfile from '../../assets/img/tmp/profile.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  name: string,
  gender: string,
  age: number,
  dupr: number,
  image: string,
}

const MemberCard: FC<IProps> = ({
  style,
  name,
  gender,
  age,
  dupr,
  image,
}): JSX.Element => {
  return (
    <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, style]}>
      <View style={[t.flexGrow, t.pR2]}>
        <Title style={[t.textXs, s.textPrimary]}>
          { name }
        </Title>
        <Text style={[s.fontBodyLight, s.textTiny, t.mT1]}>
          { gender }, { age}
        </Text>
      </View>
      <View style={[t.pX2]}>
        <Title style={[s.fontTitleCond, s.textTiny, t.textCenter]}>
          DUPR
        </Title>
        <Title style={[t.textBase, t.textCenter]}>
          { dupr }
        </Title>
      </View>
      <Image source={image || imgProfile} style={[s.cardListImage]} />
    </Card>
  );
}

export default MemberCard;
