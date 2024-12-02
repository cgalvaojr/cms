<?php

namespace App\Helpers;

trait CommentsHelper
{
    private const string RANDOM_WORDS = "Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost";

    public function generateCombinations(): array
    {
        $wordsArray = explode(',', self::RANDOM_WORDS);
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

    public function generateAbbreviation(string $content): string
    {
        $words = explode(' ', $content);
        $abbreviation = '';

        foreach ($words as $word) {
            $abbreviation .= $word[0];
        }

        return strtolower($abbreviation);
    }
}
