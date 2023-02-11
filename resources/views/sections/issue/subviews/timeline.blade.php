{{-- https://tailwind-elements.com/docs/standard/components/timeline/ --}}
{{-- https://flowbite.com/docs/components/timeline/#vertical-timeline --}}
@foreach($issue->comments->sortBy('created_at') as $comment)
@if ($comment->isComment())
    <li class="mb-8 -ml-6">
        <div class="box">
            <div class="box-header">
                <div class="box-header-meta">
                    <img src="{{ Avatar::create($comment->author->name)->toBase64() }}" class="box-header-meta-avatar"/>
                    <div class="!ml-0">
                        <b>{{$comment->author->name}}</b>
                        <span class="text-sm text-gray-500">
                            commented
                            <a href="#comment-{{$comment->id}}"
                                id="comment-{{$comment->id}}"
                                title="{{$comment->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}"
                                >{{$comment->created_at->diffForHumans()}}</a>
                        </span>
                    </div>
                </div>

                @if ($comment->isIssueAuthor())
                <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">
                    {{$comment->userRole()}}</span>
                @endif

                @auth
                <div class="box-header-actions">
                    @if ($comment->isAuthor() || auth()->user()->hasRole('admin'))
                    <x-comment-action>
                        <x-comment-action-item>
                            <a href="{{route('comment.edit', $comment)}}">Edit</a>
                        </x-comment-action-item>
                        <x-comment-action-item>
                            <a href="{{route('comment.delete', $comment)}}">
                                <span class="text-red-600">Delete</span></a>
                        </x-comment-action-item>
                    </x-comment-action>
                    @endif

                </div>
                @endauth
            </div>
            <x-markdown class="box-body markdown">{!! $comment->description !!}</x-markdown>
        </div>
    </li>
@else
    <li class="mt-8 mb-8 ml-6">
        @if ($comment->event_type == \App\Enums\EventType::CLOSED->value)
        <span class="absolute flex items-center justify-center w-7 h-7 bg-violet-700 rounded-full -left-4">
            <x-go-issue-closed-16 class="w-6 h-6 text-white"/>
        </span>
        @elseif ($comment->event_type == \App\Enums\EventType::REOPENED->value)
        <span class="absolute flex items-center justify-center w-7 h-7 bg-green-600 rounded-full -left-4">
            <x-go-issue-reopened-16 class="w-6 h-6 text-white"/>
        </span>
        @elseif ($comment->event_type == \App\Enums\EventType::LOCKED->value)
        <span class="absolute flex items-center justify-center w-7 h-7 bg-gray-800 rounded-full -left-4">
            <x-go-lock-16 class="w-6 h-6 text-red-500"/>
        </span>
        @elseif ($comment->event_type == \App\Enums\EventType::UNLOCKED->value)
        <span class="absolute flex items-center justify-center w-7 h-7 bg-gray-800 rounded-full -left-4">
            <x-go-unlock-16 class="w-6 h-6 text-green-500"/>
        </span>
        @endif
        <p class="text-sm font-normal text-gray-500">
            <b class="text-[#1F2937]">{!! $comment->author->name !!}</b>
            {!! $comment->description !!}
            <a href="#event-{{crc32($comment->id)}}"
                id="event-{{crc32($comment->id)}}"
                title="{{$comment->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}"
                >{{$comment->created_at->diffForHumans()}}</a>
        </p>
    </li>
@endif
@endforeach
