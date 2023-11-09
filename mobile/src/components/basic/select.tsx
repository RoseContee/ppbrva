import React, { FC, useEffect, useRef } from 'react';
import {
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import SelectDropDown from 'react-native-select-dropdown';
import IconDown from '../../assets/img/icons/arrow-down.svg';

import s from '../../utils/styles';
import theme from '../../utils/theme';

interface IItemProps {
  label: string,
  value: string,
}

interface IProps {
  data: IItemProps[],
  value?: IItemProps | null,
  onChange: (value: IItemProps, index: number) => void,
  style?: StyleProp<ViewStyle>,
  placeholder?: string,
}

const Select: FC<IProps> = ({
  data,
  value,
  onChange,
  style,
  placeholder,
}): JSX.Element => {
  const selectRef = useRef<SelectDropDown>(null);

  useEffect(() => {
    if (!value) selectRef.current?.reset();
  }, [value]);

  return (
    <View style={[s.selectContainer, style]}>
      <SelectDropDown
        ref={selectRef}
        buttonStyle={[s.selectButton]}
        buttonTextStyle={[s.selectButtonText]}
        rowStyle={{height: 50}}
        rowTextStyle={[s.selectItemText]}
        renderDropdownIcon={() => (
          <IconDown fill={theme.color.primary}
            width={theme.size.inputIcon} height={theme.size.inputIcon}
          />
        )}
        buttonTextAfterSelection={(item: IItemProps) => item.label}
        rowTextForSelection={(item: IItemProps) => item.label}
        defaultButtonText={placeholder}
        data={data}
        onSelect={onChange}
      />
    </View>
  )
}

export default Select;
