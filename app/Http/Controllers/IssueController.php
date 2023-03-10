<?php

namespace App\Http\Controllers;

use App\Enums\CommentType;
use App\Enums\HistoryTag;
use App\Models\Comment;
use App\Models\Issue;
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
            'is_closed' => true,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => CommentType::Revision->value,
            'description' => 'issue: close',
            'tag'         => HistoryTag::Close->value,
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
            'is_closed' => false,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => CommentType::Revision->value,
            'description' => 'issue: open',
            'tag'         => HistoryTag::Open->value,
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
            'is_locked' => true,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => CommentType::Revision->value,
            'description' => 'comment: lock',
            'tag'         => HistoryTag::Lock->value,
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
            'is_locked' => false,
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => CommentType::Revision->value,
            'description' => 'comment: unlock',
            'tag'         => HistoryTag::Unlock->value,
        ]);

        return to_route('issue.show', $issue);
    }
}
