declare module 'accordion-collapse-react-native';
declare module '*.png';
declare module '*.svg' {
  import { SvgProps } from "react-native-svg";
  const content: React.FC<SvgProps>;
  export default content;
};
