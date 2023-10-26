import React, { FC } from 'react';
import {
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import SelectDropDown from 'react-native-select-dropdown';
import IconDown from '../../assets/img/icons/arrow-down.svg';

import s from '../../utils/styles';
import theme from '../../utils/theme';

export interface SelectItemProps {
  label: string,
  value: string,
}

interface IProps {
  data: SelectItemProps[],
  onChange: (value: SelectItemProps, index: number) => void,
  style?: StyleProp<ViewStyle>,
  placeholder?: string,
}

const Select: FC<IProps> = ({
  data,
  onChange,
  style,
  placeholder,
}): JSX.Element => {
  return (
    <View style={[s.selectContainer, style]}>
      <SelectDropDown
        buttonStyle={[s.selectButton]}
        buttonTextStyle={[s.selectButtonText]}
        rowStyle={{height: 50}}
        rowTextStyle={[s.selectItemText]}
        renderDropdownIcon={() => (
          <IconDown fill={theme.color.primary}
            width={theme.size.inputIcon} height={theme.size.inputIcon}
          />
        )}
        buttonTextAfterSelection={(item: SelectItemProps) => item.label}
        rowTextForSelection={(item: SelectItemProps) => item.label}
        defaultButtonText={placeholder}
        data={data}
        onSelect={onChange}
      />
    </View>
  )
}

export default Select;
