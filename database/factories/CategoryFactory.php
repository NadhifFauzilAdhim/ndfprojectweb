<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $categories = ['IoT', 'Web Development', 'Machine Learning', 'Backend Development', 'Security'];
        $name = current($categories);
        next($categories);
        return [
            'name'=> $name,
            'slug'=> $this->faker->slug()
        ];
    }
}
