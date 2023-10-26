import React, { FC } from 'react';
import {
  StyleProp,
  TouchableOpacity,
  View,
  ViewStyle
} from 'react-native';
import Card from './card';
import Text from './text';
import Title from './title';
import ProfileImage from './profile-image';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  onPress: () => void,
  name: string,
  gender: string,
  age: number,
  dupr: number,
  image?: string,
}

const MemberCard: FC<IProps> = ({
  style,
  onPress,
  name,
  gender,
  age,
  dupr,
  image,
}): JSX.Element => {
  return (
    <TouchableOpacity onPress={onPress}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY4, style]}>
        <View style={[t.flexGrow, t.pR2]}>
          <Title style={[t.textXl, s.textPrimary]}>
            { name }
          </Title>
          <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.mT2]}>
            { gender }, { age}
          </Text>
        </View>
        <View style={[t.pX2]}>
          <Title style={[s.fontTitleCond, t.textSm, t.textCenter]}>
            DUPR
          </Title>
          <Title style={[t.text2xl, t.textCenter]}>
            { dupr }
          </Title>
        </View>
        <ProfileImage image={image} style={[s.cardListImage]} />
      </Card>
    </TouchableOpacity>
  );
}

export default MemberCard;
