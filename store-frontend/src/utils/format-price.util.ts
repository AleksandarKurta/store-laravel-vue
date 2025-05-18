export const formatPrice = (price: number): string => {
  return Number.isInteger(price) ? price.toFixed(0) : price.toFixed(2)
}
