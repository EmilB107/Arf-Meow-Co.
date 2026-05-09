<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;
    private SubCategory $subCategory;
    private User $user;
    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $role               = Role::create(['name' => 'Admin']);
        $superAdminRole     = Role::create(['name' => 'Super Admin']);
        $this->user         = User::factory()->create(['role_id' => $role->id]);
        $this->superAdmin   = User::factory()->create(['role_id' => $superAdminRole->id]);
        $this->category     = Category::create(['name' => 'Test Category']);
        $this->subCategory  = SubCategory::create([
            'name'        => 'Test SubCategory',
            'category_id' => $this->category->id,
        ]);
    }

    private function makeProduct(array $overrides = []): Product
    {
        return Product::create(array_merge([
            'name'            => 'Test Product',
            'sku'             => 'TEST-001',
            'description'     => 'A test product.',
            'price'           => 99.99,
            'quantity'        => 50,
            'category_id'     => $this->category->id,
            'sub_category_id' => $this->subCategory->id,
        ], $overrides));
    }

    // --- Index ---

    public function test_products_index_loads(): void
    {
        $this->actingAs($this->user)
             ->get('/products')
             ->assertStatus(200);
    }

    public function test_products_index_lists_existing_products(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->get('/products')
             ->assertSee($product->name);
    }

    // --- Show ---

    public function test_show_displays_product(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->get("/products/{$product->id}")
             ->assertStatus(200)
             ->assertSee($product->name);
    }

    // --- Create form ---

    public function test_create_form_loads(): void
    {
        $this->actingAs($this->user)
             ->get('/products/create')
             ->assertStatus(200);
    }

    // --- Store ---

    public function test_store_creates_product_in_database(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => 'New Dog Treat',
                 'sku'          => 'NDT-001',
                 'description'  => 'Tasty treats.',
                 'category'     => 'Dog Supplies',
                 'subcategory'  => 'Treats',
                 'price'        => 12.99,
                 'quantity'     => 100,
             ]);

        $this->assertDatabaseHas('products', ['name' => 'New Dog Treat', 'sku' => 'NDT-001']);
    }

    public function test_store_redirects_to_products_index(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => 'New Dog Treat',
                 'category'     => 'Dog Supplies',
                 'price'        => 12.99,
             ])->assertRedirect('/products');
    }

    public function test_store_requires_product_name(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => '',
                 'category'     => 'Dog Supplies',
                 'price'        => 12.99,
             ])->assertSessionHasErrors('product_name');
    }

    public function test_store_requires_category(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => 'Some Product',
                 'category'     => '',
                 'price'        => 12.99,
             ])->assertSessionHasErrors('category');
    }

    public function test_store_requires_price(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => 'Some Product',
                 'category'     => 'Dog Supplies',
                 'price'        => '',
             ])->assertSessionHasErrors('price');
    }

    public function test_store_rejects_negative_price(): void
    {
        $this->actingAs($this->user)
             ->post('/products', [
                 'product_name' => 'Some Product',
                 'category'     => 'Dog Supplies',
                 'price'        => -5,
             ])->assertSessionHasErrors('price');
    }

    // --- Edit form ---

    public function test_edit_form_loads(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->get("/products/{$product->id}/edit")
             ->assertStatus(200);
    }

    // --- Update ---

    public function test_update_modifies_product_in_database(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->put("/products/{$product->id}", [
                 'product_name' => 'Updated Name',
                 'price'        => 149.99,
                 'quantity'     => 25,
                 'category_id'  => $this->category->id,
             ]);

        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'name'  => 'Updated Name',
            'price' => 149.99,
        ]);
    }

    public function test_update_redirects_to_products_index(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->put("/products/{$product->id}", [
                 'product_name' => 'Updated Name',
                 'price'        => 149.99,
                 'category_id'  => $this->category->id,
             ])->assertRedirect('/products');
    }

    public function test_update_requires_product_name(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->put("/products/{$product->id}", [
                 'product_name' => '',
                 'price'        => 99.99,
             ])->assertSessionHasErrors('product_name');
    }

    // --- Destroy ---

    public function test_destroy_removes_product_from_database(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->delete("/products/{$product->id}");

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_destroy_redirects_to_products_index(): void
    {
        $product = $this->makeProduct();

        $this->actingAs($this->user)
             ->delete("/products/{$product->id}")
             ->assertRedirect('/products');
    }

    public function test_project_manager_cannot_delete_product(): void
    {
        $pmRole  = Role::create(['name' => 'Project Manager']);
        $pm      = User::factory()->create(['role_id' => $pmRole->id]);
        $product = $this->makeProduct();

        $this->actingAs($pm)
             ->delete("/products/{$product->id}")
             ->assertStatus(403);

        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    // --- Stock status auto-calculation ---

    public function test_product_is_in_stock_when_quantity_above_10(): void
    {
        $product = $this->makeProduct(['quantity' => 50]);
        $this->assertEquals('In Stock', $product->stock_status);
    }

    public function test_product_is_low_stock_when_quantity_between_1_and_10(): void
    {
        $product = $this->makeProduct(['quantity' => 5]);
        $this->assertEquals('Low Stock', $product->stock_status);
    }

    public function test_product_is_out_of_stock_when_quantity_is_zero(): void
    {
        $product = $this->makeProduct(['quantity' => 0]);
        $this->assertEquals('Out of Stock', $product->stock_status);
    }

    public function test_stock_status_updates_when_quantity_changes(): void
    {
        $product = $this->makeProduct(['quantity' => 50]);
        $this->assertEquals('In Stock', $product->stock_status);

        $product->update(['quantity' => 3]);
        $this->assertEquals('Low Stock', $product->fresh()->stock_status);
    }
}
