import { StyleSheet } from 'react-native';
import theme from './theme';

const styles = StyleSheet.create({
  fontTitleLight: {
    fontFamily: theme.font.GrangeLight,
  },
  fontTitle: {
    fontFamily: theme.font.GrangeDemiBold,
  },
  fontTitleCond: {
    fontFamily: theme.font.GrangeDemiBoldCond,
  },
  fontButton: {
    fontFamily: theme.font.GillSansMT,
  },
  fontButtonBold: {
    fontFamily: theme.font.GillSansMTBold,
  },
  fontBodyLight: {
    fontFamily: theme.font.OpenSansLight,
  },
  fontBody: {
    fontFamily: theme.font.OpenSansRegular,
  },
  fontBodyBold: {
    fontFamily: theme.font.OpenSansBold,
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

  /* Input Start */
  input: {
    fontFamily: theme.font.OpenSansRegular,
    fontSize: theme.fontSize.input,
    color: theme.color.body,
    backgroundColor: theme.color.inputBg,
    paddingHorizontal: 10,
    paddingVertical: 5,
    ...theme.inputShadow,
  },
  inputOne: {
    flexShrink: 1,
    maxWidth: 50,
    paddingHorizontal: 5,
    textAlign: 'center',
  },
  /* Input End */

  /* SearchInput Start */
  searchInputContainer: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: theme.color.inputBg,
    paddingLeft: 10,
    paddingRight: 25,
    paddingVertical: 2,
    ...theme.inputShadow,
  },
  searchInput: {
    width: '100%',
    fontFamily: theme.font.OpenSansRegular,
    fontSize: theme.fontSize.input,
    color: theme.color.body,
    padding: 0,
  },
  /* SearchInput End */

  /* Select Start */
  selectContainer: {
    backgroundColor: theme.color.inputBg,
    ...theme.inputShadow,
  },
  selectButton: {
    width: '100%',
    height: 'auto',
    paddingVertical: 9,
    borderRadius: theme.borderRadius.input,
  },
  selectButtonText: {
    fontFamily: theme.font.OpenSansRegular,
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
    padding: 11,
    ...theme.inputShadow,
  },
  btnXs: {
    paddingHorizontal: 8,
    paddingVertical: 4,
  },
  /* Button End */

  /* Message Start */
  message: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: theme.color.messageBg,
  },
  messageText: {
    fontSize: theme.fontSize.tiny,
    color: theme.color.title,
    textAlign: 'center',
  },
  messageBtn: {
    paddingVertical: 5,
    marginVertical: -4,
  },
  /* Message End */

  screenTitle: {
    fontSize: theme.fontSize.screenTitle,
    textTransform: 'capitalize',
  },
  profileCardTitle: {
    fontFamily: theme.font.GrangeDemiBold,
    color: theme.color.title,
    fontSize: 22,
  },
  menuImage: {
    width: 28,
    height: 28,
  },
  profileImage: {
    width: 95,
    height: 95,
    borderRadius: theme.borderRadius.circle,
  },
  cardListImage: {
    width: 40,
    height: 40,
    borderRadius: theme.borderRadius.circle,
  },
  profileCardImage: {
    width: 75,
    height: 75,
    borderRadius: theme.borderRadius.circle,
  },
  dot: {
    width: 6,
    height: 6,
    backgroundColor: theme.color.inactive,
  },

  testBorder: {
    borderColor: 'blue',
    borderWidth: 1,
  }
});

export default styles;
