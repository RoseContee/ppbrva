import React, { FC, useCallback, useState } from 'react';
import {
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import { useFocusEffect, useNavigation } from '@react-navigation/native';
import { mainRoutes } from '../../routes';
import { MemberProp, fetchFamilies } from '../../requests';
import Title from './title';
import Button from './button';
import MemberCard from './member-card';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';


interface IProp {
  style?: StyleProp<ViewStyle>,
}

const FamilyMembers: FC<IProp> = ({ style }): JSX.Element => {
  const navigation = useNavigation();
  const [families, setFamilies] = useState<MemberProp[]>([]);
  const [limit, setLimit] = useState(5);

  useFocusEffect(
    useCallback(() => {
      fetchFamilies().then(({ families, limit }) => {
        setFamilies(families);
        setLimit(limit);
      });
    }, [])
  );

  return (
    <View style={style}>
      <View style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
        <Title style={[t.textXl]}>Family Members</Title>
        {
          families.length < limit &&
          <Button style={[s.bgPrimary, s.btnXs]}
            onPress={() => navigation.navigate(mainRoutes.ProfileInviteMember as never)}
          >
            Add
          </Button>
        }
      </View>
      {families.map(family => (
        <View key={family.memberID} style={[t.mT4]}>
          <MemberCard member={family}
            onPress={() => {
              navigation.navigate({
                name: mainRoutes.FamilyMemberProfile,
                params: {
                  memberID: family.memberID,
                },
              } as never)
            }}
          />
        </View>
      ))}
    </View>
  )
}

export default FamilyMembers;
