import { describe, it, expect, vi, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import ProductsList from '@/components/product/ProductsList.vue'
import { useProductsStore } from '@/stores/products'
import ProductCard from '@/components/product/ProductCard.vue'
import type { Product } from '@/types/Product'
import type { Pinia } from 'pinia'

vi.mock('axios')
describe('ProductsList.vue', () => {
  let pinia: Pinia

  beforeEach(() => {
    pinia = createTestingPinia({
      stubActions: false,
      createSpy: vi.fn,
    })
  })

  it('calls loadProducts on mount', () => {
    mount(ProductsList, {
      global: {
        plugins: [pinia],
      },
    })

    const store = useProductsStore()

    expect(store.loadProducts).toHaveBeenCalled()
  })

  it('renders ProductCard components for each product', async () => {
    const mockProducts = [
      { id: 1, title: 'Product 1', price: 10, category: '', image: '', description: '' },
      { id: 2, title: 'Product 2', price: 20, category: '', image: '', description: '' },
    ]

    const wrapper = mount(ProductsList, {
      global: {
        plugins: [pinia],
      },
    })

    const store = useProductsStore()
    store.products = mockProducts as Product[]

    await wrapper.vm.$nextTick()

    const cards = wrapper.findAllComponents(ProductCard)
    expect(cards).toHaveLength(mockProducts.length)
  })
})
