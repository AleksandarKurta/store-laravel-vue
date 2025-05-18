import { describe, it, expect, vi } from 'vitest'
import axios from 'axios'
import { addProductsToCart } from '@/api/cart'

// Mock axios
vi.mock('axios')

const mockedAxios = axios as unknown as {
  post: (url: string, body: any) => Promise<{ data: any }>
}

describe.skip('addProductsToCart', () => {
  const productId = 1
  const quantity = 2
  const cartToken = '123e4567-e89b-12d3-a456-426614174000'
  const mockUrl = `${import.meta.env.VITE_API_BASE_URL}/cart/add`

  it('sends POST request and returns response data', async () => {
    const mockResponse = { message: 'Added to cart successfully' }

    mockedAxios.post = vi.fn().mockResolvedValue({
      data: mockResponse,
    })

    const result = await addProductsToCart(productId, quantity, cartToken)

    expect(mockedAxios.post).toHaveBeenCalledOnce()
    expect(mockedAxios.post).toHaveBeenCalledWith(mockUrl, {
      product_id: productId,
      quantity,
      cart_token: cartToken,
    })
    expect(result).toEqual(mockResponse)
  })

  it('throws error if request fails', async () => {
    mockedAxios.post = vi.fn().mockRejectedValue(new Error('Network Error'))

    await expect(() => addProductsToCart(productId, quantity, cartToken)).rejects.toThrow(
      'Network Error',
    )
  })
})
