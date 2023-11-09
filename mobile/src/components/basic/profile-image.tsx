import React, { FC } from 'react';
import {
  Image,
  ImageStyle,
  ImageSourcePropType,
  StyleProp,
} from 'react-native';

import imgProfile from '../../assets/img/user-profile.png';

interface IProps {
  style?: StyleProp<ImageStyle>,
  image?: string | ImageSourcePropType,
}

const ProfileImage: FC<IProps> = ({ style, image }): JSX.Element => {
  return (
    <Image source={image ? (typeof image === 'string' ? {uri: image} : image) : imgProfile}
      style={[style]}
    />
  );
}

export default ProfileImage;
