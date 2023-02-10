<?php

namespace App\Http\Controllers;

use App\Enums\EventType;
use App\Enums\TimelineType;
use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * User must be logged in to create an issue.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('sections.issue.create');
    }

    /**
     * Store a newly created resource in storage.
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
            'type'        => TimelineType::COMMENT,
            'description' => $request->issue_description,
        ]);

        return redirect()->route('issue.show', $issue);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Issue $issue)
    {
        return view('sections.issue.show', ['issue' => $issue]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', $issue);

        return view('sections.issue.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Issue $issue)
    {
        $this->authorize('update', $issue);

        $issue->update($request->all());

        return redirect()->route('issue.show', $issue);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Issue $issue)
    {
        $this->authorize('forceDelete', $issue);

        Issue::destroy($issue->id);

        return redirect()->route('home');
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
            'closed_by'   => auth()->id(),
            'closed_at' => now(),
        ]);

        Comment::create([
            'author_id'   => auth()->id(),
            'issue_id'    => $issue->id,
            'type'        => TimelineType::EVENT,
            'event_type'  => EventType::CLOSED,
            'description' => 'closed this issue',
        ]);

        return redirect()->route('issue.show', $issue);
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

        return redirect()->route('issue.show', $issue);
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

        return redirect()->route('issue.show', $issue);
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

        return redirect()->route('issue.show', $issue);
    }
}
