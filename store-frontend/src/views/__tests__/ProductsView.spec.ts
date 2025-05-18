import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductsView from '@/views/ProductsView.vue'
import ProductsList from '@/components/product/ProductsList.vue'

describe('ProductsView.vue', () => {
  it('renders the heading and includes ProductsList component', () => {
    const wrapper = mount(ProductsView, {
      global: {
        stubs: {
          ProductsList: true,
        },
      },
    })

    expect(wrapper.text()).toContain('Our Products')

    expect(wrapper.findComponent(ProductsList).exists()).toBe(true)
  })
})
