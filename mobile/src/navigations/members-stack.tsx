import React, { FC } from 'react';
import { createStackNavigator } from '@react-navigation/stack';
import Header from '../components/layouts/header';

import Members from '../screens/members';
import MembersInvite from '../screens/members/invite';
import MembersRequest from '../screens/members/request';
import MembersAccepted from '../screens/members/accepted';

const Stack = createStackNavigator();
const MembersStack: FC = (): JSX.Element => {
  return (
    <Stack.Navigator initialRouteName="Members" screenOptions={{header: Header}}>
      <Stack.Screen name="Members" component={Members} options={{title: 'Members'}} />
      <Stack.Screen name="MembersInvite" component={MembersInvite} options={{title: 'Sally Dinks'}} />
      <Stack.Screen name="MembersRequest" component={MembersRequest} options={{title: 'Friend Request'}} />
      <Stack.Screen name="MembersAccepted" component={MembersAccepted} options={{title: 'Sally Dinks'}} />
    </Stack.Navigator>
  );
};

export default MembersStack;
