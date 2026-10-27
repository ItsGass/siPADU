<?php

namespace Database\Factories;

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category' => fake()->randomElement(ComplaintCategory::cases()),
            'title' => fake()->sentence(7),
            'description' => fake()->paragraphs(3, true),
            'location' => 'Gedung '.fake()->randomLetter().', Lantai '.fake()->numberBetween(1, 3),
            'incident_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'is_anonymous' => fake()->boolean(15),
            'status' => fake()->randomElement(ComplaintStatus::cases()),
            'priority' => fake()->randomElement(ComplaintPriority::cases()),
        ];
    }

    public function status(ComplaintStatus $status): static
    {
        return $this->state(fn () => ['status' => $status]);
    }
}
