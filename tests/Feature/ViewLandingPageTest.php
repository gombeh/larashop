<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewLandingPageTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function landing_page_loads_correctly()
    {

        //Arrange

        //Act
            $response = $this->get('/');

        //Assert
        $response->assertStatus(200);
        $response->assertSee('Larashop Test');
        $response->assertSee('Includes multiple products');
    
    }

    /** @test */
    public function featured_product_is_visible() 
    {
        //Arrang
        $featuredProduct = factory(Product::class)->create([
            'featured' => true,
            'price' => 2344,
            'name' => 'laptop 1'
        ]);

        //Act 

            $response = $this->get('/');

        //Assert

        $response->assertSee($featuredProduct->name);
        $response->assertSee('$23.44');
    }
    /** @test */
    public function not_featured_product_is_not_visible() 
    {
        //Arrang
        $notFeaturedProduct = factory(Product::class)->create([
            'featured' => false,
            'price' => 2344,
            'name' => 'laptop 1'
        ]);

        //Act 

            $response = $this->get('/');

        //Assert

        $response->assertDontSee($notFeaturedProduct->name);
        $response->assertDontSee('$23.44');
    }
}
