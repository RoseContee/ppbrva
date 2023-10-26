import React, { FC } from 'react';
import {
  NativeSyntheticEvent,
  StyleProp,
  TextInput,
  TextInputChangeEventData,
  View,
  ViewStyle
} from 'react-native';
import IconSearch from '../../assets/img/icons/magnifying.svg';

import s from '../../utils/styles';
import theme from '../../utils/theme';

interface IProps {
  value?: string,
  onChange?: (e: NativeSyntheticEvent<TextInputChangeEventData>) => void,
  style?: StyleProp<ViewStyle>,
  inputStyle?: StyleProp<ViewStyle>,
}

const SearchInput: FC<IProps> = ({
  value,
  onChange,
  style,
  inputStyle
}): JSX.Element => {
  return (
    <View style={[s.searchInputContainer, style]}>
      <TextInput inputMode="text" style={[s.searchInput, inputStyle]}
        placeholder="Search..." placeholderTextColor={theme.color.placeholder}
        value={value} onChange={onChange}
      />
      <IconSearch fill={theme.color.inputIcon}
        width={theme.size.inputIcon} height={theme.size.inputIcon}
      />
    </View>
  )
}

export default SearchInput;
