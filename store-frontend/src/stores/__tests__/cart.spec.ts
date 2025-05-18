import { setActivePinia, createPinia } from 'pinia'
import { useCartStore } from '@/stores/cart'
import { vi, describe, it, expect, beforeEach } from 'vitest'
import { addProductsToCart } from '@/api/cart'

vi.mock('@/api/cart', () => ({
  addProductsToCart: vi.fn(),
}))

describe('Cart Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
    vi.resetAllMocks()
  })

  it('generates a cart token if not exists', () => {
    const store = useCartStore()
    const token = store.getOrCreateCartToken()
    const storedToken = localStorage.getItem('cart_token')

    expect(token).toBeDefined()
    expect(token).toBe(storedToken)
  })

  it('uses existing cart token if already present', () => {
    const fakeToken = 'test-token'
    localStorage.setItem('cart_token', fakeToken)

    const store = useCartStore()
    const token = store.getOrCreateCartToken()

    expect(token).toBe(fakeToken)
  })

  it('adds new product to cartItems and calls API', async () => {
    const store = useCartStore()
    const productId = 1
    const quantity = 2

    await store.addToCart(productId, quantity)

    expect(store.cartItems.length).toBe(1)
    expect(store.cartItems[0]).toEqual({ productId, quantity })
    expect(addProductsToCart).toHaveBeenCalledWith(productId, quantity, expect.any(String))
    expect(store.error).toBeNull()
  })

  it('increments quantity if product already in cart', async () => {
    const store = useCartStore()
    const productId = 1

    await store.addToCart(productId, 1)
    await store.addToCart(productId, 2)

    expect(store.cartItems.length).toBe(1)
    expect(store.cartItems[0].quantity).toBe(3)
  })

  it('sets error if API fails', async () => {
    const store = useCartStore()

    vi.mocked(addProductsToCart).mockRejectedValue(new Error('API error'))

    await store.addToCart(1, 1)

    expect(store.error).toBe('API error')
  })
})
