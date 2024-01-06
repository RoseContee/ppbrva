import React, { FC } from 'react';
import {
  StyleProp,
  TouchableOpacity,
  View,
  ViewStyle
} from 'react-native';
import { MemberProp } from '../../requests';
import Card from './card';
import Text from './text';
import Title from './title';
import ProfileImage from './profile-image';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  member: MemberProp
  onPress?: () => void,
}

const MemberCard: FC<IProps> = ({
  style,
  member,
  onPress,
}): JSX.Element => {
  const profile = member.profile || {};
  const { gender, age } = profile;
  let info = '';
  if (age) info = `${gender ? `${gender},` : 'Age'} ${age}`;
  else if (gender) info = gender;

  return (
    <TouchableOpacity onPress={onPress} activeOpacity={onPress ? 0.2 : 1}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY4, style]}>
        <View style={[t.flexGrow, t.pR2]}>
          <Title style={[t.textXl, s.textPrimary]}>
            { member.name }
          </Title>
          {
            profile.share_age_gender ? (
              <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.capitalize, t.mT2]}>
                { info }
              </Text>
            ) : (<></>)
          }
        </View>
        <View style={[t.pX2]}>
          <Title style={[s.fontTitleCond, t.textSm, t.textCenter]}>
            DUPR
          </Title>
          <Title style={[t.text2xl, t.textCenter]}>
            { profile.rating }
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
