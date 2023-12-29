import React, { FC, useCallback, useEffect } from 'react';
import {
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { MemberProp, fetchMe, fetchPlan } from '../../requests';
import { useAppSelector } from '../../store';
import { getMe, getPlan } from '../../store/user';
import Layouts from '../../components/layouts';
import PageTitle from '../../components/basic/page-title';
import ProfileCard from '../../components/basic/profile-card';
import SettingCard from '../../components/basic/setting-card';

import s from '../../utils/styles';

const Profile: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const plan = useAppSelector(getPlan);

  useFocusEffect(
    useCallback(() => {
      fetchMe();
      fetchPlan();
    }, [])
  );

  useEffect(() => {
    navigation.setOptions({title: me.name});
  }, [me]);

  const gotoScreen = (screen: string) => {
    navigation.navigate(screen as never);
  }

  return (
    <Layouts>
      <PageTitle title={`Member #${ me.memberID }`} />
      <View style={[s.pX7]}>
        <ProfileCard style={[s.mT7]}
          isMe={true} needInputId={!me.profile?.dupr_id}
          member={me as unknown as MemberProp}
        />
        <View style={[s.mT7]}>
          <SettingCard title="Member Profile" description="Update member info"
            onPress={() => gotoScreen(mainRoutes.MemberProfile)}
          />
        </View>
        <View style={[s.mT7]}>
          <SettingCard title="Billing Profile" description="Update payment info"
            onPress={() => gotoScreen(mainRoutes.BillingProfile)}
          />
        </View>
        <View style={[s.mT7]}>
          <SettingCard title="Membership Plan" description={plan.name}
            onPress={() => gotoScreen(mainRoutes.MembershipPlan)}
          />
        </View>
      </View>
    </Layouts>
  );
}

export default Profile;
