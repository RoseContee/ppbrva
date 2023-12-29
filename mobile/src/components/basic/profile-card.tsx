import React, { FC } from 'react';
import {
  StyleProp,
  Text as BaseText,
  View,
  ViewStyle
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { MemberProp } from '../../requests';
import Card from './card';
import Text from './text';
import Title from './title';
import ProfileImage from './profile-image';
import Button from './button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
  isMe?: boolean,
  needInputId?: boolean,
  member: MemberProp,
}

const ProfileCard: FC<IProps> = ({
  style,
  isMe,
  needInputId,
  member,
}): JSX.Element => {
  const navigation = useNavigation();
  const profile = member.profile || {};
  const { gender, age } = profile;
  let info = '';
  if (age) info = `${gender ? `${gender},` : 'Age'} ${age}`;
  else if (gender) info = gender;

  return (
    <Card style={[style]}>
      <View style={[t.flexRow, t.itemsCenter]}>
        <ProfileImage image={member.avatar} style={[s.profileCardImage]} />
        <View style={[t.flexShrink, t.pL6]}>
          <Title style={[s.profileCardTitle]}>
            DUPR <BaseText style={[s.fontBodyBold, t.text4xl]}>{ profile.rating }</BaseText>
          </Title>
          {
            isMe && needInputId ? (
              <Button style={[s.bgPrimary, s.btnXs, t.mT1]}
                onPress={() => navigation.navigate(mainRoutes.MemberProfile as never)}
              >
                Add Dupr ID
              </Button>
            ) : isMe || profile.share_age_gender ? (
              <Text style={[t.textXl, s.textGray, t.capitalize, t.mT1]}>
                { info }
              </Text>
            ) : (<></>)
          }
        </View>
      </View>
      {/* <View style={[t.flexRow, t.itemsCenter, t.mT10]}>
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
          { member.profile.matches }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.text2xl, s.textTitle, s.borderL, s.borderR, t.w1_3]}>
          { member.profile.wins }
        </Text>
        <Text style={[s.fontBodyBold, t.textCenter, t.text2xl, s.textTitle, t.w1_3]}>
          { member.profile.losses }
        </Text>
      </View> */}
    </Card>
  )
}

export default ProfileCard;
