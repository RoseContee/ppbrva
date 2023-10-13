import React, { FC, ReactNode } from 'react';
import {
  ScrollView
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

import { t } from 'react-native-tailwindcss';

interface IProps {
  children: ReactNode
}

const Layouts: FC<IProps> = ({ children }): JSX.Element => {
  return (
    <SafeAreaView style={[t.bgWhite]}>
      <ScrollView style={[t.hFull]} contentContainerStyle={[t.pB4]}>
        { children }
      </ScrollView>
    </SafeAreaView>
  )
}

export default Layouts;
