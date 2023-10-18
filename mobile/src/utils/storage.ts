import AsyncStorage from '@react-native-async-storage/async-storage';

export const saveStorage = async (key: string, value: any) => {
  try {
    await AsyncStorage.setItem(key, JSON.stringify(value));
  } catch (e) {}
};

export const getStorage = async (key: string) => {
  try {
    const value = await AsyncStorage.getItem(key);
    return value != null ? JSON.parse(value) : null;
  } catch (e) {
    return null;
  }
};

export const removeStorage = async (key: string) => {
  try {
    await AsyncStorage.removeItem(key)
  } catch(e) {}
};
