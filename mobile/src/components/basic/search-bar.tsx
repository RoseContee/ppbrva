import React, { FC } from 'react';
import {
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import SearchInput from './searchinput';
import DropdownMenu, { MenuItem } from './dropdown-menu';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  keyword: string,
  onSearch: (keyword: string) => void,
  buttonText: string,
  items: MenuItem[],
  activeMenu: string,
  onMenuSelect: (menu: string) => void,
  style?: StyleProp<ViewStyle>,
}

const SearchBar: FC<IProps> = ({
  keyword,
  onSearch,
  buttonText,
  items,
  activeMenu,
  onMenuSelect,
  style,
}): JSX.Element => {
  return (
    <View style={[s.pX7, style]}>
      <View style={[t.flexRow, t.itemsCenter]}>
        <View style={[t.w3_4, t.pR4]}>
          <SearchInput value={keyword}
            onChange={onSearch}
          />
        </View>
        <View style={[t.w1_4]}>
          <DropdownMenu buttonText={buttonText}
            active={activeMenu}
            items={items}
            onPress={onMenuSelect}
          />
        </View>
      </View>
    </View>
  );
};

export default SearchBar;
