const Font = {
  GrangeLight: 'Grange-Light',
  GrangeDemiBold: 'Grange-DemiBold',
  GrangeDemiBoldCond: 'Grange-DemiBoldCond',
  GillSansMT: 'GillSansMT',
  GillSansMTBold: 'GillSansMT-Bold',
  OpenSansLight: 'OpenSans-Light',
  OpenSansRegular: 'OpenSans-Regular',
  OpenSansBold: 'OpenSans-Bold',
};

const Color = {
  title: '#1a2755',
  body: '#000000',
  primary: '#0d77bd',
  gray: '#666667',
  border: '#e2e0e2',
  shadow: '#e2e0e2',
  inputBg: '#f3f0f2',
  bodyBg: '#ffffff',
  messageBg: '#e4ff80',
  filterBg: '#faf7f9',
  active: '#0d77bd',
  inactive: '#95a5a6',
  inputIcon: '#6b696a',
  social: '#23a9e1',
};

const FontSize = {
  tiny: 10,
  input: 13,
  screenTitle: 18,
};

const Size = {
  logo: 110,
  headerIcon: 20,
  socialIcon: 30,
  bottomIcon: 28,
  inputIcon: 15,
  cardIcon: 25,
};

const BorderRadius = {
  input: 6,
  circle: 9999,
};

const Theme = {
  font: Font,
  color: Color,
  fontSize: FontSize,
  size: Size,
  borderRadius: BorderRadius,
  inputShadow: {
    borderRadius: BorderRadius.input,
    shadowColor: Color.shadow,
    shadowOffset: {width: 0, height: 1},
    shadowRadius: 6,
    elevation: 2,
  },
};

export default Theme;