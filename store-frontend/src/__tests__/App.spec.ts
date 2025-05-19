import { describe, it, expect, vi, beforeEach } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import App from '@/App.vue'
import { useCartStore } from '@/stores/cart'
import NavBar from '@/components/common/NavBar.vue'

vi.mock('@/stores/cart', () => ({
  useCartStore: vi.fn(),
}))

vi.mock('@/components/common/NavBar.vue', () => ({
  default: {
    name: 'NavBar',
    template: '<div class="mock-navbar" />',
  },
}))

describe('App.vue', () => {
  const fetchCart = vi.fn()

  beforeEach(() => {
    fetchCart.mockClear()
    ;(useCartStore as unknown as vi.Mock).mockReturnValue({
      fetchCart,
    })
  })

  it('renders NavBar and calls fetchCart on mount', () => {
    shallowMount(App)

    expect(fetchCart).toHaveBeenCalledOnce()
  })

  it('renders NavBar component', () => {
    const wrapper = shallowMount(App)

    expect(wrapper.findComponent(NavBar).exists()).toBe(true)
  })
})
