<div class="participation discussion-sidebar-item">
    <div class="mb-2">
        @php
            use Illuminate\Support\Str;
            $participants = $issue->participantCount();
        @endphp
        {{$participants}} {{Str::plural('participant', $participants)}}
    </div>
    <div class="">
        @foreach ($issue->participant()->get() as $participant)
            <img src="{{ Avatar::create($participant->author->name)->toBase64() }}" class="inline-block w-7 h-7 mb-1" title="{{$participant->author->name}}"/>
        @endforeach
    </div>
</div>

@auth
@if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
<div class="participation discussion-sidebar-item text-sm">
    <div class="flex flex-col">
        <div>
            @if ($issue->isLocked())
                <x-go-unlock-16 />
                <a href="{{route('issue.unlock', $issue)}}" class="font-semibold">Unlock conversation</a>
            @else
                <x-go-lock-16 />
                <a href="{{route('issue.lock', $issue)}}" class="font-semibold">Lock conversation</a>
            @endif
        </div>
        <div class="mt-4">
            @if ($issue->isClosed())
                <x-go-issue-reopened-16 />
                <a href="{{route('issue.reopen', $issue)}}" class="font-semibold">Reopen</a>
            @else
                <x-go-issue-closed-16 />
                <a href="{{route('issue.close', $issue)}}" class="font-semibold">Close</a>
            @endif
        </div>
        <div class="mt-4 text-red-600">
            <x-go-trash-16 />
            <a href="{{route('issue.delete', $issue)}}" class="font-semibold">Delete issue</a>
        </div>
    </div>
</div>
@endif
@endauth
