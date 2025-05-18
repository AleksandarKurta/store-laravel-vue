<template>
  <div class="container py-4">
    <div v-if="products.length" class="row g-4">
      <ProductCard v-for="product in products" :key="product.id" :product="product" />
    </div>
    <div v-else>No products found</div>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import { useProductsStore } from '@/stores/products.ts'
import ProductCard from '@/components/product/ProductCard.vue'
import { storeToRefs } from 'pinia'

const store = useProductsStore()

const { loadProducts } = store
onMounted(() => {
  loadProducts()
})

const { products } = storeToRefs(store)
</script>
