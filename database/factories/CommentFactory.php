<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            'abbreviation' => $this->faker->word,
            'post_id' => Post::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
