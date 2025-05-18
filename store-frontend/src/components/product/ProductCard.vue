<template>
  <div class="col-md-4">
    <div class="card h-100 shadow-sm">
      <img
        :src="product.image"
        class="card-img-top object-fit-contain mt-3"
        alt="Product image"
        style="height: 200px"
      />
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ product.title }}</h5>
        <p class="text-muted mb-1">{{ product.category }}</p>
        <p class="fw-bold">${{ formatPrice(product.price) }}</p>
        <button type="button" class="btn btn-primary" @click="handleAddToCart(product.id)">
          Add to Cart
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import type { Product } from '@/types/Product'
import { formatPrice } from '@/utils/format-price.util.ts'
import { useCartStore } from '@/stores/cart'
const cartStore = useCartStore()

function handleAddToCart(productId: number) {
  cartStore.addToCart(productId)
}

defineProps<{ product: Product }>()
</script>
<style scopet>
.card-title {
  height: 80px;
}
</style>
