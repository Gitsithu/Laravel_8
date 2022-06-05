<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
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
            'transaction_type' => $this->faker->word(),

            'account_number' => $this->faker->numberBetween(1000,10000),
        ];
    }
}
