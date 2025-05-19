import { describe, it, expect, vi, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useCartStore } from '@/stores/cart'
import { addProductsToCart, fetchCartApi } from '@/api/cart'
import type { Cart } from '@/types/api/Cart'

vi.mock('@/api/cart', () => ({
  addProductsToCart: vi.fn(),
  fetchCartApi: vi.fn(),
}))

const mockCart: Cart = {
  items: [
    { productId: 1, quantity: 2 },
    { productId: 2, quantity: 1 },
  ],
  total_price: 29.97,
  total_quantity: 3,
}

describe('cartStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    vi.clearAllMocks()
    localStorage.clear()
  })

  it('generates and saves cart token if not in localStorage', () => {
    const store = useCartStore()
    const token = store.getOrCreateCartToken()

    expect(token).toBeDefined()
    expect(localStorage.getItem('cart_token')).toBe(token)
  })

  it('uses existing cart token from localStorage', () => {
    localStorage.setItem('cart_token', 'existing-token')
    const store = useCartStore()

    expect(store.cartToken).toBeDefined()
    expect(store.cartToken).toBe('existing-token')
  })

  it('fetchCart updates cart state on success', async () => {
    ;(fetchCartApi as vi.Mock).mockResolvedValue({ data: mockCart })

    const store = useCartStore()
    await store.fetchCart()

    expect(fetchCartApi).toHaveBeenCalledWith(store.cartToken)
    expect(store.cartItems).toEqual(mockCart.items)
    expect(store.totalPrice).toBe(mockCart.total_price)
    expect(store.cartItemCount).toBe(mockCart.total_quantity)
    expect(store.error).toBeNull()
  })

  it('addToCart updates cart state on success', async () => {
    ;(addProductsToCart as vi.Mock).mockResolvedValue({ data: mockCart })

    const store = useCartStore()
    await store.addToCart(1, 2)

    expect(addProductsToCart).toHaveBeenCalledWith(1, 2, store.cartToken)
    expect(store.cartItems).toEqual(mockCart.items)
    expect(store.totalPrice).toBe(mockCart.total_price)
    expect(store.cartItemCount).toBe(mockCart.total_quantity)
    expect(store.error).toBeNull()
  })

  it('handles error in fetchCart', async () => {
    ;(fetchCartApi as vi.Mock).mockRejectedValue(new Error('API fail'))

    const store = useCartStore()
    await store.fetchCart()

    expect(store.error).toBe('API fail')
  })

  it('handles error in addToCart', async () => {
    ;(addProductsToCart as vi.Mock).mockRejectedValue(new Error('Failed'))

    const store = useCartStore()
    await store.addToCart(1)

    expect(store.error).toBe('Failed')
  })
})
