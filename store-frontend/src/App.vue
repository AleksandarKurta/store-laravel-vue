<template>
  <NavBar />

  <RouterView />
</template>
<script setup lang="ts">
import { RouterView } from 'vue-router'
import { onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'
import NavBar from './components/common/NavBar.vue'
const cartStore = useCartStore()

onMounted(() => {
  cartStore.fetchCart()
})
</script>
