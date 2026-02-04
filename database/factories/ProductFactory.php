<?php

namespace Database\Factories;

use App\Models\Category;
use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws DateMalformedStringException
     */
    public function definition(): array
    {
        $date = new DateTimeImmutable();
        $categoryIds = array_flip(Category::all()->pluck('id')->toArray());

        return [
            'name' => $this->generateProductName(),
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'category_id' => array_rand($categoryIds),
            'in_stock' => rand(0, 1),
            'rating' => rand(0, 5),
            'created_at' => $date->modify('- ' . rand(1, 156) . ' days')->format('Y-m-d H:m:s'),
            'updated_at' => $date->format('Y-m-d H:m:s'),
        ];
    }

    private function generateProductName($length = 10): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return ucfirst($randomString);
    }
}
