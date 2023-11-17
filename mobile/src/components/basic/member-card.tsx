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
import { MemberProps } from '../../screens/members/members';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  member: MemberProps
  onPress?: () => void,
}

const MemberCard: FC<IProps> = ({
  style,
  member,
  onPress,
}): JSX.Element => {
  return (
    <TouchableOpacity onPress={onPress} activeOpacity={onPress ? 0.2 : 1}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY4, style]}>
        <View style={[t.flexShrink, t.pR2]}>
          <Title style={[t.textXl, s.textPrimary]}>
            { member.name }
          </Title>
          {
            member.profile.share_age_gender ? (
              <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.capitalize, t.mT2]}>
                { member.profile.gender }, { member.profile.age}
              </Text>
            ) : (<></>)
          }
        </View>
        <View style={[t.pX2]}>
          <Title style={[s.fontTitleCond, t.textSm, t.textCenter]}>
            DUPR
          </Title>
          <Title style={[t.text2xl, t.textCenter]}>
            { member.profile.rating }
          </Title>
        </View>
        <ProfileImage style={[s.cardListImage]}
          image={member.avatar}
        />
      </Card>
    </TouchableOpacity>
  );
}

export default MemberCard;
