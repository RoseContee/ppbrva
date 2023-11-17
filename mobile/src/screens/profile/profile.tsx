import React, { FC, useEffect } from 'react';
import {
  View
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import Layouts from '../../components/layouts';
import PageTitle from '../../components/basic/page-title';
import ProfileCard from '../../components/basic/profile-card';
import SettingCard from '../../components/basic/setting-card';

import s from '../../utils/styles';

const Profile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);

  useEffect(() => {
    navigation.setOptions({title: (me || {}).name});
  }, [me]);

  return (
    <Layouts>
      <PageTitle title={`Member #${ me.memberID }`} />
      <View style={[s.pX7]}>
        <ProfileCard style={[s.mT7]}
          isMe={true} needInputId={!me.profile?.dupr_id}
          member={me}
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
          <SettingCard title="Membership Plan" description={me.plan?.name}
            onPress={() => navigation.navigate('MembershipPlan' as never)}
          />
        </View>
      </View>
    </Layouts>
  );
};

export default Profile;
