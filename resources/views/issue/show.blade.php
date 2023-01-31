@extends('layouts.frontend')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto sm:pt-10 mb-12">
        <div class="header-meta">
            <div class="text-3xl mb-2">#{{$issue->id}} - {{$issue->title}}</div>
            <div class="mb-2">
                <span class="mr-4 py-1 px-2 border bg-green-600 border-green-600 rounded-md text-md text-white">
                    @svg('icon-dashboard')
                    {{$issue->status()}}
                </span>
                <b>{{$issue->author->name}}</b> opened this issue <span title="{{$issue->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}">{{$issue->created_at->diffForHumans()}}</span>
                &middot; {{$issue->comments->count()}} comments
            </div>
        </div>

        <div class="issue_bucket flex">
            <div class="md:w-8/12 justify-between">
                <div class="comment mb-8">
                    <div class="comment-header">
                        <img src="{{ Avatar::create($issue->author->name)->toBase64() }}" class="h-8 inline-block" />
                        <b>{{$issue->author->name}}</b> commented
                        <a id="issue-{{$issue->id}}" href="#issue-{{$issue->id}}" title="{{$issue->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}">
                            {{$issue->created_at->diffForHumans()}}
                        </a>
                        @auth
                            @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
                                <a href="{{route('issue.edit', $issue)}}" class="font-semibold">Edit</a>
                            @endif
                        @endauth
                    </div>
                    <div class="comment-body markdown">
                        {!! $markdownService->handle($issue->description) !!}
                    </div>
                </div>

                @foreach($issue->comments->sortBy('created_at') as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            <img src="{{ Avatar::create($comment->author->name)->toBase64() }}" class="h-8 inline-block" />
                            <b>{{$comment->author->name}}</b> commented
                            <a id="comment-{{$comment->id}}" href="#comment-{{$comment->id}}" title="{{$comment->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}">
                                {{$comment->created_at->diffForHumans()}}
                            </a>
                            @if ($comment->isAuthor())
                                <span class="py-px px-1 border border-gray-600 rounded text-sm text-gray-600">{{$comment->userRole()}}</span>
                            @endif

                            @auth
                                @if ($comment->isAuthor() || auth()->user()->hasRole('admin'))
                                    <a href="{{route('comment.edit', $comment)}}" class="font-semibold">Edit</a>
                                    <a href="{{route('comment.delete', $comment)}}" class="font-semibold">Delete</a>
                                @endif
                            @endauth
                        </div>
                        <div class="comment-body markdown bg-white">
                            {!! $markdownService->handle($comment->text) !!}
                        </div>
                    </div>
                @endforeach

                <br>

                @if (auth()->check())
                    <x-form action="{{ route('comment.store', $issue->id) }}">
                    @csrf
                        <textarea name="comment_text" id="easy-mde-markdown-editor" placeholder="Leave a comment" required></textarea>
                        {{-- <x-easy-mde name="comment_text" :options="['minHeight' => '180px']" placeholder="Leave a comment" required/> --}}

                        <x-form-button
                            class="bg-slate-900 hover:bg-slate-700 dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400
                                focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50
                                text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto "
                        >
                            Submit
                        </x-form-button>
                    </x-form>
                @else
                    You need to <a href="{{route('login')}}" class="text-blue-600">log in</a> before you can comment.
                @endif
            </div>
            <div class="md:w-4/12 px-4 py-2">
                <div class="participation discussion-sidebar-item">
                    <div class="mb-2">
                        {{$issue->participantCount()}} participants
                    </div>
                    <div class="">
                        @foreach ($issue->participant()->get() as $participant)
                            <img src="{{ Avatar::create($participant->author->name)->toBase64() }}" class="inline-block w-7 h-7 mb-1" title="{{$participant->author->name}}"/>
                        @endforeach
                    </div>
                </div>
                @auth
                    @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
                        <div class="participation discussion-sidebar-item">
                            <div class="">
                                <a href="{{route('issue.delete', $issue)}}" class="font-semibold">Delete issue</a>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection
