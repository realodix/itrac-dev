<?php

namespace Database\Factories;

use App\Enums\TimelineType;
use App\Models\Issue;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Timeline>
 */
class TimelineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Timeline>
     */
    protected $model = Timeline::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id'   => User::factory(),
            'issue_id'    => Issue::factory(),
            'type'        => TimelineType::Comment,
            'description' => fake()->paragraph(),
        ];
    }
}
