@if (auth()->check())
    @if ($issue->isLocked() && ! $issue->isAuthor() && ! $issue->isParticipant() && ! auth()->user()->hasRole('admin'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <x-go-lock-16 />

            <b>{{$issue->lockedBy->name}}</b> locked this issue and limited conversations to collaborators {{$issue->locked_at->diffForHumans()}}.
        </div>
    @else
        <form method="post" action="{{ route('comment.store', $issue->id) }}">
        @csrf
            <x-easymde name="comment_summary" placeholder="Leave a comment" required/>

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
