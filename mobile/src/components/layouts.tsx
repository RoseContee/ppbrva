import React, { FC, ReactNode, useEffect } from 'react';
import {
  ImageBackground,
  KeyboardAvoidingView,
  Platform,
  SafeAreaView,
  ScrollView
} from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { useAppSelector } from '../store';
import { getLoggedIn } from '../store/settings';
import { removeStorage } from '../utils/storage';
import { appRoutes } from '../routes';
import { logout } from '../requests';
import Loading from './basic/loading';

import imgBG from '../assets/img/auth-bg.png';

import { t } from 'react-native-tailwindcss';

interface BackgroundProps {
  auth?: boolean,
  children: ReactNode,
}

const Background: FC<BackgroundProps> = ({
  auth,
  children
}): ReactNode => {
  if (auth) {
    return (
      <ImageBackground source={imgBG} resizeMode="cover" style={[t.bgWhite]}>
        { children }
      </ImageBackground>
    );
  }
  return children;
}

interface IProps {
  auth?: boolean,
  flatlist?: boolean,
  loading?: boolean,
  children: ReactNode
}

const Layouts: FC<IProps> = ({
  auth,
  flatlist,
  loading,
  children
}): JSX.Element => {
  const navigation = useNavigation();
  const loggedIn = useAppSelector(getLoggedIn);

  useEffect(() => {
    if (!loggedIn) {
      navigation.navigate(appRoutes.AuthScreen as never);
      logout();
      removeStorage('access_token');
    }
  }, [loggedIn]);

  return (
    <>
      <Loading show={loading} />
      <Background auth={auth}>
        <SafeAreaView style={[!auth && t.bgWhite]}>
          {flatlist ? (
            <>{ children }</>
          ) : (
            <ScrollView style={[t.hFull]} contentContainerStyle={[auth && t.pT8, t.pB4]}
              automaticallyAdjustKeyboardInsets={true}
            >
              <KeyboardAvoidingView behavior={Platform.OS === 'ios' ? 'padding' : undefined}>
                { children }
              </KeyboardAvoidingView>
            </ScrollView>
          )}
        </SafeAreaView>
      </Background>
    </>
  );
}

export default Layouts;
