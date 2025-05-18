import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductCard from '@/components/product/ProductCard.vue'
import type { Product } from '@/types/Product'

describe('ProductCard.vue', () => {
  const product: Product = {
    id: 1,
    title: 'Test Product',
    price: '19.99',
    description: 'Test description',
    category: 'Electronics',
    image: 'https://example.com/image.jpg',
  }

  it('renders product title, category, price and image', () => {
    const wrapper = mount(ProductCard, {
      props: {
        product,
      },
    })

    expect(wrapper.text()).toContain(product.title)
    expect(wrapper.text()).toContain(product.category)
    expect(wrapper.text()).toContain('$19.99')

    const img = wrapper.find('img')
    expect(img.exists()).toBe(true)
    expect(img.attributes('src')).toBe(product.image)
    expect(img.attributes('alt')).toBe('Product image')
  })
})
