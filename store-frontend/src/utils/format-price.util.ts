export const formatPrice = (price: string): string => {
  const numeric = parseFloat(price)
  return numeric % 1 === 0 ? numeric.toFixed(0) : numeric.toFixed(2)
}
