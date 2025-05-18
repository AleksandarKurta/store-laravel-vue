import axios from 'axios'

const baseURL = import.meta.env.VITE_API_BASE_URL

export const addProductsToCart = async (productId: number, quantity: number, cartToken: string) => {
  const response = await axios.post(`${baseURL}/cart/add`, {
    product_id: productId,
    quantity: quantity,
    cart_token: cartToken,
  })

  return response.data
}
