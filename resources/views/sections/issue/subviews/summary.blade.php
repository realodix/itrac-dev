<div class="box mb-8 -ml-6">
    <div class="box-header">
        <div class="box-header-meta">
            <div class="!ml-0">
                <b>{{$issue->author->name}}</b>
                <span class="text-sm text-gray-500">
                    commented
                    <a href="#issue-{{$issue->id}}"
                        id="issue-{{$issue->id}}"
                        title="{{$issue->created_at->isoFormat('MMM DD, OY, hh:mm A zz')}}"
                        >{{$issue->created_at->diffForHumans()}}</a>
                </span>
            </div>
        </div>
    </div>

    <x-markdown class="box-body markdown">{!! $issue->description !!}</x-markdown>
</div>
