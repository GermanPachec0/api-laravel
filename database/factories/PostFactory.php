<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'title'=> fake()->sentence($nbWords=6,$variableNbWords=true),
          'author_id' => User::all()->random() ,
          'content' =>fake()->text($maxNbChars = 200)
        ];
    }
}
