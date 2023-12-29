import React, { FC } from 'react';
import { StackNavigationOptions, createStackNavigator } from '@react-navigation/stack';
import HeaderOptions from '../components/header-options';

import { Invoices, InvoiceDetail } from '../screens/invoices';


export const invoiceRoutes = {
  Invoices: 'Invoices',
  InvoiceDetail: 'InvoiceDetail',
}

const InvoiceScreen: FC = (): JSX.Element => {
  const Stack = createStackNavigator();

  return (
    <Stack.Navigator initialRouteName={invoiceRoutes.Invoices}
      screenOptions={HeaderOptions as StackNavigationOptions}
    >
      <Stack.Screen name={invoiceRoutes.Invoices} component={Invoices}
        options={{title: 'Invoices'}}
      />
      <Stack.Screen name={invoiceRoutes.InvoiceDetail} component={InvoiceDetail}
        options={{title: 'Invoice Detail'}}
      />
    </Stack.Navigator>
  );
}

export default InvoiceScreen;
