import { describe, it, expect, vi } from 'vitest'
import axios from 'axios'
import { fetchProducts } from '../products'
import type { Product } from '@/types/Product'

vi.mock('axios')
const mockedAxios = axios as unknown as {
  get: (url: string) => Promise<{
    data: {
      products: Product[]
    }
  }>
}

describe('fetchProducts', () => {
  it('fetches and returns product data', async () => {
    const mockProducts: Product[] = [
      {
        id: 1,
        title: 'Test Product',
        price: 19.99,
        description: 'Test Description',
        category: 'electronics',
        image: 'http://example.com/product.jpg',
      },
    ]

    mockedAxios.get = vi.fn().mockResolvedValue({
      data: {
        products: mockProducts,
      },
    })

    const products = await fetchProducts()

    expect(mockedAxios.get).toHaveBeenCalledOnce()
    expect(products).toEqual(mockProducts)
  })
})
