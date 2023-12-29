import React, { FC } from 'react';
import {
  Modal as BaseModal,
  StyleProp,
  View,
  ViewStyle
} from 'react-native';
import Text from './text';
import Button from './button';

import { t } from 'react-native-tailwindcss';
import s from '../../utils/styles';

interface ModalProps {
  style?: StyleProp<ViewStyle>,
  text: string,
  show?: boolean,
  onClose: () => void,
}

const Modal: FC<ModalProps> = ({
  style,
  text,
  show,
  onClose,
}): JSX.Element => {
  return (
    <BaseModal
      animationType="none"
      transparent={true}
      visible={show}
      onRequestClose={onClose}>
      <View style={[s.modal, s.testBorder]}>
        <View style={[s.loadingOverlay, t.bgBlack]} />
        <View style={s.modalBody}>
          <Text style={[t.textBase]}>{ text }</Text>
          <Button style={[s.bgPrimary, s.btnXs, t.mT4]}
            titleStyle={[t.textXs]}
            onPress={onClose}
          >
            Close
          </Button>
        </View>
      </View>
    </BaseModal>
  )
}

export default Modal;
