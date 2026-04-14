<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_soft_deleted()
    {
        $category = Category::create(['name' => 'Electronics']);
        $category->delete();

        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
            'name' => 'Electronics'
        ]);

        $this->assertNotNull($category->fresh()->deleted_at);
    }

    public function test_product_can_be_soft_deleted()
    {
        $category = Category::create(['name' => 'Electronics']);
        $product = Product::create([
            'name' => 'Laptop',
            'price' => 1000,
            'category_id' => $category->id
        ]);

        $product->delete();

        $this->assertSoftDeleted('products', [
            'id' => $product->id,
            'name' => 'Laptop'
        ]);

        $this->assertNotNull($product->fresh()->deleted_at);
    }
}
