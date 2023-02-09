<div class="box mb-8 shadow">
    <div class="box-header grid grid-cols-2 content-center">
        <div class="flex items-center space-x-4">
            <img src="{{ Avatar::create($issue->author->name)->toBase64() }}" class="box-header-avatar"/>
            <div>
                <b>{{$issue->author->name}}</b>
                <div class="text-sm text-gray-500">
                    commented
                    <a href="#issue-{{$issue->id}}"
                        id="issue-{{$issue->id}}"
                        title="{{$issue->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}"
                        >{{$issue->created_at->diffForHumans()}}</a>
                </div>
            </div>
        </div>

        @auth
        @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
            <div class="flex justify-end flex-wrap content-center">
                <x-comment-action>
                    <x-comment-action-item>
                        <a href="{{route('issue.edit', $issue)}}">Edit</a>
                    </x-comment-action-item>
                </x-comment-action>
            </div>
        @endif
        @endauth
    </div>

    <x-markdown class="box-body markdown">{!! $issue->description !!}</x-markdown>
</div>
