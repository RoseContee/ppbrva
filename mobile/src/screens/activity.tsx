import React, { FC, useCallback, useState } from 'react';
import {
  FlatList,
  View
} from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import {
  Collapse, CollapseHeader, CollapseBody
} from 'accordion-collapse-react-native';
import { ActivityProp, fetchActivities } from '../requests';
import { currencyFormat } from '../utils/lib';
import Layouts from '../components/layouts';
import PageTitle from '../components/basic/page-title';
import SearchBar from '../components/basic/search-bar';
import Card from '../components/basic/card';
import Text from '../components/basic/text';
import Title from '../components/basic/title';
import Message from '../components/basic/message';
import Image from '../components/basic/profile-image';
import IconDown from '../assets/img/icons/arrow-down.svg';

import { t } from 'react-native-tailwindcss';
import s from '../utils/styles';
import theme from '../utils/theme';

interface IHeaderProps {
  keyword: string,
  onSearch: (keyword: string) => void,
  sort: string,
  onSort: (type: string) => void,
}

const HeaderComponent: FC<IHeaderProps> = ({
  keyword,
  onSearch,
  sort,
  onSort,
}): JSX.Element => {
  return (
    <>
      <PageTitle title="Recent Transactions" />
      <SearchBar style={[t.mY5]}
        keyword={keyword}
        onSearch={onSearch}
        buttonText="Sort"
        items={[
          {value: 'newest', text: 'Newest First'},
          {value: 'oldest', text: 'Oldest First'},
          {value: 'highest', text: 'Highest Total First'},
          {value: 'lowest', text: 'Lowest Total First'},
        ]}
        activeMenu={sort}
        onMenuSelect={onSort}
      />
    </>
  );
}

const ActivityItem: FC<ActivityProp> = (activity): JSX.Element => {
  return (
    <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mY1]}>
      <View style={[t.flexShrink, t.flexRow, t.itemsCenter, t.mR1]}>
        <Text style={[s.fontBodyLight, t.textBase, t.mR2]}>
          { activity.category } - { activity.detail }
        </Text>
        {
          activity.items.length ? (
            <IconDown fill={theme.color.primary}
              width={theme.size.inputIcon} height={theme.size.inputIcon}
            />
          ) : (
            <></>
          )
        }
      </View>
      <Text style={[t.textBase]}>
        { currencyFormat(activity.price) }
      </Text>
    </View>
  );
}

const ItemComponent: FC<ActivityProp> = (activity): JSX.Element => {
  return (
    <View style={[s.pX7, t.mT4]}>
      <Card style={[t.pX4, t.pY3]}>
        <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.mB2]}>
          <Title style={[t.flexShrink, t.textXl, s.textPrimary, t.mR2]}>
            { activity.date }
          </Title>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween]}>
            <Title style={[t.flexShrink, t.textBase, s.textPrimary, t.mR2]}>
              { activity.member.name }
            </Title>
            <Image image={activity.member.avatar}
              style={[s.circle, {width: theme.size.settingIcon, height: theme.size.settingIcon}]}
            />
          </View>
        </View>
        <View style={[s.borderT, t.pY2]}>
          {
            !activity.items.length ? (
              <ActivityItem {...activity} />
            ) : (
              <Collapse>
                <CollapseHeader>
                  <ActivityItem {...activity} />
                </CollapseHeader>
                <CollapseBody style={[t.mT2]}>
                  {activity.items.map((item, index) => {
                    return (
                      <View key={index} style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pL4, t.mT2]}>
                        <Text style={[t.flexShrink, s.fontBodyLight, t.textSm, t.pR2]}>
                          - { item.name }
                        </Text>
                        <Text style={[s.fontBodyLight, t.textSm]}>
                          { currencyFormat(item.price) }
                        </Text>
                      </View>
                    );
                  })}
                </CollapseBody>
              </Collapse>
            )
          }
        </View>
      </Card>
    </View>
  );
}

const Activity: FC = (): JSX.Element => {
  const [loading, setLoading] = useState<boolean>(false);
  const [activities, setActivities] = useState<ActivityProp[]>([]);
  const [keyword, setKeyword] = useState<string>('');
  const [sort, setSort] = useState<string>('newest');

  const filteredActivities = activities.filter(activity => {
    const q = keyword.toLowerCase();
    return activity.date.toLowerCase().includes(q)
      || `${activity.category} - ${activity.detail}`.toLowerCase().includes(q)
      || `${activity.price}`.includes(q);
  });
  filteredActivities.sort((a, b) => {
    if (sort === 'newest') {
      return b.timestamp - a.timestamp;
    } else if (sort === 'oldest') {
      return a.timestamp - b.timestamp;
    } else if (sort === 'highest') {
      return b.price - a.price;
    } else { //lowest
      return a.price - b.price;
    }
  });

  useFocusEffect(
    useCallback(() => {
      setKeyword('');
      setSort('newest');
      if (!activities.length) setLoading(true);
      fetchActivities()
        .then(setActivities)
        .finally(() => setLoading(false));
    }, [])
  );

  const renderListHeader = () => {
    return (
      <HeaderComponent
        keyword={keyword} onSearch={setKeyword}
        sort={sort} onSort={setSort}
      />
    );
  }

  return (
    <Layouts flatlist={true} loading={loading}>
      <FlatList style={[t.hFull]} contentContainerStyle={[t.pB6]}
        data={filteredActivities}
        keyExtractor={(item, index) => index + '-' + item.category}
        ListHeaderComponent={renderListHeader()}
        ListEmptyComponent={() => (
          <Message style={[t.mT10]}
            text={activities.length ? 'Activities not found.' : 'No activity yet...'}
          />
        )}
        renderItem={({ item }) => <ItemComponent {...item} />}
      />
    </Layouts>
  );
}

export default Activity;
