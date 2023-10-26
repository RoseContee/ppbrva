import React, { FC, useState } from 'react';
import {
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import SearchInput from '../../components/basic/searchinput';
import Button from '../../components/basic/button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface IProps {
  style?: StyleProp<ViewStyle>,
}

const SearchBar: FC<IProps> = ({ style }): JSX.Element => {
  const [text, setText] = useState<string>();

  return (
    <View style={[t.flexRow, t.itemsCenter, s.pX7, style]}>
      <View style={[t.w3_4, t.pR4]}>
        <SearchInput value={text}
          onChange={e => setText(e.nativeEvent.text)}
        />
      </View>
      <View style={[t.w1_4]}>
        <Button style={[s.bgPrimary, t.pY4]} titleStyle={[t.textSm]}
          onPress={() => {}}
        >
          Sort
        </Button>
      </View>
    </View>
  )
}

export default SearchBar;
