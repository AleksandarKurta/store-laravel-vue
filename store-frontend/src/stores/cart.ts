import { defineStore } from 'pinia'
import { ref } from 'vue'
import { addProductsToCart } from '@/api/cart'
import type { CartItem } from '@/types/CartItem'

export const useCartStore = defineStore('cart', () => {
  const cartItems = ref<CartItem[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  function getOrCreateCartToken(): string {
    let token = localStorage.getItem('cart_token')

    if (!token) {
      token = crypto.randomUUID()
      localStorage.setItem('cart_token', token)
    }

    return token
  }

  const addToCart = async (productId: number, quantity = 1) => {
    loading.value = true

    const index = cartItems.value.findIndex((item) => item.productId === productId)

    if (index >= 0) {
      cartItems.value[index].quantity += quantity
    } else {
      cartItems.value.push({ productId, quantity })
    }

    try {
      await addProductsToCart(productId, quantity, getOrCreateCartToken())
      error.value = null
    } catch (err: any) {
      error.value = err.message || 'Failed to add product to Cart'
    } finally {
      loading.value = false
    }
  }

  return {
    cartItems,
    loading,
    error,
    getOrCreateCartToken,
    addToCart,
  }
})
