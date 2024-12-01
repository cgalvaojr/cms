<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()->createMany([
            ['topic' => 'Games'],
            ['topic' => 'Movies'],
            ['topic' => 'Music'],
            ['topic' => 'TV Shows'],
            ['topic' => 'Travel'],
        ]);
    }
}
