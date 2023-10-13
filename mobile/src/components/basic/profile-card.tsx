import React, { FC } from 'react';
import {
  Image,
  ImageSourcePropType,
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  image: ImageSourcePropType,
  dupr: number,
  gender: string,
  age: number,
  matches: number,
  wins: number,
  losses: number,
}

const ProfileCard: FC<IProps> = ({
  style,
  image,
  dupr,
  gender,
  age,
  matches,
  wins,
  losses,
}): JSX.Element => {
  return (
    <Card style={[t.p4, style]}>
      <View style={[t.flexRow, t.itemsCenter]}>
        <Image source={image} style={[s.profileCardImage]} />
        <View style={[t.flexShrink, t.pL4]}>
          <Title style={[s.profileCardTitle]}>DUPR { dupr }</Title>
          <Text style={[t.textSm, s.textGray, t.mT1]}>{ gender }, { age }</Text>
        </View>
      </View>
      <View style={[t.flexRow, t.itemsCenter, t.mT5]}>
        <Text style={[t.textCenter, s.textTiny, s.textGray, t.w1_3]}>
          MATCHES
        </Text>
        <Text style={[t.textCenter, s.textTiny, s.textGray, t.w1_3]}>
          WINS
        </Text>
        <Text style={[t.textCenter, s.textTiny, s.textGray, t.w1_3]}>
          LOSSES
        </Text>
      </View>
      <View style={[t.flexRow, t.itemsCenter, t.mT1]}>
        <Text style={[s.fontBodyBold, t.textCenter, t.textBase, s.textTitle, t.w1_3]}>
          { matches }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.textBase, s.textTitle, s.borderL, s.borderR, t.w1_3]}>
          { wins }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.textBase, s.textTitle, t.w1_3]}>
          { losses }
        </Text>
      </View>
    </Card>
  )
}

export default ProfileCard;
