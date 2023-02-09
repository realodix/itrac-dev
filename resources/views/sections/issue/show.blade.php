@extends('layouts.layout')

@section('css_class', 'frontend home')

@section('content')
    <div class="issue">
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
                &middot; {{ $issue->commentCount(); }} comments
            </div>
        </div>

        <div class="issue_bucket flex">
            <div class="md:w-8/12 justify-between">
                @include('sections.issue.subviews.summary')

                @include('sections.issue.subviews.timeline')

                <br>

                @include('sections.issue.subviews.comment-form')
            </div>
            <div class="md:w-4/12 px-4 py-2">
                @include('sections.issue.subviews.sidebar')
            </div>
        </div>
    </div>
@endsection
