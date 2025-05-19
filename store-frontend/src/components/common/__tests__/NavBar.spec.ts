import { describe, it, expect, vi, beforeEach } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import NavBar from '@/components/common/NavBar.vue'
import { useCartStore } from '@/stores/cart'
import { ref } from 'vue'
import { RouterLink } from 'vue-router'

vi.mock('@/stores/cart', () => ({
  useCartStore: vi.fn(),
}))

describe('Navbar.vue', () => {
  beforeEach(() => {
    ;(useCartStore as vi.Mock).mockReturnValue({
      cartItemCount: ref(5),
    })
  })

  it('has correct RouterLinks', () => {
    const wrapper = shallowMount(NavBar, {
      global: {
        components: { RouterLink },
      },
    })

    const links = wrapper.findAllComponents(RouterLink)
    expect(links[0].props('to')).toBe('/products')
    expect(links[1].props('to')).toBe('/cart')
  })
})
