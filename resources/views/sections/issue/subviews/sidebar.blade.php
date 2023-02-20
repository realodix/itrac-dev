<div class="participation sidebar-item">
    @php
        use Illuminate\Support\Str;
        $participants = $issue->participantCount();
        $comments = $issue->commentCount();
    @endphp
    <div>
        {{$comments}} {{Str::plural('comment', $comments)}}
    </div>
    <div class="mb-2">
        {{$participants}} {{Str::plural('participant', $participants)}}
    </div>
</div>

@auth
    @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
        <div class="participation sidebar-item">
            <div>
                @svg('icon-edit')
                <a href="{{route('issue.edit', $issue)}}">Edit title</a>
            </div>
            <div class="mb-2 mt-2">
                @svg('icon-edit')
                <a href="{{route('issue.edit', $issue)}}">Edit description</a>
            </div>
        </div>
    @endif

    @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
        <div class="participation sidebar-item text-sm">
            <div class="flex flex-col">
                <div>
                    @if ($issue->isLocked())
                        <x-icon-unlock-16 />
                        <a href="{{route('issue.unlock', $issue)}}" class="font-semibold">Unlock conversation</a>
                    @else
                        <x-icon-lock-16 />
                        <a href="{{route('issue.lock', $issue)}}" class="font-semibold">Lock conversation</a>
                    @endif
                </div>
                <div class="mt-2">
                    @if ($issue->isClosed())
                        <x-icon-issue-reopened-16 />
                        <a href="{{route('issue.reopen', $issue)}}" class="font-semibold">Reopen</a>
                    @else
                        <x-icon-issue-closed-16 />
                        <a href="{{route('issue.close', $issue)}}" class="font-semibold">Close</a>
                    @endif
                </div>
                <div class="mt-2 text-red-600">
                    <x-icon-trash-16 />
                    <a href="{{route('issue.delete', $issue)}}" class="font-semibold">Delete issue</a>
                </div>
            </div>
        </div>
    @endif
@endauth
