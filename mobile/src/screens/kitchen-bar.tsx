import React, { FC, useCallback, useState } from 'react';
import {
  ScrollView,
  SectionList,
  View
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import { KitchenBarData, KitchenBarProp, fetchKitchenBars } from '../requests';
import Layouts from '../components/layouts';
import Button from '../components/basic/button';
import Card from '../components/basic/card';
import Title from '../components/basic/title';
import Message from '../components/basic/message';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';

interface IHeaderProps {
  categories: KitchenBarProp[],
  filteredCategories: string[],
  onFilter: (category: string) => void,
}

const HeaderComponent: FC<IHeaderProps> = ({
  categories,
  filteredCategories,
  onFilter,
}): JSX.Element => {
  return (
    <>
      {/* <PageTitle title="Open daily 11AM - 8PM" /> */}
      <ScrollView horizontal={true} style={[s.pX7, t.pY3]}>
        {categories.map(item => {
          return (
            <Button key={item.category}
              style={[
                s.border, s.borderPrimary, s.btnXs, t.mR2,
                filteredCategories.includes(item.category) ? s.bgPrimary : s.bgFilter,
              ]}
              titleStyle={[
                s.fontButton, t.textSm, t.capitalize,
                filteredCategories.includes(item.category) ? t.textWhite : s.textPrimary
              ]}
              onPress={() => onFilter(item.category)}
            >
              { item.category }
            </Button>
          );
        })}
      </ScrollView>
    </>
  );
}

const ItemComponent: FC<KitchenBarData> = (data): JSX.Element => {
  return (
    <View style={[s.pX7, t.mY3]}>
      <Card style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pY6]}>
        <Title style={[t.flexShrink, t.textXl, s.textPrimary, t.pR3]}>
          { data.item }
        </Title>
        <View style={[t.flexRow]}>
          <Title style={[s.textTiny, s.textBody]}>$</Title>
          <Title style={[t.textSm, s.textBody]}>
            { data.price }
          </Title>
        </View>
      </Card>
    </View>
  );
}

const KitchenBar: FC = (): JSX.Element => {
  const [loading, setLoading] = useState<boolean>(false);
  const [items, setItems] = useState<KitchenBarProp[]>([]);
  const [filteredCategories, setFilteredCategories] = useState<string[]>([]);

  const filteredItems = items.filter(item => {
    return !filteredCategories.length || filteredCategories.includes(item.category);
  });

  useFocusEffect(
    useCallback(() => {
      if (!items.length) setLoading(true);
      fetchKitchenBars()
        .then(setItems)
        .finally(() => setLoading(false));
    }, [])
  );

  const onFilter = (category: string) => {
    if (filteredCategories.includes(category)) {
      setFilteredCategories(filteredCategories.filter(item => item !== category));
    } else {
      setFilteredCategories([
        ...filteredCategories,
        category
      ]);
    }
  }

  const renderListHeader = () => {
    return (
      <HeaderComponent
        categories={items}
        filteredCategories={filteredCategories}
        onFilter={onFilter}
      />
    );
  }

  return (
    <Layouts flatlist={true} loading={loading}>
      <SectionList style={[t.hFull]}
        sections={filteredItems}
        keyExtractor={(item, index) => index + '-' + item.itemID}
        ListHeaderComponent={renderListHeader()}
        ListEmptyComponent={() => (
          <Message style={[t.mT10]}
            text={items.length ? 'Items not found.' : 'No items yet.'}
          />
        )}
        renderSectionHeader={({ section: { category } }) => {
          return (
            <Title style={[t.uppercase, t.textXl, s.pX7, t.mY3]}>
              { category }
            </Title>
          );
        }}
        renderItem={({ item }) => <ItemComponent {...item} />}
      >
      </SectionList>
    </Layouts>
  );
}

export default KitchenBar;
