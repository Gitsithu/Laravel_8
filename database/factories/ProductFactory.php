<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\CategoryFactory;
use App\Models\Category;
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'category_id' => Category::all()->random()->id,
            'product_code' => $this->faker->word(),
            'qty' =>  $this->faker->numberBetween(1,10),
            'image_url1' => $this->faker->imageUrl(100,100),
            'description' => $this->faker->sentence(),
            'remark' => $this->faker->sentence(),
            'sale_price' => $this->faker->numberBetween(10000,50000),
            'additional_charges' => $this->faker->numberBetween(1000,5000),

            
            
        ];
    }
}
