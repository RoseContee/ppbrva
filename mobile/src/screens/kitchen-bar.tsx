import React, { FC, useState } from 'react';
import {
  SafeAreaView,
  ScrollView,
  SectionList,
  View
} from 'react-native';
import PageTitle from '../components/basic/page-title';
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
    <>
      <PageTitle title="Open daily 11AM - 8PM" />
      <ScrollView horizontal={true} style={[s.pX7, t.pY3]}>
        {sections.map((section) => {
          return (
            <Button key={section.category} style={[s.bgFilter, s.border, s.borderPrimary, s.btnXs, t.mR2]}
              titleStyle={[s.fontButton, t.textSm, s.textPrimary, t.capitalize]}
              onPress={() => {}}
            >
              { section.category }
            </Button>
          );
        })}
      </ScrollView>
    </>
  );
};

const ItemComponent: FC<IFoodProps> = (food): JSX.Element => {
  return (
    <View style={[s.pX7, t.mY3]}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY6]}>
        <View style={[t.flexGrow, t.pR3]}>
          <Title style={[t.textXl, s.textPrimary]}>
            { food.meal }
          </Title>
          <Text style={[s.fontBodyLight, t.textSm, s.textGray, t.mT2]}>
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
            <Title style={[t.uppercase, t.textXl, s.pX7, t.mY3]}>
              { category }
            </Title>
          );
        }}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </SectionList>
    </SafeAreaView>
  );
};

export default KitchenBar;
