import React, { FC } from 'react';
import {
  View
} from 'react-native';
import Layouts from '../../components/layouts/home-layouts';
import ProfileCard from '../../components/basic/profile-card';
import Switch from '../../components/basic/switch';
import Button from '../../components/basic/button';
import IconMail from '../../assets/img/icons/mail.svg';
import IconPhoneCall from '../../assets/img/icons/phone-call.svg';

import imgProfile from '../../assets/img/tmp/profile.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const MembersAccepted: FC = (): JSX.Element => {
  return (
    <Layouts>
      <View style={[t.pX4]}>
        <ProfileCard style={[t.mT5]}
          image={imgProfile} dupr={3.5} gender={"Male"} age={57}
          matches={27} wins={19} losses={8}
        />
        <View style={[t.flexRow, t.itemsCenter, t.pX1, t.mT4]}>
          <IconMail fill={theme.color.primary}
            width={theme.size.headerIcon} height={theme.size.headerIcon}
          />
          <Switch style={[t.justifyBetween, t.flexGrow, t.pL2]}
            labelStyle={[t.textXs, s.textTitle]}
            label="sally@dinks.com"
            labelPosition="left"
            //value={true}
            onChange={() => {}}
          />
        </View>
        <View style={[t.flexRow, t.itemsCenter, t.pX1, t.mT4]}>
          <IconPhoneCall fill={theme.color.primary}
            width={theme.size.headerIcon} height={theme.size.headerIcon}
          />
          <Switch style={[t.justifyBetween, t.flexGrow, t.pL2]}
            labelStyle={[t.textXs, s.textTitle]}
            label="(805) 555-1234"
            labelPosition="left"
            //value={true}
            onChange={() => {}}
          />
        </View>
        <Button style={[s.border, s.borderPrimary, t.mT4]} titleStyle={[s.textPrimary]}
          onPress={() => {}}
        >
          Remove Friend
        </Button>
      </View>
    </Layouts>
  )
}

export default MembersAccepted;
