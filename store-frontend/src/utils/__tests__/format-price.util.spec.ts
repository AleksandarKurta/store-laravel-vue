import { formatPrice } from '../format-price.util'
import { describe, it, expect } from 'vitest'

describe('formatPrice', () => {
  it('returns price without decimals if price is whole number', () => {
    expect(formatPrice('10')).toBe('10')
    expect(formatPrice('99.00')).toBe('99')
    expect(formatPrice('0')).toBe('0')
  })

  it('returns price with two decimals if price has fraction', () => {
    expect(formatPrice('10.5')).toBe('10.50')
    expect(formatPrice('99.99')).toBe('99.99')
    expect(formatPrice('0.01')).toBe('0.01')
  })

  it('handles invalid numeric strings gracefully', () => {
    expect(formatPrice('abc')).toBe('NaN')
  })

  it('handles empty string', () => {
    expect(formatPrice('')).toBe('NaN')
  })

  it('handles negative numbers correctly', () => {
    expect(formatPrice('-10')).toBe('-10')
    expect(formatPrice('-10.75')).toBe('-10.75')
  })
})
