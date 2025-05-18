// tests/utils/format-price.util.test.ts
import { describe, expect, it } from 'vitest'
import { formatPrice } from '@/utils/format-price.util'

describe('formatPrice', () => {
  it('formats integer price without decimal', () => {
    expect(formatPrice(10)).toBe('10')
  })

  it('formats float price with 2 decimals', () => {
    expect(formatPrice(10.5)).toBe('10.50')
    expect(formatPrice(3.99)).toBe('3.99')
  })

  it('formats float with more than 2 decimals correctly', () => {
    expect(formatPrice(12.3456)).toBe('12.35')
    expect(formatPrice(8.999)).toBe('9.00')
  })

  it('formats 0 correctly', () => {
    expect(formatPrice(0)).toBe('0')
  })
})
