<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\CommentsHelper;
class CommentFactory extends Factory
{
    use CommentsHelper;
    public function definition(): array
    {
        $sentence = $this->faker->sentence;
        return [
            'content' => strtolower($sentence),
            'abbreviation' => $this->generateAbbreviation($sentence),
            'post_id' => Post::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
