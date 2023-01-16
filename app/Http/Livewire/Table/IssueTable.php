<?php

namespace App\Http\Livewire\Table;

use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{
    Column, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

/**
 * @codeCoverageIgnore
 */
final class IssueTable extends PowerGridComponent
{
    use ActionButton;

    const STR_LIMIT = 60;

    public bool $showUpdateMessages = true;

    public string $sortDirection = 'desc';

    /*
    |--------------------------------------------------------------------------
    | Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        return [
            Header::make()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount('full'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Builder
    {
        return Issue::query();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('ids', function () {
                return Blade::render('@svg(\'icon-dashboard\')');
            })
            ->addColumn('title', function (Issue $issue) {
                /** @var \Carbon\Carbon */
                $createdAt = $issue->created_at;
                $timeForHumans = $createdAt->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]);

                return
                    '<a href="'.route('issue.show', $issue->id).'" class="block font-semibold">'.$issue->title.'</a>'
                    .'#'.$issue->id.' opened on '.$timeForHumans.' by <a href="#">'.$issue->author->name.'</a>';
            })
            ->addColumn('comments', function () {
                return Blade::render('@svg(\'icon-dashboard\')').' 12';
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->field('ids')
                ->headerAttribute('hidden')
                ->bodyAttribute('!w-4'),

            Column::add()
                ->field('title')
                ->sortable()
                ->searchable()
                ->headerAttribute('hidden'),

            Column::add()
                ->field('comments')
                ->headerAttribute('hidden')
                ->bodyAttribute('!w-4'),
        ];
    }
}
