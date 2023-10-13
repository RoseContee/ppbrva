import React, { FC } from 'react';
import {
  View
} from 'react-native';
import Layouts from '../../components/layouts/home-layouts';
import Button from '../../components/basic/button';
import Card from '../../components/basic/card';
import Text from '../../components/basic/text';
import Title from '../../components/basic/title';
import IconPDF from '../../assets/img/icons/pdf.svg';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';
import theme from '../../utils/theme';

const ProfileInvoicesDetail: FC = (): JSX.Element => {
  return (
    <Layouts>
      <View style={[t.pX4]}>
        <Card style={[t.p2, t.mT5]}>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, t.pX2, t.pY4]}>
            <View style={[t.flexShrink, t.pR2]}>
              <Title style={[t.textSm, s.textPrimary]}>
                Invoice #123456
              </Title>
              <Text style={[s.textTiny, s.textGray, t.mT1]}>
                12/1/23 - 12/31/23
              </Text>
            </View>
            <IconPDF width={theme.size.cardIcon} height={theme.size.cardIcon} />
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY4]}>
            <Text style={[s.fontBodyLight, s.textTiny, t.pR2]}>
              Food & Beverage
            </Text>
            <Text style={[s.fontBodyLight, s.textTiny]}>
              $45.00
            </Text>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY4]}>
            <Text style={[s.fontBodyLight, s.textTiny, t.pR2]}>
              Court Usage
            </Text>
            <Text style={[s.fontBodyLight, s.textTiny]}>
              $95.00
            </Text>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY4]}>
            <Text style={[s.fontBodyLight, s.textTiny, t.pR2]}>
              Lessons
            </Text>
            <Text style={[s.fontBodyLight, s.textTiny]}>
              $0.00
            </Text>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY4]}>
            <Text style={[s.fontBodyLight, s.textTiny, t.pR2]}>
              Rentals
            </Text>
            <Text style={[s.fontBodyLight, s.textTiny]}>
              $0.00
            </Text>
          </View>
          <View style={[t.flexRow, t.itemsCenter, t.justifyBetween, s.borderT, t.pX2, t.pY4]}>
            <Text style={[s.textTiny, t.textBlack, t.pR2]}>
              TOTAL
            </Text>
            <Text style={[s.textTiny, t.textBlack]}>
              $414.00
            </Text>
          </View>
        </Card>
        <Button style={[s.bgPrimary, t.mT5]}
          onPress={() => {}}
        >
          Download PDF
        </Button>
      </View>
    </Layouts>
  )
}

export default ProfileInvoicesDetail;
