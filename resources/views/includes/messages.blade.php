@if(count($messages) > 0)
    @foreach($messages as $message)

        <form method="post" action="{{ route('message.delete', $message->id) }}" style="padding: 0">
            @csrf
            @method('delete')
            <a href="{{ route('message.edit.form', $message->id) }}" class="put-black"><i class="fa fa-edit"></i> edit</a>
            <button class="btn" type="submit" style="padding: 0"><i class="fa fa-trash"></i>delete</button>
        </form>
        {!! $message->body !!}
        <br>
        <span class="topic-text">
            <i class="fa fa-clock-o"></i>
            {{ $message->created_at }}
            <i class="fa fa-thumbs-up"></i>
            {{ $message->likes }}
        </span>
        <hr>
    @endforeach
@else
    @include('includes.alert')
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
            Sorry..you don't have any thread messages
        </div>
    </div>
@endif
