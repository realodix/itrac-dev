@foreach($issue->comments->sortBy('created_at') as $comment)
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
@endforeach
