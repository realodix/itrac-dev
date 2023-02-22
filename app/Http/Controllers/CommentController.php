<?php

namespace App\Http\Controllers;

use App\Enums\CommentType;
use App\Enums\HistoryEvent;
use App\Enums\HistoryTag;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\IssueHistory;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Issue $issue)
    {
        if ($issue->isLocked()) {
            $this->authorize('createCommentLockedIssues', $issue);
        }

        $comment = Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => CommentType::Comment->value,
            'description' => $request->comment_description,
            'tag'         => HistoryTag::Comment,
        ]);

        IssueHistory::create([
            'author_id'  => auth()->id(),
            'event'      => HistoryEvent::Created,
            'issue_id'   => $issue->id,
            'new_values' => ['comment' => $comment->description],
            'tag'        => HistoryTag::Comment,
        ]);

        return to_route('issue.show.comment', [
            $comment->issue->id,
            $comment->id,
        ]);
    }

    /**
     * Show the form for editing the specified comment.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('sections.comment.edit', ['comment' => $comment]);
    }

    /**
     * Update the specified comment on the specified issue in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update([
            'description' => $request->comment_description,
        ]);

        return to_route('issue.show.comment', [
            $comment->issue->id,
            $comment->id,
        ]);
    }

    /**
     * Remove the specified comment on the specified issue from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('forceDelete', $comment);

        Comment::destroy($comment->id);

        return to_route('issue.show', $comment->issue->id);
    }
}
