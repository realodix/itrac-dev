@extends('layouts.frontend')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto sm:pt-10">
        <div class="header-meta">
            <div class="text-3xl">{{$issue->title}}</div>
            <div>
                {{$issue->status()}}
            </div>
            <div>
                <b>{{$issue->author->name}}</b> opened this issue {{$issue->created_at->diffForHumans()}}
                &middot; {{$issue->comments->count()}} comments
            </div>
        </div>

        <div class="issue_bucket flex">
            <div class="comment md:w-8/12 justify-between">
                <div class="issue mb-8 bg-white">
                    <div class="comment-header">
                        <b>{{$issue->author->name}}</b> commented {{$issue->created_at->diffForHumans()}}
                    </div>
                    <div class="comment-body">
                        {{$issue->description}}
                    </div>
                </div>

                @foreach($issue->comments->sortBy('created_at') as $comment)
                    <div class="comment-header mt-4">
                        <b>{{$comment->author->name}}</b> commented
                        <a id="comment-{{$comment->id}}" href="#comment-{{$comment->id}}" title="{{$comment->created_at->isoFormat('MMM DD, OY, HH:mm A zz')}}">
                            {{$comment->created_at->diffForHumans()}}
                        </a>
                        @if ($comment->isAuthor())
                            <span class="py-px px-1 border border-gray-600 rounded text-sm text-gray-600">{{$comment->userRole()}}</span>
                        @endif
                    </div>
                    <div class="comment-body bg-white">
                        {{$comment->text}}
                    </div>
                @endforeach
            </div>
            <div class="md:w-2/12 px-4 py-2">
                {{-- {{$issue->description}} --}}
                b
            </div>
        </div>
    </div>
@endsection
