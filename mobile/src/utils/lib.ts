export const dateFormat = (date: string | number) => {
  const d = new Date(date);
  return `${d.getMonth()}/${d.getDate()}/${d.getFullYear()}`;
};

export const currencyFormat = (value: string | number) => {
  return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
  }).format(Number(value));
};
