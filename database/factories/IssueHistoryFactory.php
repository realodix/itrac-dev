<?php

namespace Database\Factories;

use App\Enums\HistoryEvent;
use App\Models\Issue;
use App\Models\IssueHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IssueHistory>
 */
class IssueHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<IssueHistory>
     */
    protected $model = IssueHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'event'     => HistoryEvent::Created->value,
            'issue_id'  => Issue::factory(),
        ];
    }
}
