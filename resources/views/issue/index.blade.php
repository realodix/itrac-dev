@extends('layouts.frontend')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto pt-16 sm:pt-28">
        <div class="common-card-style p-4">
            <div class="flex mb-8">
                <div class="w-full text-right">
                    <a href="{{ route('issue.create') }}" title="{{__('New Issue')}}" class="btn">
                        @svg('icon-add-link', '!h-[1.5em] mr-1')
                        {{__('New Issue')}}
                    </a>
                </div>
            </div>

            @include('partials/messages')

            @livewire('table.issue-table')
        </div>
    </div>
@endsection
