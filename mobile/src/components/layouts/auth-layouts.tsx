import React, { FC, ReactNode } from 'react';
import {
  ImageBackground,
  ScrollView,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

import imgBG from '../../assets/img/auth-bg.png';

import { t } from 'react-native-tailwindcss';

interface IProps {
  children: ReactNode
}

const Layouts: FC<IProps> = ({ children }): JSX.Element => {
  return (
    <ImageBackground source={imgBG} resizeMode="cover" style={[t.bgWhite]}>
      <SafeAreaView>
        <ScrollView style={[t.hFull]} contentContainerStyle={[t.pT2, t.pB4]}>
          { children }
        </ScrollView>
      </SafeAreaView>
    </ImageBackground>
  )
};

export default Layouts;
