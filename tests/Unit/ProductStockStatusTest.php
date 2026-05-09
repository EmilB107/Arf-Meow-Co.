<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductStockStatusTest extends TestCase
{
    private function productWithQuantity(int $quantity): Product
    {
        $product = new Product();
        $product->quantity = $quantity;
        return $product;
    }

    public function test_above_10_is_in_stock(): void
    {
        $this->assertEquals('In Stock', $this->productWithQuantity(11)->calculateStockStatus());
        $this->assertEquals('In Stock', $this->productWithQuantity(100)->calculateStockStatus());
    }

    public function test_between_1_and_10_inclusive_is_low_stock(): void
    {
        $this->assertEquals('Low Stock', $this->productWithQuantity(1)->calculateStockStatus());
        $this->assertEquals('Low Stock', $this->productWithQuantity(10)->calculateStockStatus());
    }

    public function test_zero_is_out_of_stock(): void
    {
        $this->assertEquals('Out of Stock', $this->productWithQuantity(0)->calculateStockStatus());
    }

    public function test_boundary_at_10_is_low_stock_not_in_stock(): void
    {
        $this->assertEquals('Low Stock', $this->productWithQuantity(10)->calculateStockStatus());
    }

    public function test_boundary_at_11_is_in_stock_not_low_stock(): void
    {
        $this->assertEquals('In Stock', $this->productWithQuantity(11)->calculateStockStatus());
    }
}
