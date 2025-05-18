import { setActivePinia, createPinia } from 'pinia'
import { useProductsStore } from '../products'
import { fetchProducts } from '@/api/products'
import { describe, it, expect, vi, beforeEach } from 'vitest'
import type { Product } from '@/types/Product'

vi.mock('@/api/products', () => ({
  fetchProducts: vi.fn(),
}))

describe('useProductsStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('loads products successfully', async () => {
    const mockProducts: Product[] = [
      {
        id: 1,
        title: 'Product 1',
        price: '9.99',
        description: 'Description',
        category: 'Category',
        image: 'img.jpg',
      },
    ]
    const mockedFetch = fetchProducts as unknown as ReturnType<typeof vi.fn>
    mockedFetch.mockResolvedValue(mockProducts)

    const store = useProductsStore()
    await store.loadProducts()

    expect(store.products).toEqual(mockProducts)
    expect(store.loading).toBe(false)
    expect(store.error).toBe(null)
  })

  it('sets error when fetch fails', async () => {
    const errorMessage = 'Network Error'
    const mockedFetch = fetchProducts as unknown as ReturnType<typeof vi.fn>
    mockedFetch.mockRejectedValue(new Error(errorMessage))

    const store = useProductsStore()

    await store.loadProducts()

    expect(store.products).toEqual([])
    expect(store.loading).toBe(false)
    expect(store.error).toBe(errorMessage)
  })
})
