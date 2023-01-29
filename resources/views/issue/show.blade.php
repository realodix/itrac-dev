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
                    </div>
                    <div class="comment-body">
                        {{$issue->description}}
                    </div>
                    {{-- @if ($issue->isAuthor())
                        <div class="comment-footer">
                            <a href="{{route('issue.edit', $issue)}}" class="btn btn-primary">Edit</a>
                        </div>
                    @endif --}}
                </div>

                @foreach($issue->comments->sortBy('created_at') as $comment)
                    <div class="comment">
                        <div class="comment-header mt-4">
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
                                    <a href="{{route('issue.comment.delete', $comment)}}" class="font-semibold">Delete</a>
                                @endif
                            @endauth
                        </div>
                        <div class="comment-body bg-white">
                            {{$comment->text}}
                        </div>
                    </div>
                @endforeach

                <br>

                <x-form action="{{ route('issue.comment.store', $issue->id) }}">
                    @csrf
                    <x-easy-mde name="comment_text"/>

                    <x-form-button>Submit</x-form-button>
                </x-form>
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
