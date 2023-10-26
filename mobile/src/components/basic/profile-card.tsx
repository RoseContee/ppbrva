import React, { FC } from 'react';
import {
  StyleProp,
  Text as BaseText,
  View,
  ViewStyle
} from 'react-native';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import ProfileImage from './profile-image';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  image?: string,
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
    <Card style={[style]}>
      <View style={[t.flexRow, t.itemsCenter]}>
        <ProfileImage image={image} style={[s.profileCardImage]} />
        <View style={[t.flexShrink, t.pL6]}>
          <Title style={[s.profileCardTitle]}>
            DUPR <BaseText style={[s.fontBodyBold, t.text4xl]}>{ dupr }</BaseText>
          </Title>
          <Text style={[t.textXl, s.textGray, t.mT1]}>{ gender }, { age }</Text>
        </View>
      </View>
      <View style={[t.flexRow, t.itemsCenter, t.mT10]}>
        <Text style={[t.textCenter, t.textSm, s.textGray, t.w1_3]}>
          MATCHES
        </Text>
        <Text style={[t.textCenter, t.textSm, s.textGray, t.w1_3]}>
          WINS
        </Text>
        <Text style={[t.textCenter, t.textSm, s.textGray, t.w1_3]}>
          LOSSES
        </Text>
      </View>
      <View style={[t.flexRow, t.itemsCenter, t.mT2]}>
        <Text style={[s.fontBodyBold, t.textCenter, t.text2xl, s.textTitle, t.w1_3]}>
          { matches }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.text2xl, s.textTitle, s.borderL, s.borderR, t.w1_3]}>
          { wins }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.text2xl, s.textTitle, t.w1_3]}>
          { losses }
        </Text>
      </View>
    </Card>
  )
}

export default ProfileCard;
