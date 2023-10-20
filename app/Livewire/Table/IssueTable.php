<?php

namespace App\Livewire\Table;

use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

/**
 * @codeCoverageIgnore
 */
final class IssueTable extends PowerGridComponent
{
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
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('ids', function (Issue $issue) {
                $openIssueIcon = '<x-icon-issue-opened-16 class="text-green-600" />';
                $closedIssueIcon = '<x-icon-issue-closed-16 class="text-violet-700" />';

                $statusIcon = $issue->isClosed() ? $closedIssueIcon : $openIssueIcon;

                return Blade::render($statusIcon);
            })
            ->addColumn('title', function (Issue $issue) {
                $timeForHumans = $issue->created_at->diffForHumans(['options' => Carbon::ONE_DAY_WORDS]);

                return
                    '<a href="'.route('issue.show', $issue->id).'" class="block font-semibold">'.$issue->title.'</a>'
                    .'#'.$issue->id.' opened on '.$timeForHumans.' by <a href="#">'.$issue->author->name.'</a>';
            })
            ->addColumn('comments', function (Issue $issue) {
                $comment = $issue->commentCount();

                return Blade::render('<x-icon-comment-16 />').' '.$comment;
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
