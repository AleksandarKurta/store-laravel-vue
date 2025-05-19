import { describe, it, expect, vi, beforeEach } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import CartSummary from '@/components/cart/CartSummary.vue' // adjust path
import { useCartStore } from '@/stores/cart'

vi.mock('@/stores/cart', () => ({
  useCartStore: vi.fn(),
}))

describe('CartSummary.vue', () => {
  const mockCartItems = [
    {
      product_id: 1,
      image: 'https://example.com/image.jpg',
      quantity: 2,
    },
    {
      product_id: 2,
      image: 'https://example.com/image2.jpg',
      quantity: 1,
    },
  ]

  beforeEach(() => {
    ;(useCartStore as unknown as vi.Mock).mockReturnValue({
      cartItems: mockCartItems,
      totalPrice: 60,
      cartItemCount: 3,
    })
  })

  it('renders the table with cart items', () => {
    const wrapper = shallowMount(CartSummary)

    const rows = wrapper.findAll('tbody tr')
    expect(rows.length).toBe(mockCartItems.length)

    expect(rows[0].text()).toContain('2')

    expect(rows[0].text()).toContain('$40.00')

    expect(wrapper.text()).toContain('$60.00')
  })

  it('renders product images', () => {
    const wrapper = shallowMount(CartSummary)
    const images = wrapper.findAll('img')
    expect(images.length).toBe(mockCartItems.length)
    expect(images[0].attributes('src')).toBe(mockCartItems[0].image)
  })

  it('shows "cart is empty" if cart is empty', () => {
    ;(useCartStore as unknown as vi.Mock).mockReturnValue({
      cartItems: [],
      totalPrice: 0,
      cartItemCount: 0,
    })

    const wrapper = shallowMount(CartSummary)
    expect(wrapper.text()).toContain('Your cart is empty')
  })
})
