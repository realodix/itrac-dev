<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Enums\HistoryEvent;
use App\Enums\HistoryTag;
use App\Enums\TimelineType;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\IssueHistory;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Show the form for creating a new issue.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sections.issue.create');
    }

    /**
     * Store a newly created issue in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->issue_title === null) {
            // If the user didn't provide a title, we'll generate one for them.
            $request->issue_title = 'No title';
        }

        $issue = Issue::create([
            'author_id'   => auth()->id(),
            'title'       => $request->issue_title,
            'type'        => TimelineType::COMMENT->value,
            'description' => $request->issue_description,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Display the specified issue.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Issue $issue)
    {
        return view('sections.issue.show', ['issue' => $issue]);
    }

    /**
     * Show the form for editing the specified issue.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', $issue);

        return view('sections.issue.edit', compact('issue'));
    }

    /**
     * Update the specified issue in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Issue $issue)
    {
        $this->authorize('update', $issue);

        if ($issue->title !== $request->title) {
            IssueHistory::create([
                'author_id'  => auth()->id(),
                'event'      => HistoryEvent::UPDATED,
                'issue_id'   => $issue->id,
                'old_values' => [
                    'title' => $issue->getOriginal('title'),
                ],
                'new_values' => [
                    'title' => $request->title,
                ],
                'tag'       => HistoryTag::ISSUE_TITLE,
            ]);
        }

        $issue->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Remove the specified issue from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Issue $issue)
    {
        $this->authorize('forceDelete', $issue);

        Issue::destroy($issue->id);

        return to_route('home');
    }

    /**
     * Close the specified issue.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(Issue $issue)
    {
        $this->authorize('close', $issue);

        $issue->update([
            'closed_by' => auth()->id(),
            'closed_at' => now(),
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => TimelineType::EVENT,
            'event_type'  => EventType::CLOSED,
            'description' => 'closed this issue',
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::ISSUE_STATUS)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::UPDATED,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['closed' => true],
            'tag'        => HistoryTag::ISSUE_STATUS,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Reopen the specified issue.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reopen(Issue $issue)
    {
        $this->authorize('reopen', $issue);

        $issue->update([
            'closed_by'   => null,
            'closed_date' => null,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => TimelineType::EVENT,
            'event_type'  => EventType::REOPENED,
            'description' => 'reopened this issue',
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::ISSUE_STATUS)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::UPDATED,
            'old_values' => $history ? $history->new_values : [],
            'issue_id'   => $issue->id,
            'new_values' => ['closed' => false],
            'tag'        => HistoryTag::ISSUE_STATUS,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Lock the specified issue.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Issue $issue)
    {
        $this->authorize('lock', $issue);

        $issue->update([
            'locked_by' => auth()->id(),
            'locked_at' => now(),
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => TimelineType::EVENT,
            'event_type'  => EventType::LOCKED,
            'description' => 'locked and limited conversation to collaborators',
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::COMMENT_STATUS)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::UPDATED,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['locked' => true],
            'tag'        => HistoryTag::COMMENT_STATUS,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Unlock the specified issue.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Issue $issue)
    {
        $this->authorize('unlock', $issue);

        $issue->update([
            'locked_by' => null,
            'locked_at' => null,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => TimelineType::EVENT,
            'event_type'  => EventType::UNLOCKED,
            'description' => 'unlocked this conversation',
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::COMMENT_STATUS)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::UPDATED,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['locked' => false],
            'tag'        => HistoryTag::COMMENT_STATUS,
        ]);

        return to_route('issue.show', $issue);
    }
}
