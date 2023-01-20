<?php

namespace Database\Factories;

use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id'   => rand(1, 2),
            'title'       => fake()->words(3, true),
            'description' => fake()->paragraphs(nb: 3, asText: true),
        ];
    }
}