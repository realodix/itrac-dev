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
                                <a href="{{route('issue.edit', $issue)}}" class="comment-header-btn">Edit</a>
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
                            @if ($comment->isAuthor() || auth()->user()->hasRole('admin'))
                                <div class="flex justify-end flex-wrap content-center">
                                    @if ($comment->isAuthor())
                                        <span class="bg-green-100 text-green-800 text-xs mr-2 px-2.5 py-0.5 rounded border border-green-400">
                                            {{$comment->userRole()}}</span>
                                    @endif
                                    <div
                                        x-data="{
                                            open: false,
                                            toggle() {
                                                if (this.open) {
                                                    return this.close()
                                                }

                                                this.$refs.button.focus()

                                                this.open = true
                                            },
                                            close(focusAfter) {
                                                if (! this.open) return

                                                this.open = false

                                                focusAfter && focusAfter.focus()
                                            }
                                        }"
                                        x-on:keydown.escape.prevent.stop="close($refs.button)"
                                        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
                                        x-id="['dropdown-button']"
                                        class="relative"
                                    >
                                        <!-- Button -->
                                        <button
                                            x-ref="button"
                                            x-on:click="toggle()"
                                            :aria-expanded="open"
                                            :aria-controls="$id('dropdown-button')"
                                            type="button"
                                            {{-- class="flex items-center gap-2 bg-white px-5 py-2.5 rounded-md shadow" --}}
                                        >
                                            <svg class="blade-icon" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.444 13.832a1 1 0 1 0 1.111-1.663 1 1 0 0 0-1.11 1.662zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0-5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path></svg>
                                        </button>

                                        <!-- Panel -->
                                        <div
                                            x-ref="panel"
                                            x-show="open"
                                            x-transition.origin.top.left
                                            x-on:click.outside="close($refs.button)"
                                            :id="$id('dropdown-button')"
                                            style="display: none;"
                                            class="absolute left-0 mt-2 w-40 rounded-md bg-white shadow-md"
                                        >
                                            <a href="{{route('comment.edit', $comment)}}"
                                                class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500"
                                                >Edit</a>
                                            <a href="{{route('comment.delete', $comment)}}"
                                                class="flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 disabled:text-gray-500"
                                                ><span class="text-red-600">Delete</span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @endauth
                        </div>
                        <x-markdown class="comment-body markdown">{!! $comment->description !!}</x-markdown>
                    </div>
                @endforeach

                <br>

                @if (auth()->check())
                    <form method="post" action="{{ route('comment.store', $issue->id) }}">
                    @csrf
                        <x-easymde name="comment_description" placeholder="Leave a comment"/>

                        <div class="flex justify-end mt-2">
                            <button
                                class="px-4 py-2 rounded-lg w-full flex items-center justify-center sm:w-auto
                                    text-white font-semibold bg-slate-900 hover:bg-slate-700
                                    focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50"
                                >Submit</button>
                        </div>
                    </form>
                @else
                    You need to <a href="{{route('login')}}" class="text-blue-600">log in</a> before you can comment.
                @endif
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
                            <div class="flex flex-col">
                                <div>
                                    @if ($issue->isClosed())
                                        <x-go-issue-reopened-16 class="text-green-600" />
                                        <a href="{{route('issue.reopen', $issue)}}" class="font-semibold">Reopen</a>
                                    @else
                                        <x-go-issue-closed-16 class="text-violet-700" />
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
