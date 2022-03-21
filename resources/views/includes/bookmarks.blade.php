<div class="row">
    <div class="col-xs-12 bookmarks-tab">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Topics</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Messages</a>
                {{--                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Comments</a>--}}
            </div>
        </nav>
        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
            <div class="tab-pane fade show active underline-text" style="margin-left: 2px;" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                @if(count( $topic_bookmarks) > 0)
                    @foreach( $topic_bookmarks as  $topic_bookmark)
                        @if(  $topic_bookmark->topic->user->username == $user->username)
                            <form method="post" action="{{ route(' topic.delete',  $topic_bookmark->topic->topic_id) }}" style="padding: 0">
                                @csrf
                                @method('delete')
                                <a href="{{ route(' topic.show.edit.form',  $topic_bookmark->topic->topic_id) }}" class="put-black"><i class="fa fa-edit"></i> edit</a>
                                <button class="btn" type="submit" style="padding: 0"><i class="fa fa-trash"></i>delete</button>
                            </form>
                        @endif
                        <a class="put-black" href="{{ route('site.single.topic', $topic_bookmark->topic->slug) }}">
                            {{ $topic_bookmark->topic->title }}
                        </a>
                        <br>
                        <span class="topic-text ml-2">
                        <i class="fa fa-clock-o"></i>
                        {{  $topic_bookmark->topic->created_at }}
                            @if( $topic_bookmark->topic->likes > 0)
                                <i class="fa fa-thumbs-up"></i>
                                {{  $topic_bookmark->topic->likes }}
                            @else
                            @endif
                        </span>

                        <hr>

                    @endforeach
                    <div class="d-flex justify-content-center paginate-desktop">
                        {{  $topic_bookmarks->links() }}
                    </div>

                    <div class="d-flex justify-content-center paginate-mobile">
                        {{  $topic_bookmarks->links('pagination.custom_pagination') }}
                    </div>
                @else
                    @include('includes.alert')
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Sorry..you don't have any bookmarked thread  topics
                        </div>
                    </div>
                @endif
            </div>

            <div class="tab-pane fade underline-text" style="margin-left: 2px;" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                @if(count( $message_bookmarks) > 0)
                    @foreach( $message_bookmarks as  $message_bookmark)
                        @if( $message_bookmark->message->user->username == $user->username)
                            <form method="post" action="{{ route('message.delete',  $message_bookmark->message->message_id) }}" style="padding: 0">
                                @csrf
                                @method('delete')
                                <a href="{{ route('message.show.edit.form',  $message_bookmark->message->message_id) }}" class="put-black"><i class="fa fa-edit"></i> edit</a>
                                <button class="btn" type="submit" style="padding: 0"><i class="fa fa-trash"></i>delete</button>
                            </form>
                        @endif
                        <a style="padding-bottom: 0" href="{{ route('site.single.message',$message_bookmark->message->message_id) }}">
                            {!!  $message_bookmark->message->body !!}
                        </a>
                        <br/>
                        <span class="topic-text">
                        <i class="fa fa-clock-o"></i>
                        {{  $message_bookmark->message->created_at }}
                            @if( $message_bookmark->message->likes > 0)
                                <i class="fa fa-thumbs-up"></i>
                                {{  $message_bookmark->message->likes }}
                            @else
                            @endif
                        </span>

                        <hr>

                    @endforeach
                    <div class="d-flex justify-content-center paginate-desktop">
                        {{  $message_bookmarks->links() }}
                    </div>

                    <div class="d-flex justify-content-center paginate-mobile">
                        {{  $message_bookmarks->links('pagination.custom_pagination') }}
                    </div>
                @else
                    @include('includes.alert')
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Sorry..you don't have any bookmarked thread messages
                        </div>
                    </div>
                @endif

            </div>
            {{--            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">--}}
            {{--                Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.--}}
            {{--            </div>--}}
        </div>

    </div>
</div>
