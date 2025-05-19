import { mount } from '@vue/test-utils'
import ProductCard from '@/components/product/ProductCard.vue'
import { useCartStore } from '@/stores/cart'
import { describe, it, expect, vi, beforeEach } from 'vitest'

vi.mock('axios')
vi.mock('@/stores/cart', () => ({
  useCartStore: vi.fn(),
}))

describe('ProductCard.vue', () => {
  let cartStoreMock: ReturnType<typeof useCartStore>

  beforeEach(() => {
    cartStoreMock = {
      addToCart: vi.fn(),
    } as any
    ;(useCartStore as vi.Mock).mockReturnValue(cartStoreMock)
  })

  const product = {
    id: 123,
    title: 'Test Product',
    category: 'Category A',
    description: 'Test description',
    price: 19.99,
    image: 'https://example.com/image.jpg',
  }

  it('renders product info correctly', () => {
    const wrapper = mount(ProductCard, {
      props: { product },
    })

    expect(wrapper.find('h5.card-title').text()).toBe(product.title)
    expect(wrapper.find('p.text-muted').text()).toBe(product.category)
    expect(wrapper.find('p.fw-bold').text()).toBe(`$${product.price.toFixed(2)}`)
    expect(wrapper.find('img').attributes('src')).toBe(product.image)
  })

  it('calls addToCart on button click', async () => {
    const wrapper = mount(ProductCard, {
      props: { product },
    })

    await wrapper.find('button').trigger('click')

    expect(cartStoreMock.addToCart).toHaveBeenCalledWith(product.id)
  })
})
