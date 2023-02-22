<?php

namespace App\Http\Controllers;

use App\Enums\CommentType;
use App\Enums\HistoryEvent;
use App\Enums\HistoryTag;
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
            $request->issue_title = 'No title';
        }

        $issue = Issue::create([
            'author_id'   => auth()->id(),
            'title'       => $request->issue_title,
            'type'        => CommentType::Comment->value,
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

        return view('sections.issue.edit', ['issue' => $issue]);
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
                'event'      => HistoryEvent::Updated,
                'issue_id'   => $issue->id,
                'old_values' => [
                    'title' => $issue->getOriginal('title'),
                ],
                'new_values' => [
                    'title' => $request->title,
                ],
                'tag'       => HistoryTag::IssueTitle,
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
     * Close issue and add a comment.
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
            'type'        => CommentType::Revision,
            'description' => 'closed this issue',
            'tag'         => HistoryTag::Closed->value,
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::IssueStatus)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::Updated,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['closed' => true],
            'tag'        => HistoryTag::IssueStatus,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Reopen the issue and add a comment.
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
            'type'        => CommentType::Revision,
            'description' => 'reopened this issue',
            'tag'         => HistoryTag::Reopened->value,
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::IssueStatus)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::Updated,
            'old_values' => $history ? $history->new_values : [],
            'issue_id'   => $issue->id,
            'new_values' => ['closed' => false],
            'tag'        => HistoryTag::IssueStatus,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Lock the conversation on the specified issue and add a comment.
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
            'type'        => CommentType::Revision,
            'description' => 'locked and limited conversation to collaborators',
            'tag'         => HistoryTag::Locked->value,
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::CommentStatus)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::Updated,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['locked' => true],
            'tag'        => HistoryTag::CommentStatus,
        ]);

        return to_route('issue.show', $issue);
    }

    /**
     * Unlock the conversation on the specified issue and add a comment.
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
            'type'        => CommentType::Revision,
            'description' => 'unlocked this conversation',
            'tag'         => HistoryTag::Unlocked->value,
        ]);

        $history = IssueHistory::where('issue_id', $issue->id)
            ->where('tag', HistoryTag::CommentStatus)
            ->latest()
            ->first();
        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::Updated,
            'issue_id'   => $issue->id,
            'old_values' => $history ? $history->new_values : [],
            'new_values' => ['locked' => false],
            'tag'        => HistoryTag::CommentStatus,
        ]);

        return to_route('issue.show', $issue);
    }
}
