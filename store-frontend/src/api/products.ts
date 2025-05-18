import axios from 'axios'
import type { Product } from '@/types/Product'

const baseURL = import.meta.env.VITE_API_BASE_URL

export const fetchProducts = async (): Promise<Product[]> => {
  const response = await axios.get<Product[]>(`${baseURL}/products`)

  return response.data
}
