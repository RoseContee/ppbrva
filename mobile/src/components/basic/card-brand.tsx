import React, { FC } from 'react';
import { View } from 'react-native';
import Image from 'react-native-scalable-image';
import Text from './text';

import IconVisa from '../../assets/img/icons/cards/visa.svg';
import IconMC from '../../assets/img/icons/cards/mc.svg';
import IconAmex from '../../assets/img/icons/cards/amex.svg';
import IconDiscover from '../../assets/img/icons/cards/discover.svg';
import IconDinersClub from '../../assets/img/icons/cards/diners_club.svg';
import IconJCB from '../../assets/img/icons/cards/jcb.svg';
import IconUnknown from '../../assets/img/icons/cards/unknown.png';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IBrandProps {
  brand: string
}

const Brand: FC<IBrandProps> = ({ brand }): JSX.Element => {
  const width = 60, height = 30;

  switch (brand) {
    case 'visa':
      return <IconVisa width={width} height={height} />
    case 'mc':
      return <IconMC width={width} height={height} />
    case 'amex':
      return <IconAmex width={width} height={height} />
    case 'discover':
      return <IconDiscover width={width} height={height} />
    case 'diners_clube':
      return <IconDinersClub width={width} height={height} />
    case 'jcb':
      return <IconJCB width={width} height={height} />
  }
  return <Image source={IconUnknown} height={height} />
}

interface IProps {
  brand: string,
  last4: string,
}

const CardBrand: FC<IProps> = ({ brand, last4 }): JSX.Element => {
  return (
    <View style={[t.flexRow, t.itemsCenter]}>
      <Brand brand={brand} />
      <Text style={[s.textGray, t.textXl, t.pL1]}>**** { last4 }</Text>
    </View>
  )
}

export default CardBrand;
