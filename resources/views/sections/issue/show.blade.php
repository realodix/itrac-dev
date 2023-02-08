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
                                <div class="flex justify-end flex-wrap content-center">
                                    @if ($comment->isIssueAuthor())
                                        <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">
                                            {{$comment->userRole()}}</span>
                                    @endif

                                    @if ($comment->isAuthor() || auth()->user()->hasRole('admin'))
                                        <x-comment-action>
                                            <x-comment-action-item>
                                                <a href="{{route('comment.edit', $comment)}}">Edit</a>
                                            </x-comment-action-item>
                                            <x-comment-action-item>
                                                <a href="{{route('comment.delete', $comment)}}">
                                                    <span class="text-red-600">Delete</span></a>
                                            </x-comment-action-item>
                                        </x-comment-action>
                                    @endif

                                </div>
                            @endauth
                        </div>
                        <x-markdown class="comment-body markdown">{!! $comment->description !!}</x-markdown>
                    </div>
                @endforeach

                {{-- https://tailwind-elements.com/docs/standard/components/timeline/ --}}
                <h3 class="text-2xl text-gray-700 font-bold mb-6 -ml-3">Latest News</h3>
                <ol class="border-l-2 border-purple-600">
                    <li>
                        <div class="md:flex flex-start">
                        <div class="bg-purple-600 w-6 h-6 flex items-center justify-center rounded-full -ml-3">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" class="text-white w-3 h-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h288c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-64zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"></path>
                            </svg>
                        </div>
                        <div class="block  ml-6 mb-10">
                            hello
                        </div>
                        </div>
                    </li>
                    <li>
                        <div class="md:flex flex-start">
                        <div class="bg-purple-600 w-6 h-6 flex items-center justify-center rounded-full -ml-3">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" class="text-white w-3 h-3" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm64-192c0-8.8 7.2-16 16-16h288c8.8 0 16 7.2 16 16v64c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16v-64zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"></path>
                            </svg>
                        </div>
                        <div class="block p-6 rounded-lg shadow-lg bg-gray-100 max-w-md ml-6 mb-10">
                            <div class="flex justify-between mb-4">
                            <a href="#!" class="font-medium text-purple-600 hover:text-purple-700 focus:text-purple-800 duration-300 transition ease-in-out text-sm">21 000 Job Seekers</a>
                            <a href="#!" class="font-medium text-purple-600 hover:text-purple-700 focus:text-purple-800 duration-300 transition ease-in-out text-sm">12 / 01 / 2022</a>
                            </div>
                            <p class="text-gray-700 mb-6">Libero expedita explicabo eius fugiat quia aspernatur autem laudantium error architecto recusandae natus sapiente sit nam eaque, consectetur porro molestiae ipsam an deleniti.</p>
                            <button type="button" class="inline-block px-4 py-1.5 bg-purple-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out" data-mdb-ripple="true">Preview</button>
                            <button type="button" class="inline-block px-3.5 py-1 border-2 border-purple-600 text-purple-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out" data-mdb-ripple="true">See demo</button>
                        </div>
                        </div>
                    </li>
                </ol>

                {{-- https://flowbite.com/docs/components/timeline/#vertical-timeline --}}
                <ol class="relative border-l border-gray-200 dark:border-gray-700">
                    <li class="mb-10 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </span>
                        <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">Flowbite Application UI v2.0.0 <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ml-3">Latest</span></h3>
                        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Released on January 13th, 2022</time>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Get access to over 20+ pages including a dashboard layout, charts, kanban board, calendar, and pre-order E-commerce & Marketing pages.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"><svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg> Download ZIP</a>
                    </li>
                    <li class="mb-10 ml-6">
                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                            <svg aria-hidden="true" class="w-3 h-3 text-blue-800 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </span>
                        <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Flowbite Figma v1.3.0</h3>
                        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">Released on December 7th, 2021</time>
                        <p class="text-base font-normal text-gray-500 dark:text-gray-400">All of the pages and components are first designed in Figma and we keep a parity between the two versions even as we update the project.</p>
                    </li>
                </ol>


                <br>

                @if (auth()->check())
                    @if ($issue->isLocked() && ! $issue->isAuthor() && ! $issue->isParticipant() && ! auth()->user()->hasRole('admin'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <x-go-lock-16 />

                            <b>{{$issue->lockedBy->name}}</b> locked this issue and limited conversations to collaborators {{$issue->locked_at->diffForHumans()}}.
                        </div>
                    @else
                        <form method="post" action="{{ route('comment.store', $issue->id) }}">
                        @csrf
                            <x-easymde name="comment_description" placeholder="Leave a comment" required/>

                            <div class="flex justify-end mt-2">
                                <button
                                    class="px-4 py-2 rounded-lg w-full flex items-center justify-center sm:w-auto
                                        text-white font-semibold bg-slate-900 hover:bg-slate-700
                                        focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50"
                                    >Submit</button>
                            </div>
                        </form>
                    @endif
                @else
                    You need to <a href="{{route('login')}}" class="text-blue-600">log in</a> before you can comment.
                @endif
            </div>
            <div class="md:w-4/12 px-4 py-2">
                <div class="participation discussion-sidebar-item">
                    <div class="mb-2">
                        @php
                            use Illuminate\Support\Str;
                            $participants = $issue->participantCount();
                        @endphp
                        {{$participants}} {{Str::plural('participant', $participants)}}
                    </div>
                    <div class="">
                        @foreach ($issue->participant()->get() as $participant)
                            <img src="{{ Avatar::create($participant->author->name)->toBase64() }}" class="inline-block w-7 h-7 mb-1" title="{{$participant->author->name}}"/>
                        @endforeach
                    </div>
                </div>
                @auth
                @if ($issue->isAuthor() || auth()->user()->hasRole('admin'))
                    <div class="participation discussion-sidebar-item text-sm">
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
                            <div class="mt-4">
                                @if ($issue->isClosed())
                                    <x-go-issue-reopened-16 />
                                    <a href="{{route('issue.reopen', $issue)}}" class="font-semibold">Reopen</a>
                                @else
                                    <x-go-issue-closed-16 />
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
