<?php

namespace Database\Factories;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Issue>
 */
class IssueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Issue>
     */
    protected $model = Issue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id'   => User::factory(),
            'title'       => fake()->words(3, true),
            'description' => fake()->paragraphs(nb: 3, asText: true),
            'is_locked'   => false,
        ];
    }
}
