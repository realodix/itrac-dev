<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Issue $issue)
    {
        if ($issue->isLocked()
            && ! $issue->isAuthor() && ! $issue->isParticipant()
            && ! auth()->user()->hasRole('admin')
        ) {
            abort(403);
        }

        $comment = Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'description' => $request->comment_description,
        ]);

        return redirect()->route('issue.show.comment', [
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

        return view('sections.comment.edit', compact('comment'));
    }

    /**
     * Update the specified comment in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update([
            'description' => $request->comment_description,
        ]);

        return redirect()->route('issue.show.comment', [
            $comment->issue->id,
            $comment->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('forceDelete', $comment);

        Comment::destroy($comment->id);

        return redirect()->route('issue.show', $comment->issue->id);
    }
}
