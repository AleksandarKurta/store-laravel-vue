<template>
  <div class="container py-4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/products">Products</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/cart"
                >Cart ({{ cartStore.cartItemCount }})</RouterLink
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>
<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { useCartStore } from '@/stores/cart'

const cartStore = useCartStore()
</script>
