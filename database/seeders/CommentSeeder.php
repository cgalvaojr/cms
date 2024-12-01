<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    private const int MAX_COMMENTS = 8191;
    private const int POSTS_COUNT = 5;
    private const string RANDOM_WORDS = "Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost";

    public function run(): void
    {
        $postIds = $this->generatePosts()->pluck('id')->toArray();
        $combinations = $this->generateCombinations();
        $randomPostKey = array_rand($postIds);

        $count = 0;
        foreach ($combinations as $combination) {
            if ($count >= self::MAX_COMMENTS) {
                break;
            }

            $comments[] = [
                'content' => $combination,
                'abbreviation' => $this->generateAbbreviation($combination),
                'post_id' => $postIds[$randomPostKey]
            ];

            $count++;
        }

        Comment::insert($comments);
    }

    private function generatePosts(): Collection
    {
        return Post::factory()->count(self::POSTS_COUNT)->create();
    }

    private function generateCombinations(): array
    {
        $wordsArray = array_map('strtolower', explode(',', self::RANDOM_WORDS));
        $combinations = [];

        foreach ($wordsArray as $i => $word) {
            $this->combine(array_slice($wordsArray, $i), [], $combinations);
        }

        return $combinations;
    }

    private function combine(array $words, array $current, array &$combinations): void
    {
        if ($current) {
            $combinations[] = implode(' ', $current);
        }

        foreach ($words as $i => $word) {
            $this->combine(array_slice($words, $i + 1), array_merge($current, [$word]), $combinations);
        }
    }

    private function generateAbbreviation(string $content): string
    {
        $words = explode(' ', $content);
        $abbreviation = '';

        foreach ($words as $word) {
            $abbreviation .= $word[0];
        }

        return $abbreviation;
    }
}
