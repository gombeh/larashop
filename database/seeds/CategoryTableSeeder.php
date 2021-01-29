<?php

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(['Laptops', 'Desktops', 'Phones', 'Tablets', 
                        'TVs', 'Cameras', 'Appliances']);

        factory(Category::class, 7)->make()->each(function($category) use($categories) {
            $category->name = $categories->shift();
            $category->slug = Str::slug($category->name);
            $category->save();
        });
    }
}
