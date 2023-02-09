{{-- https://tailwind-elements.com/docs/standard/components/timeline/ --}}
{{-- https://flowbite.com/docs/components/timeline/#vertical-timeline --}}
<ol class="relative border-l border-gray-200 ml-6">
@foreach($issue->comments->sortBy('created_at') as $comment)
    @if ($comment->isComment())
        <li class="mb-10 -ml-6">
            <div class="comment">
                <div class="comment-header grid grid-cols-2 content-center">
                    <div class="flex items-center space-x-4">
                        <img src="{{ Avatar::create($comment->author->name)->toBase64() }}" class="comment-header-avatar"/>
                        <div>
                            <b>{{$comment->author->name}}</b>
                            <div class="text-sm text-gray-500">
                                commented
                                <a href="#comment-{{$comment->id}}"
                                    id="comment-{{$comment->id}}"
                                    title="{{$comment->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}"
                                    >{{$comment->created_at->diffForHumans()}}</a>
                            </div>
                        </div>
                    </div>

                    @auth
                    <div class="flex justify-end flex-wrap content-center">
                        @if ($comment->isIssueAuthor())
                        <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">
                            {{$comment->userRole()}}</span>
                        @endif

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
                <x-markdown class="comment-body markdown">{!! $comment->description !!}</x-markdown>
            </div>
        </li>
    @else
        <li class="mb-6 ml-6">
            <span class="absolute flex items-center justify-center w-7 h-7 bg-teal-600 rounded-full -left-4">
                <x-go-info-16 class="w-6 h-6 text-white" />
            </span>
            <p class="text-base font-normal text-gray-500 dark:text-gray-400">
                <b class="text-[#1F2937]">{!! $comment->author->name !!}</b> {!! $comment->description !!} {!! $comment->created_at->diffForHumans() !!}
            </p>
        </li>
    @endif
@endforeach
</ol>
