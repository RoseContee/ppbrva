import React, { FC, useState } from 'react';
import {
  FlatList,
  Modal,
  StyleProp,
  TextStyle,
  TouchableOpacity,
  View,
  ViewStyle
} from 'react-native';
import Text from './text';
import Button from './button';
import IconCheck from '../../assets/img/icons/check.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

export interface MenuItem {
  value: string,
  text: string,
}

interface IMenuProps {
  active: boolean,
  item: MenuItem,
  onItemSelect: (value: string) => void
}

const MenuItem: FC<IMenuProps> = ({
  active,
  item,
  onItemSelect,
}): JSX.Element => {
  return (
    <TouchableOpacity style={[t.flexRow, t.itemsCenter, t.pX4, t.pY3]}
      onPress={() => onItemSelect(item.value)}
    >
      {
        active ?
        <IconCheck width={theme.size.inputIcon} height={theme.size.inputIcon} />
        :
        <View style={{width: theme.size.inputIcon, height: theme.size.inputIcon}} />
      }
      <Text style={[t.mL2]}>{ item.text }</Text>
    </TouchableOpacity>
  );
};

interface IProps {
  style?: StyleProp<ViewStyle>,
  textStyle?: StyleProp<TextStyle>,
  buttonText: string,
  active: string,
  items: MenuItem[],
  onPress: (value: string) => void,
}

const DropdownMenu: FC<IProps> = ({
  style,
  textStyle,
  buttonText,
  active,
  items,
  onPress
}): JSX.Element => {
  const [openMenu, setOpenMenu] = useState<boolean>(false);

  const onItemSelect = (value: string) => {
    setOpenMenu(false);
    onPress(value);
  }

  return (
    <>
      <Button style={[s.bgPrimary, t.pY4, style]} titleStyle={[t.textSm, textStyle]}
        onPress={() => setOpenMenu(true)}
      >
        { buttonText }
      </Button>
      <Modal onRequestClose={() => setOpenMenu(false)}
        animationType="none" transparent={true}
        visible={openMenu}
      >
        <TouchableOpacity style={[t.wFull, t.hFull, {backgroundColor: 'rgba(0,0,0,0.4)'}, t.justifyCenter, t.itemsCenter]}
          activeOpacity={1}
          onPress={() => setOpenMenu(false)}
        >
          <View style={[s.card, t.w2_3]}>
            <FlatList
              data={items}
              keyExtractor={item => item.value.toString()}
              renderItem={({item}) => (
                <MenuItem active={active === item.value}
                  item={item}
                  onItemSelect={onItemSelect}
                />
              )}
            />
          </View>
        </TouchableOpacity>
      </Modal>
    </>
  );
};

export default DropdownMenu;
