import { defineStore } from 'pinia'
import { ref } from 'vue'
import { addProductsToCart, fetchCartApi } from '@/api/cart'
import type { CartItem, Cart } from '@/types/api/Cart'

export const useCartStore = defineStore('cart', () => {
  const cartItems = ref<CartItem[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)
  const cartItemCount = ref<number>(0)
  const totalPrice = ref(0)
  const cartToken = ref(getOrCreateCartToken())

  function getOrCreateCartToken(): string {
    let token = localStorage.getItem('cart_token')

    if (!token) {
      token = crypto.randomUUID()
      localStorage.setItem('cart_token', token)
    }

    return token
  }

  const fetchCart = async () => {
    try {
      const response = await fetchCartApi(cartToken.value)

      mapCartResponse(response.data)

      error.value = null
    } catch (err: any) {
      error.value = err.message || 'Failed to retrive the cart'
    } finally {
      loading.value = false
    }
  }

  const addToCart = async (productId: number, quantity = 1) => {
    loading.value = true

    try {
      const response = await addProductsToCart(productId, quantity, getOrCreateCartToken())

      mapCartResponse(response.data)

      error.value = null
    } catch (err: any) {
      error.value = err.message || 'Failed to add product to Cart'
    } finally {
      loading.value = false
    }
  }

  const mapCartResponse = (cart: Cart) => {
    cartItems.value = cart.items
    totalPrice.value = cart.total_price
    cartItemCount.value = cart.total_quantity
  }

  return {
    cartItems,
    loading,
    error,
    cartItemCount,
    cartToken,
    totalPrice,
    fetchCart,
    getOrCreateCartToken,
    addToCart,
  }
})
