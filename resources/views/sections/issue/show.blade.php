@extends('layouts.layout')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto sm:pt-10 mb-12">
        <div class="header-meta">
            <div class="text-3xl mb-2">#{{$issue->id}} - {{$issue->title}}</div>
            <div class="mb-2">
                <span @class([
                        'mr-4 py-1 px-2 border rounded-md text-md text-white',
                        'bg-green-600 border-green-600' => ! $issue->isClosed(),
                        'bg-violet-700 border-violet-700' => $issue->isClosed(),
                    ])>
                    @if ($issue->isClosed())
                       <x-go-issue-closed-16 />
                    @else
                        <x-go-issue-opened-16 />
                    @endif
                    {{$issue->status()}}
                </span>
                <b>{{$issue->author->name}}</b> opened this issue <span title="{{$issue->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}">{{$issue->created_at->diffForHumans()}}</span>
                &middot; {{$issue->comments->count()}} comments
            </div>
        </div>

        <div class="issue_bucket flex">
            <div class="md:w-8/12 justify-between">
                <div class="comment mb-8">
                    <div class="comment-header grid grid-cols-2 content-center">
                        <div class="flex items-center space-x-4">
                            <img src="{{ Avatar::create($issue->author->name)->toBase64() }}" class="comment-header-avatar"/>
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
                    <x-markdown class="comment-body markdown">{!! $issue->description !!}</x-markdown>
                </div>

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
                            @if ($comment->isIssueAuthor() || auth()->user()->hasRole('admin'))
                                <div class="flex justify-end flex-wrap content-center">
                                    @if ($comment->isIssueAuthor())
                                        <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">
                                            {{$comment->userRole()}}</span>
                                    @endif
                                    <x-comment-action>
                                        <x-comment-action-item>
                                            <a href="{{route('comment.edit', $comment)}}">Edit</a>
                                        </x-comment-action-item>
                                        <x-comment-action-item>
                                            <a href="{{route('comment.delete', $comment)}}"><span class="text-red-600">Delete</span></a>
                                        </x-comment-action-item>
                                    </x-comment-action>
                                </div>
                            @endif
                            @endauth
                        </div>
                        <x-markdown class="comment-body markdown">{!! $comment->description !!}</x-markdown>
                    </div>
                @endforeach

                <br>

                @if (auth()->check())
                    @if ($issue->isLocked() && ! $issue->isParticipant() && ! auth()->user()->hasRole('admin'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Issue Locked!</strong>
                            <span class="block sm:inline">This issue is locked and limited conversations to collaborators. You can't comment on it.</span>
                        </div>
                    @endif
                    <form method="post" action="{{ route('comment.store', $issue->id) }}">
                    @csrf
                        <x-easymde name="comment_description" placeholder="Leave a comment"/>

                        <div class="flex justify-end mt-2">
                            <button
                                class="px-4 py-2 rounded-lg w-full flex items-center justify-center sm:w-auto
                                    text-white font-semibold bg-slate-900 hover:bg-slate-700
                                    focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50"
                                >Submit</button>
                        </div>
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
                                <div>
                                    @if ($issue->isClosed())
                                        <x-go-issue-reopened-16 class="text-green-600" />
                                        <a href="{{route('issue.reopen', $issue)}}" class="font-semibold">Reopen</a>
                                    @else
                                        <x-go-issue-closed-16 class="text-violet-700" />
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
            </div>
        </div>
    </div>
@endsection
