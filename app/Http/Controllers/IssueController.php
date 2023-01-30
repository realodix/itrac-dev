<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Services\MarkdownService;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function __construct(
        public MarkdownService $markdownService
    ) {
    }

    /**
     * Show the form for creating a new resource.
     *
     * User must be logged in to create an issue.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('issue.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $issue = Issue::create([
            'author_id'   => auth()->id(),
            'title'       => $request->issue_title,
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
        return view('issue.show',
            [
                'issue'   => $issue,
                'comment' => $issue->comments()->get(),
                'markdownService' => $this->markdownService,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', $issue);

        return view('issue.edit', compact('issue'));
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
}
