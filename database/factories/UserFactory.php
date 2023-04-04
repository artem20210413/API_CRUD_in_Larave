<?php

namespace Database\Factories;

use App\Models\Countries;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isoCodes = Countries::pluck('iso_code')->toArray();
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'verified' => fake()->date(),
            'iso_code_country' => fake()->randomElement($isoCodes),
        ];
    }
}
