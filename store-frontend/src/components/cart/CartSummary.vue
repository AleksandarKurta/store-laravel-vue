<template>
  <div class="container my-4">
    <h2>Your Cart</h2>

    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th></th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in cartStore.cartItems" :key="item.product_id">
          <td>
            <img :src="item.image" class="cart-image object-fit-contain mt-3" alt="Product image" />
          </td>
          <td>{{ item.quantity }}</td>
          <td>${{ formatSubtotal(item.quantity) }}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="2" class="text-end">Total:</th>
          <th>${{ cartStore.totalPrice.toFixed(2) }}</th>
        </tr>
      </tfoot>
    </table>

    <p v-if="cartStore.cartItems.length === 0" class="text-muted">Your cart is empty.</p>
  </div>
</template>

<script setup lang="ts">
import { useCartStore } from '@/stores/cart'

const cartStore = useCartStore()

function formatSubtotal(quantity: number): string {
  const pricePerItem = cartStore.totalPrice / cartStore.cartItemCount
  return (quantity * pricePerItem).toFixed(2)
}
</script>
<style scoped>
.cart-image {
  width: 80px;
  height: 80px;
}
</style>
