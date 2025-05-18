import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { Product } from '@/types/Product'
import { fetchProducts } from '@/api/products'

export const useProductsStore = defineStore('products', () => {
  const products = ref<Product[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const loadProducts = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await fetchProducts()
      products.value = response
    } catch (err: any) {
      error.value = err.message || 'Failed to load products'
    } finally {
      loading.value = false
    }
  }

  return {
    products,
    loading,
    error,
    loadProducts,
  }
})
