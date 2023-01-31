@extends('layouts.frontend')

@section('css_class', 'frontend home')

@section('content')
    <div class="max-w-7xl mx-auto sm:pt-10 mb-12">
        <div class="issue_bucket flex">
            <div class="md:w-8/12 justify-between">
                <x-form action="{{ route('issue.create') }}">
                @csrf
                    <x-input name="issue_title" class="form-input" required/>
                    <br>
                    <x-easy-mde name="issue_description" required/>

                    <x-form-button
                        class="bg-slate-900 hover:bg-slate-700 dark:bg-sky-500 dark:highlight-white/20 dark:hover:bg-sky-400
                            focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50
                            text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto "
                    >
                        Submit
                    </x-form-button>
                </x-form>
            </div>
        </div>
    </div>
@endsection
