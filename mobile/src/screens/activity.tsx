import React, { FC, useState } from 'react';
import {
  FlatList,
  View
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Collapse, CollapseHeader, CollapseBody } from 'accordion-collapse-react-native';
import SearchInput from '../components/basic/searchinput';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';
import Button from '../components/basic/button';
import IconDown from '../assets/img/icons/arrow-down.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

interface IHeaderProps {
  keyword: string,
  onSort: () => void,
}

const HeaderComponent: FC<IHeaderProps> = ({ keyword, onSort }): JSX.Element => {
  const [text, setText] = useState<string>(keyword);

  return (
    <>
      <Text style={[t.textXs, s.textTitle, t.pX4]}>
        Recent Transactions
      </Text>
      <View style={[t.flexRow, t.itemsCenter, t.pX4, t.mT3, t.mB4]}>
        <View style={[t.w3_4, t.pR3]}>
          <SearchInput value={text}
            onChange={e => setText(e.nativeEvent.text)}
          />
        </View>
        <View style={[t.w1_4]}>
          <Button style={[s.bgPrimary, {paddingVertical: 9}]} titleStyle={[s.textTiny]}
            onPress={onSort}
          >
            Sort
          </Button>
        </View>
      </View>
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
    <View style={[t.pX4, t.mB4]}>
      <Card style={[t.pX2, t.pY1]}>
        <Title style={[s.textPrimary, t.textSm, t.mY2]}>
          { activity.date }
        </Title>
        {activity.activities.map((activity) => {
          const ActivityItem: FC = () => {
            return (
              <View style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
                <View style={[t.flexShrink]}>
                  <View style={[t.flexRow, t.itemsCenter]}>
                    <Text style={[s.fontBodyLight, t.textXs, t.mR3]}>
                      { activity.type }
                    </Text>
                    {
                      activity.items?.length &&
                      <IconDown fill={theme.color.primary}
                        width={theme.size.inputIcon} height={theme.size.inputIcon}
                      />
                    }
                  </View>
                  <Text style={[s.fontBodyLight, s.textTiny]}>
                    #{ activity.invoice }
                  </Text>
                </View>
                <Text style={[t.textXs]}>
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
                          <View key={index} style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pL4, t.mT1]}>
                            <Text style={[s.fontBodyLight, s.textTiny, t.pR2]}>
                              -{ item.type }
                            </Text>
                            <Text style={[s.fontBodyLight, s.textTiny]}>
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
  const [keyword, setKeyword] = useState<string>('');
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
      <FlatList style={[t.hFull]}
        data={activities}
        keyExtractor={item => item.id}
        ListHeaderComponent={() => <HeaderComponent keyword={keyword} onSort={() => {}} />}
        renderItem={({item}) => <ItemComponent {...item} />}
      >
      </FlatList>
    </SafeAreaView>
  )
}

export default Activity;
