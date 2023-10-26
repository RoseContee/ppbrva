import React, { FC } from 'react';
import {
  Image,
  ImageStyle,
  StyleProp,
} from 'react-native';

import imgProfile from '../../assets/img/user-profile.png';

interface IProps {
  style?: StyleProp<ImageStyle>,
  image?: string,
}

const ProfileImage: FC<IProps> = ({ style, image }): JSX.Element => {
  return (
    <Image source={image ? {uri: image} : imgProfile} style={[style]} />
  );
}

export default ProfileImage;
