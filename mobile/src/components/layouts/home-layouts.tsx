import React, { FC, ReactNode } from 'react';
import {
  ScrollView
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Loading from '../basic/loading';

import { t } from 'react-native-tailwindcss';

interface IProps {
  loading?: boolean,
  children: ReactNode
}

const Layouts: FC<IProps> = ({ loading, children }): JSX.Element => {
  return (
    <>
      <Loading show={loading} />
      <SafeAreaView style={[t.bgWhite]}>
        <ScrollView style={[t.hFull]} contentContainerStyle={[t.pB4]}>
          { children }
        </ScrollView>
      </SafeAreaView>
    </>
  )
}

export default Layouts;
