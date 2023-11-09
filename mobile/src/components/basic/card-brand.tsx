import React, { FC } from 'react';
import Image from 'react-native-scalable-image';
import IconVisa from '../../assets/img/icons/cards/visa.svg';
import IconMC from '../../assets/img/icons/cards/mc.svg';
import IconAmex from '../../assets/img/icons/cards/amex.svg';
import IconDiscover from '../../assets/img/icons/cards/discover.svg';
import IconDinersClub from '../../assets/img/icons/cards/diners_club.svg';
import IconJCB from '../../assets/img/icons/cards/jcb.svg';
import IconUnknown from '../../assets/img/icons/cards/unknown.png';

interface IProps {
    brand: string;
}

const CardBrand: FC<IProps> = ({ brand }): JSX.Element => {
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
};

export default CardBrand;
