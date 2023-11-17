import React, { FC } from 'react';
import {
  Image,
  StyleProp,
  TouchableOpacity,
  View,
  ViewStyle
} from 'react-native';
import Card from './card';
import Text from './text';
import Title from './title';
import IconSettings from '../../assets/img/icons/settings.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

interface IProps {
  onPress: () => void,
  title: string,
  description: string,
  image?: string,
  style?: StyleProp<ViewStyle>,
}

const SettingCard: FC<IProps> = ({
  onPress,
  title,
  description,
  image,
  style
}): JSX.Element => {
  return (
    <TouchableOpacity onPress={onPress}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY6, style]}>
        <View style={[t.flexShrink, t.pR3]}>
          <Title style={[t.textXl, s.textPrimary]}>
            { title }
          </Title>
          <Text style={[s.fontBodyLight, t.textBase, s.textGray, t.mT2]}>
            { description }
          </Text>
        </View>
        {
          image ?
          <Image source={{uri: image}} style={[s.cardListImage]} />
          :
          <IconSettings fill={theme.color.primary}
            width={theme.size.settingIcon} height={theme.size.settingIcon}
          />
        }
      </Card>
    </TouchableOpacity>
  )
}

export default SettingCard;
