@extends('layouts.admin')

@section('title', __('All Users'))

@section('content')
<main>
    <div class="common-card-style p-4 bg-white">
        <div class="text-2xl text-uh-1 mb-8">
            <span>{{__('All Users')}}</span>
        </div>

        @livewire('table.user-table')
    </div>
</main>
@endsection
