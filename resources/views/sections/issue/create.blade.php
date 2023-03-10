@extends('layouts.layout')

@section('css_class', 'frontend home')

@section('content')
<div class="max-w-7xl mx-auto sm:pt-10 mb-12">
    <div class="issue_bucket flex">
        <div class="md:w-8/12 justify-between">
            <form method="post" action="{{ route('issue.create') }}">
            @csrf
                <input name="issue_title" placeholder="Title" class="form-input"/>
                <br>
                <x-easymde name="issue_description" placeholder="Leave a comment"/>

                <div class="flex justify-end mt-2">
                    <button
                        class="px-4 py-2 rounded-lg w-full flex items-center justify-center sm:w-auto
                            text-white font-semibold bg-slate-900 hover:bg-slate-700
                            focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50"
                        >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
