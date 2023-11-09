export const dateFormat = (date: string | number) => {
  const d = new Date(date);
  return `${d.getMonth()}/${d.getDate()}/${d.getFullYear()}`;
};