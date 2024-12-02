<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use App\Helpers\CommentsHelper;

class CommentSeeder extends Seeder
{
    use CommentsHelper;

    private const int MAX_COMMENTS = 8191;
    private const int POSTS_COUNT = 5;

    public function run(): void
    {
        $postIds = $this->generatePosts()->pluck('id')->toArray();
        $combinations = $this->generateCombinations();

        $count = 0;
        foreach ($combinations as $combination) {
            if ($count >= self::MAX_COMMENTS) {
                break;
            }

            $randomPostKey = array_rand($postIds);
            $comments[] = [
                'content' => strtolower($combination),
                'abbreviation' => $this->generateAbbreviation($combination),
                'post_id' => $postIds[$randomPostKey],
                'created_at' => now()
            ];

            $count++;
        }

        Comment::insert($comments);
    }

    private function generatePosts(): Collection
    {
        return Post::factory()->createMany([
            ['topic' => 'Games'],
            ['topic' => 'Movies'],
            ['topic' => 'Music'],
            ['topic' => 'TV Shows'],
            ['topic' => 'Travel']
        ]);
    }
}
