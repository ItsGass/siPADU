<?php

namespace Database\Factories;

use App\Enums\SuggestionType;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Suggestion>
 */
class SuggestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(SuggestionType::cases()),
            'subject' => fake()->sentence(6),
            'message' => fake()->paragraphs(2, true),
            'is_anonymous' => fake()->boolean(20),
            'is_reviewed' => fake()->boolean(35),
        ];
    }
}
