<?php

namespace App\Http\Livewire\Table;

use App\Models\Issue;
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
                ->showToggleColumns()
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
            ->addColumn('ids', function (Issue $issue) {
                return Blade::render('@svg(\'icon-dashboard\')');
            })
            ->addColumn('title', function (Issue $issue) {
                return
                    '<span class="font-semibold">'.$issue->title.'</span> </br>'
                    .'#'.$issue->id.' by '.$issue->author->name;
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
                // ->title('ID')
                ->field('ids')
                ->headerAttribute('hidden'),

            Column::add()
                // ->title('Title')
                ->field('title')
                ->sortable()
                ->searchable()
                ->headerAttribute('hidden'),
        ];
    }
}
