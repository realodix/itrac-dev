@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
    <main>
        <div class="common-card-style mb-4 p-4">
//
        </div>

        <div class="common-card-style p-4">
            <div class="flex mb-8">
                <div class="w-1/2">
                    <span class="text-2xl text-uh-1">{{__('My URLs')}}</span>
                </div>
                <div class="w-1/2 text-right">
                    <a href="{{ url('./') }}" target="_blank" title="{{__('Add URL')}}" class="btn">
                        {{__('Add URL')}}
                    </a>
                </div>
            </div>

            @include('partials/messages')
        </div>
    </main>
@endsection
