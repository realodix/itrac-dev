<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created comment in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Issue $issue)
    {
        Comment::create([
            'author_id' => auth()->id(),
            'issue_id'  => $issue->id,
            'text'      => $request->comment_text,
        ]);

        return redirect()->route('issue.show', $issue->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified comment.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comment.edit', compact('comment'));
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
            'text' => $request->comment_text,
        ]);

        return redirect()->route('issue.show', $comment->issue->id);
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
