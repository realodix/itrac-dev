@extends('layouts.frontend')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto pt-16 sm:pt-28">
        {{$issue->title}}
        {{$issue->description}}
        {{$issue->status}}
        {{$issue->created_at}}
        {{$issue->updated_at}}
    </div>
@endsection
