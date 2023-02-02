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
                    <div class="comment-header grid grid-cols-2 content-center">
                        <div class="flex items-center space-x-4">
                            <img class="w-10 h-10 rounded-full" src="{{ Avatar::create($issue->author->name)->toBase64() }}"/>
                            <div>
                                <b>{{$issue->author->name}}</b>
                                <div class="text-sm text-gray-500">
                                    commented
                                    <a id="issue-{{$issue->id}}" href="#issue-{{$issue->id}}" title="{{$issue->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}">
                                        {{$issue->created_at->diffForHumans()}}
                                    </a>
                                </div>
                            </div>
                        </div>

                        @auth
                        @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
                            <div class="flex justify-end flex-wrap content-center">
                                <a href="{{route('issue.edit', $issue)}}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">Edit</a>
                            </div>
                        @endif
                        @endauth
                    </div>
                    <x-markdown class="comment-body markdown">{!! $issue->description !!}</x-markdown>
                </div>

                @foreach($issue->comments->sortBy('created_at') as $comment)
                    <div class="comment">
                        <div class="comment-header grid grid-cols-2 content-center">
                            <div class="flex items-center space-x-4">
                                <img class="w-10 h-10 rounded-full" src="{{ Avatar::create($comment->author->name)->toBase64() }}" alt="">
                                <div>
                                    <b>{{$comment->author->name}}</b>
                                    @if ($comment->isAuthor())
                                        <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">{{$comment->userRole()}}</span>
                                    @endif
                                    <div class="text-sm text-gray-500">
                                        commented
                                        <a id="comment-{{$comment->id}}"
                                            href="#comment-{{$comment->id}}"
                                            title="{{$comment->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}"
                                            >{{$comment->created_at->diffForHumans()}}</a>
                                    </div>
                                </div>
                            </div>

                            @auth
                            @if ($comment->isAuthor() || auth()->user()->hasRole('admin'))
                            <div class="flex justify-end flex-wrap content-center">
                                <a href="{{route('comment.edit', $comment)}}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">Edit</a>
                                <a href="{{route('comment.delete', $comment)}}" class="px-4 py-2 mr-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">Delete</a>
                            </div>
                            @endif
                            @endauth
                        </div>
                        <x-markdown class="comment-body markdown">{!! $comment->description !!}</x-markdown>
                    </div>
                @endforeach

                <br>

                @if (auth()->check())
                    <form method="post" action="{{ route('comment.store', $issue->id) }}">
                    @csrf
                        <x-easymde name="comment_description" placeholder="Leave a comment"/>

                        <button
                            class="bg-slate-900 hover:bg-slate-700 dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400
                                focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50
                                text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto "
                        >Submit</button>
                    </form>
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
