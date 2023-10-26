import React, { FC, useState } from 'react';
import {
  FlatList,
  SafeAreaView,
  View
} from 'react-native';
import { Collapse, CollapseHeader, CollapseBody } from 'accordion-collapse-react-native';
import PageTitle from '../components/basic/page-title';
import SearchBar from '../components/basic/search-bar';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';
import IconDown from '../assets/img/icons/arrow-down.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

interface IHeaderProps {
}

const HeaderComponent: FC<IHeaderProps> = ({}): JSX.Element => {
  return (
    <>
      <PageTitle title="Recent Transactions" />
      <SearchBar style={[t.mY5]} />
    </>
  );
};

interface ItemProps {
  id: string,
  date: string,
  activities: {
    type: string,
    invoice: string,
    amount: string,
    items?: {
      type: string,
      amount: string,
    }[]
  }[]
}

const ItemComponent: FC<ItemProps> = (activity): JSX.Element => {
  return (
    <View style={[s.pX7, t.mT4]}>
      <Card style={[t.pX4, t.pY3]}>
        <Title style={[t.textXl, s.textPrimary, t.mY2]}>
          { activity.date }
        </Title>
        {activity.activities.map((activity) => {
          const ActivityItem: FC = () => {
            return (
              <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mY1]}>
                <View style={[t.flexShrink]}>
                  <View style={[t.flexRow, t.itemsCenter]}>
                    <Text style={[s.fontBodyLight, t.textBase, t.mR3]}>
                      { activity.type }
                    </Text>
                    {
                      activity.items?.length &&
                      <IconDown fill={theme.color.primary}
                        width={theme.size.inputIcon} height={theme.size.inputIcon}
                      />
                    }
                  </View>
                  <Text style={[s.fontBodyLight, t.textSm]}>
                    #{ activity.invoice }
                  </Text>
                </View>
                <Text style={[t.textBase]}>
                  { activity.amount }
                </Text>
              </View>
            );
          };

          return (
            <View key={activity.invoice} style={[s.borderT, t.pY2]}>
              {
                !activity.items?.length ? (
                  <ActivityItem />
                ) : (
                  <Collapse>
                    <CollapseHeader>
                      <ActivityItem />
                    </CollapseHeader>
                    <CollapseBody style={[t.mT2]}>
                      {activity.items.map((item, index) => {
                        return (
                          <View key={index} style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pL4, t.mT2]}>
                            <Text style={[s.fontBodyLight, t.textSm, t.pR2]}>
                              -{ item.type }
                            </Text>
                            <Text style={[s.fontBodyLight, t.textSm]}>
                              { item.amount }
                            </Text>
                          </View>
                        );
                      })}
                    </CollapseBody>
                  </Collapse>
                )
              }
            </View>
          );
        })}
      </Card>
    </View>
  );
};

const Activity: FC = (): JSX.Element => {
  const [activities, setActivities] = useState<ItemProps[]>([{
    id: '1',
    date: '8/22/23',
    activities: [{
      type: 'Court Reservation',
      invoice: '123456',
      amount: '$20.00',
    }, {
      type: 'Lesson: 1 hour',
      invoice: '123476',
      amount: '$75.00',
    }],
  }, {
    id: '2',
    date: '8/20/23',
    activities: [{
      type: 'Food & Beverage',
      invoice: '1234568',
      amount: '$45.00',
      items: [{
        type: 'Guinness Draught Can',
        amount: '$6.00',
      }, {
        type: 'Turkey Club Sandwich',
        amount: '$17.00',
      }, {
        type: 'Don julio tequila',
        amount: '$13.00',
      }, {
        type: 'Additional Tip',
        amount: '$10.00',
      }],
    }],
  }, {
    id: '3',
    date: '8/17/23',
    activities: [{
      type: 'Court Reservation',
      invoice: '1234569',
      amount: '$20.00',
    }, {
      type: 'Lesson: 1 hour',
      invoice: '1234760',
      amount: '$75.00',
    }],
  }]);

  return (
    <SafeAreaView style={[t.bgWhite]}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={activities}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  );
};

export default Activity;
