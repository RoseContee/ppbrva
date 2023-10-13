import React, { FC, useState } from 'react';
import {
  ScrollView,
  SectionList,
  View
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Button from '../components/basic/button';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface IFoodProps {
  meal: string,
  description: string,
  price: number,
}

interface ItemProps {
  category: string,
  data: IFoodProps[]
}

const HeaderComponent: FC<{sections: ItemProps[]}> = ({ sections }): JSX.Element => {
  return (
    <View style={[t.pX4]}>
      <Text style={[s.fontBodyLight, s.textTiny, s.textTitle]}>
        Open daily 11AM - 8PM
      </Text>
      <ScrollView horizontal={true} style={[t.pY3]}>
        {sections.map((section) => {
          return (
            <Button key={section.category} style={[s.bgFilter, s.border, s.borderPrimary, s.btnXs, t.mR2]}
              titleStyle={[s.fontButton, s.textTiny, s.textPrimary, t.capitalize]}
              onPress={() => {}}
            >
              { section.category }
            </Button>
          );
        })}
      </ScrollView>
    </View>
  )
}

const ItemComponent: FC<IFoodProps> = (food): JSX.Element => {
  return (
    <View style={[t.pX4, t.mB4]}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
        <View style={[t.flexGrow, t.pR2]}>
          <Title style={[t.textXs, s.textPrimary]}>
            { food.meal }
          </Title>
          <Text style={[s.fontBodyLight, s.textTiny, s.textGray, t.mT1]}>
            { food.description }
          </Text>
        </View>
        <View style={[t.flexRow]}>
          <Title style={[s.textTiny, s.textBody]}>$</Title>
          <Title style={[t.textSm, s.textBody]}>
            { food.price }
          </Title>
        </View>
      </Card>
    </View>
  );
};

const KitchenBar: FC = (): JSX.Element => {
  const [foods, setFoods] = useState<ItemProps[]>([{
    category: 'Appetizers',
    data: [{
      meal: 'Nachos',
      description: 'Stacked, loaded & delicious',
      price: 10,      
    }, {
      meal: 'Loaded Fries',
      description: 'Meat, cheese, and chili',
      price: 8,
    }, {
      meal: 'Spring Rolls',
      description: 'Choice of chicken or pork',
      price: 12
    }]
  }, {
    category: 'Entrees',
    data: [{
      meal: 'Chicken Parmesan',
      description: 'Choice of pasta & side salad',
      price: 24,
    }]
  }]);

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <SectionList style={[t.hFull]}
        sections={foods}
        keyExtractor={(item, index) => item.meal + index}
        ListHeaderComponent={() => <HeaderComponent sections={foods} />}
        renderSectionHeader={({ section: { category } }) => {
          return (
            <Title style={[t.uppercase, t.textSm, t.pX4, t.mT2, t.mB3]}>
              { category }
            </Title>
          );
        }}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </SectionList>
    </SafeAreaView>
  )
}

export default KitchenBar;
