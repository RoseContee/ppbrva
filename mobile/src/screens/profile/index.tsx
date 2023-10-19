import React, { FC } from 'react';
import {
  TouchableOpacity,
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe, getPlan, getProfile } from '../../store/user';
import Layouts from '../../components/layouts/home-layouts';
import ProfileCard from '../../components/basic/profile-card';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconSettings from '../../assets/img/icons/settings.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface MenuItemProps {
  onPress: () => void,
  title: string,
  description: string,
}

const MenuItem: FC<MenuItemProps> = ({ onPress, title, description }): JSX.Element => {
  return (
    <View style={[t.mT5]}>
      <TouchableOpacity onPress={onPress}>
        <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
          <View style={[t.flexShrink, t.pR3]}>
            <Title style={[t.textXs, s.textPrimary]}>
              { title }
            </Title>
            <Text style={[s.textTiny, s.textGray, t.mT1]}>
              { description }
            </Text>
          </View>
          <IconSettings fill={theme.color.primary}
            width={theme.size.cardIcon} height={theme.size.cardIcon}
          />
        </Card>
      </TouchableOpacity>
    </View>
  );
};

const Profile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const profile = useAppSelector(getProfile);
  const plan = useAppSelector(getPlan);

  return (
    <Layouts>
      <Text style={[s.fontBodyLight, s.textTiny, s.textTitle, t.pX4]}>
        Member #{ me.memberID }
      </Text>
      <View style={[t.pX4]}>
        <ProfileCard style={[t.mT5]}
          image={{uri: me.avatar}} dupr={3.7} gender={"Male"} age={46}
          matches={27} wins={19} losses={8}
        />
        <MenuItem title="Member Profile" description="Update member info"
          onPress={() => navigation.navigate('ProfileMember' as never)}
        />
        <MenuItem title="Billing Profile" description="Update payment info"
          onPress={() => navigation.navigate('ProfileBilling' as never)}
        />
        <MenuItem title="Membership Plan" description={plan.name}
          onPress={() => navigation.navigate('ProfileMembershipPlan' as never)}
        />
      </View>
    </Layouts>
  )
}

export default Profile;
