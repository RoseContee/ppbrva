import React, { FC } from 'react';
import {
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe, getPlan, getProfile } from '../../store/user';
import Layouts from '../../components/layouts/home';
import PageTitle from '../../components/basic/page-title';
import ProfileCard from '../../components/basic/profile-card';
import SettingCard from '../../components/basic/setting-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

const Profile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const profile = useAppSelector(getProfile);
  const plan = useAppSelector(getPlan);

  return (
    <Layouts>
      <PageTitle title={`Member #${ me.memberID }`} />
      <View style={[s.pX7]}>
        <ProfileCard style={[s.mT7]}
          image={me.avatar} dupr={3.7} gender={"Male"} age={46}
          matches={27} wins={19} losses={8}
        />
        <View style={[s.mT7]}>
          <SettingCard title="Member Profile" description="Update member info"
            onPress={() => navigation.navigate('MemberProfile' as never)}
          />
        </View>
        <View style={[s.mT7]}>
          <SettingCard title="Billing Profile" description="Update payment info"
            onPress={() => navigation.navigate('BillingProfile' as never)}
          />
        </View>
        <View style={[s.mT7]}>
          <SettingCard title="Membership Plan" description={plan.name}
            onPress={() => navigation.navigate('MembershipPlan' as never)}
          />
        </View>
      </View>
    </Layouts>
  );
};

export default Profile;
