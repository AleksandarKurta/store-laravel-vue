import axios from 'axios'
import type { Product } from '@/types/Product'
import type { Products } from '@/types/api/Products'

const baseURL = import.meta.env.VITE_API_BASE_URL

export const fetchProducts = async (): Promise<Product[]> => {
  const response = await axios.get<Products>(`${baseURL}/products`)

  return response.data.products
}
