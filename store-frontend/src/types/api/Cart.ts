export interface CartItem {
  id: number
  product_id: number
  quantity: number
  product: {
    id: number
    title: string
    price: number
    image: string
    category: string
  }
}

export interface Cart {
  id: number
  user_id: number | null
  session_id: string | null
  cart_token: string
  items: CartItem[]
  total_price: number
  total_quantity: number
}

export interface CartItemRequest {
  productId: number
  quantity: number
}
