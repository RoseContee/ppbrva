import React, { FC, useCallback, useState } from 'react';
import {
  BackHandler,
  View
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../../store';
import { getMe } from '../../store/user';
import axios, { getErrorMessage } from '../../utils/axios';
import { getStorage, saveStorage } from '../../utils/storage';
import Layouts from '../../components/layouts';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Message from '../../components/basic/message';
import Title from '../../components/basic/title';
import Button from '../../components/basic/button';
import Select from '../../components/basic/select';
import ProfileImage from '../../components/basic/profile-image';
// import Link from '../../components/basic/link';
// import IconPDF from '../../assets/img/icons/pdf.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IPlanProps {
  id: string,
  name: string,
  price: string,
}

const ProfileMembershipPlan: FC = (): JSX.Element => {
  const navigation = useNavigation();
  const me = useAppSelector(getMe);
  const [loading, setLoading] = useState(false);
  const [message, setMessage] = useState<string>('');
  const [plans, setPlans] = useState<IPlanProps[]>([]);
  const [selectedPlan, setSelectedPlan] = useState<IPlanProps | null>();
  const [canRequest, setCanRequest] = useState(false);

  useFocusEffect(
    useCallback(() => {
      getStorage('plan_requested_at').then(plan_requested_at => {
        const requested_at = Number(plan_requested_at);
        if (!requested_at
          || new Date().getTime() - requested_at > 24 * 60 * 60 * 1000
        ) {
          setLoading(true);
          setCanRequest(true);
          axios.get(`settings/plans`)
          .then(({ data: { plans } }) => {
            setPlans(plans);
          }).catch(error => {
            setMessage(getErrorMessage(error));
          }).finally(() => setLoading(false));
        } else {
          setMessage('You already requested to change your membership plan.');
        }
      });
      const subscribe = BackHandler.addEventListener('hardwareBackPress', () => {
        navigation.navigate('Profile' as never);
        return true;
      });
      return () => {
        setMessage('');
        setSelectedPlan(null);
        setCanRequest(false);
        subscribe.remove();
      }
    }, [])
  );

  const onRequest = () => {
    setLoading(true);
    setMessage('');
    axios.post(`plan-change-request`, {
      plan: selectedPlan?.id,
    }).then(() => {
      setMessage('Your request has been sent successfully.');
      setCanRequest(false);
      saveStorage('plan_requested_at', new Date().getTime());
    }).catch(error => {
      setMessage(getErrorMessage(error));
    }).finally(() => setLoading(false));
  }

  return (
    <Layouts loading={loading}>
      <View style={[s.pX7]}>
        <Card style={[t.pY6, t.mY5]}>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mB2]}>
            <View style={[t.flexShrink, t.pR3]}>
              <Title style={[t.textXl, s.textPrimary]}>
                { me.plan?.name }
              </Title>
              <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.mT1]}>
                Member #{ me.memberID }
              </Text>
            </View>
            <ProfileImage image={me.avatar} style={[s.membershipCardImage]} />
          </View>
          {/* <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT5]}>
            <IconPDF width={35} height={35} />
            <Link style={[t.textBase, t.pL4]}>
              Member Agreement
            </Link>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.pX2, t.mT5]}>
            <IconPDF width={35} height={35} />
            <Link style={[t.textBase, t.pL4]}>
              Another Doc
            </Link>
          </View> */}
        </Card>
        <Title style={[t.textXl, t.mT12]}>Update Plan</Title>
      </View>
      <Message style={[t.mT6]} text={message} />
      {
        !message && canRequest &&
        <View style={[s.pX7]}>
          <Select style={[t.mT5]}
            placeholder="Change plan..."
            data={plans.filter(el => el.id != me.plan?.id).map(plan => ({ label: plan.name, value: plan.id }))}
            value={selectedPlan && {label: selectedPlan.name, value: selectedPlan.id}}
            onChange={value => setSelectedPlan(plans.find(el => el.id === value.value))}
          />
          <Button style={[s.bgPrimary, s.mT7]} disabled={!selectedPlan}
            onPress={onRequest}
          >
            Request
          </Button>
        </View>
      }
    </Layouts>
  );
};

export default ProfileMembershipPlan;
