import { StyleSheet, Dimensions } from 'react-native';
import theme from './theme';

const styles = StyleSheet.create({
  fontTitleLight: {
    fontFamily: theme.font.titleLight,
  },
  fontTitle: {
    fontFamily: theme.font.title,
  },
  fontTitleCond: {
    fontFamily: theme.font.titleCond,
  },
  fontButton: {
    fontFamily: theme.font.button,
  },
  fontButtonBold: {
    fontFamily: theme.font.buttonBold,
  },
  fontBodyLight: {
    fontFamily: theme.font.bodyLight,
  },
  fontBody: {
    fontFamily: theme.font.body,
  },
  fontBodyBold: {
    fontFamily: theme.font.bodyBold,
  },
  fontBodyCondBold: {
    fontFamily: theme.font.bodyCondBold,
  },
  textTitle: {
    color: theme.color.title,
  },
  textBody: {
    color: theme.color.body,
  },
  textPrimary: {
    color: theme.color.primary,
  },
  textGray: {
    color: theme.color.gray,
  },
  textTiny: {
    fontSize: theme.fontSize.tiny,
  },
  bgBody: {
    backgroundColor: theme.color.bodyBg,
  },
  bgPrimary: {
    backgroundColor: theme.color.primary,
  },
  bgFilter: {
    backgroundColor: theme.color.filterBg,
  },
  borderPrimary: {
    borderColor: theme.color.primary,
  },
  border: {
    borderWidth: 1,
    borderColor: theme.color.border,
  },
  borderL: {
    borderLeftWidth: 1,
    borderLeftColor: theme.color.border,
  },
  borderR: {
    borderRightWidth: 1,
    borderRightColor: theme.color.border,
  },
  borderT: {
    borderTopWidth: 1,
    borderTopColor: theme.color.border,
  },
  borderB: {
    borderBottomWidth: 1,
    borderBottomColor: theme.color.border,
  },
  circle: {
    borderRadius: theme.borderRadius.circle,
  },
  p7: {
    padding: 28,
  },
  pX7: {
    paddingHorizontal: 28,
  },
  pY7: {
    paddingVertical: 28,
  },
  pT7: {
    paddingTop: 28,
  },
  pR7: {
    paddingRight: 28,
  },
  pB7: {
    paddingBottom: 28,
  },
  pL7: {
    paddingLeft: 28,
  },
  pS7: {
    paddingStart: 28,
  },
  pE7: {
    paddingEnd: 28,
  },
  m7: {
    margin: 28,
  },
  mX7: {
    marginHorizontal: 28,
  },
  mY7: {
    marginVertical: 28,
  },
  mT7: {
    marginTop: 28,
  },
  mR7: {
    marginRight: 28,
  },
  mB7: {
    marginBottom: 28,
  },
  mL7: {
    marginLeft: 28,
  },
  mS7: {
    marginStart: 28,
  },
  mE7: {
    marginEnd: 28,
  },
  _m7: {
    margin: -28,
  },
  _mX7: {
    marginHorizontal: -28,
  },
  _mY7: {
    marginVertical: -28,
  },
  _mT7: {
    marginTop: -28,
  },
  _mR7: {
    marginRight: -28,
  },
  _mB7: {
    marginBottom: -28,
  },
  _mL7: {
    marginLeft: -28,
  },
  _mS7: {
    marginStart: -28,
  },
  _mE7: {
    marginEnd: -28,
  },

  /* Input Start */
  input: {
    fontFamily: theme.font.body,
    fontSize: theme.fontSize.input,
    color: theme.color.body,
    backgroundColor: theme.color.inputBg,
    paddingHorizontal: 16,
    paddingVertical: 14,
    borderRadius: theme.borderRadius.input,
    ...theme.inputShadow,
  },
  inputOne: {
    flexShrink: 1,
    maxWidth: 50,
    textAlign: 'center',
  },
  /* Input End */

  /* SearchInput Start */
  searchInputContainer: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: theme.color.inputBg,
    paddingLeft: 15,
    paddingRight: 35,
    paddingVertical: 11,
    borderRadius: theme.borderRadius.input,
    ...theme.inputShadow,
  },
  searchInput: {
    width: '100%',
    fontFamily: theme.font.body,
    fontSize: theme.fontSize.input,
    color: theme.color.body,
    padding: 0,
  },
  /* SearchInput End */

  /* Select Start */
  selectContainer: {
    borderRadius: theme.borderRadius.input,
    ...theme.inputShadow,
  },
  selectButton: {
    width: '100%',
    height: 'auto',
    paddingVertical: 16,
    borderRadius: theme.borderRadius.input,
    backgroundColor: theme.color.inputBg,
  },
  selectButtonText: {
    fontFamily: theme.font.body,
    fontSize: theme.fontSize.input,
    color: theme.color.body,
    textAlign: 'left',
  },
  selectItemText: {
    fontSize: theme.fontSize.input,
    textAlign: 'left',
  },
  /* Select End */

  /* Button Start */
  btn: {
    backgroundColor: theme.color.bodyBg,
    alignItems: 'center',
    paddingHorizontal: 16,
    paddingVertical: 17,
    borderRadius: theme.borderRadius.input,
    ...theme.inputShadow,
  },
  btnXs: {
    paddingHorizontal: 15,
    paddingVertical: 8,
  },
  /* Button End */

  card: {
    backgroundColor: theme.color.bodyBg,
    ...theme.cardShadow,
  },

  /* Message Start */
  message: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: theme.color.messageBg,
  },
  messageText: {
    fontSize: 16,
    color: theme.color.title,
    textAlign: 'center',
  },
  messageBtn: {
    paddingVertical: 9,
    marginVertical: -8,
  },
  /* Message End */

  /* Modal Start */
  modal: {
    justifyContent: 'center',
    alignItems: 'center',
    padding: 16,
    height: Dimensions.get('window').height,
  },
  modalBody: {
    backgroundColor: '#fff',
    borderRadius: theme.borderRadius.input,
    padding: 20,
    alignItems: 'center',
    ...theme.cardShadow,
  },
  /* Modal End */

  screenTitle: {
    fontSize: theme.fontSize.screenTitle,
    textTransform: 'capitalize',
  },
  profileCardTitle: {
    fontFamily: theme.font.bodyCondBold,
    color: theme.color.title,
    fontSize: 34,
  },
  menuImage: {
    width: 45,
    height: 45,
  },
  profileImage: {
    width: 140,
    height: 140,
    borderRadius: theme.borderRadius.circle,
  },
  cardListImage: {
    width: 65,
    height: 65,
    borderRadius: theme.borderRadius.circle,
  },
  profileCardImage: {
    width: 110,
    height: 110,
    borderRadius: theme.borderRadius.circle,
  },
  membershipCardImage: {
    width: 65,
    height: 65,
    borderRadius: theme.borderRadius.circle,
  },
  dot: {
    width: 9,
    height: 9,
    backgroundColor: theme.color.inactive,
  },
  loadingContainer: {
    position: 'absolute',
    width: Dimensions.get('window').width,
    height: Dimensions.get('window').height,
    justifyContent: 'center',
    zIndex: 999,
  },
  loadingOverlay: {
    position: 'absolute',
    width: Dimensions.get('window').width,
    height: Dimensions.get('window').height,
    backgroundColor: '#fff',
    opacity: 0.3,
  },

  testBorder: {
    borderColor: 'blue',
    borderWidth: 1,
  }
});

export default styles;
