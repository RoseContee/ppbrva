const Font = {
  titleLight: 'Grange-Light',
  title: 'Grange-DemiBold',
  titleCond: 'Grange-DemiBoldCond',
  button: 'GillSansMT',
  buttonBold: 'GillSansMT-Bold',
  bodyLight: 'OpenSans-Light',
  body: 'OpenSans-Regular',
  bodyBold: 'OpenSans-Bold',
  bodyCondBold: 'OpenSansSemiCondensed-Bold',
};

const Color = {
  title: '#1a2755',
  body: '#000000',
  primary: '#0d77bd',
  gray: '#666667',
  border: '#e2e0e2',
  shadow: '#555555',
  inputBg: '#f3f0f2',
  placeholder: '#575657',
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
  input: 18,
  screenTitle: 28,
};

const Size = {
  logo: 130,
  headerIcon: 30,
  socialIcon: 50,
  bottomIcon: 40,
  inputIcon: 20,
  settingIcon: 38,
};

const BorderRadius = {
  input: 10,
  circle: 9999,
};

const Theme = {
  font: Font,
  color: Color,
  fontSize: FontSize,
  size: Size,
  borderRadius: BorderRadius,
  inputShadow: {
    shadowColor: Color.shadow,
    shadowOffset: {width: 0, height: 1},
    shadowRadius: BorderRadius.input,
    elevation: 2,
  },
  cardShadow: {
    backgroundColor: Color.bodyBg,
    shadowColor: Color.shadow,
    shadowOffset: {width: 0, height: 1},
    shadowRadius: 0,
    elevation: 1.5,
  },
};

export default Theme;
