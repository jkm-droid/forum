@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Categories</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
    </nav>
    <h5> {{ $category->title }}</h5>
    <div class="col-md-12">
        @if(count($category_topics) <= 0)
            <p class="text-center text-danger">No published topics under this category</p>
        @else

                @foreach($category_topics as $topic)
                    <div class="row col-md-12">
                        <div class="col-md-8">
                            <img style="float: left; margin-right: 10px;" src="/profile_pictures/{{ $topic->user->profile_url }}"
                                 alt="" width="60" height="60">

                            <h6 class="latest-topic-content">
                                <a class="put-black" id="{{ $topic->id }}" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
                            </h6>


                            <h6 class="latest-topic-content text-secondary" style="padding: 0 0 0 0;">
                                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                   data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                        Joined: {{ $topic->user->joined_date  }}
                                    Level: {{ $topic->user->level  }}
                                    Messages: {{ $topic->where('author', $topic->author)->count() }}
                                    ">
                                    <strong class="topic-text">{{ $topic->author }}</strong>
                                </a>
                                <span style="margin-left: 5px;" class="topic-text"> {{  \Carbon\Carbon::parse($topic->created_at)->format('j M, y') }}</span>

                                <span style="padding: 0 0 0 2px" class="btn topic-text">
                                    <span class="disappear-item"><i class="fa fa-thumbs-up ml-2"></i>
                                        {{ \App\Models\Category::thousandsCurrencyFormat($topic->messages->sum('likes') )}}
                                        </span>
                                     <span class="show-on-mobile"><i class="fa fa-eye ml-2"></i> {{ $topic->views }}</span>
                                    <i class="fa fa-comments ml-2"></i> {{ $topic->messages->count() }}
                                </span>

                            </h6>
                            @if($topic->tags->count() > 0)
                                <span class="latest-topic-content" style="margin-left: 20px;">
                                @foreach($topic->tags as $topic_tag)
                                        <span class="badge bg-success" style="padding: 3px">{{ $topic_tag->title }}</span>
                                    @endforeach
                                </span>
                            @endif

                            @if(\Illuminate\Support\Facades\Auth::check())
                                @if($user->username == $topic->author)
                                    <div class="user-actions">
                                        <a href="{{ route('topic.show.edit.form', $topic->slug) }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <button id="delete-topic" data-id="{{ $topic->id }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this topic">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="col-md-2 text-start disappear-item">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <h6>Messages: </h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        <h6><strong>{{ $topic->messages->count() }}</strong></h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Views:</h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        <strong>{{ $topic->views }}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row col-md-2 disappear-item">
                            @foreach($topic->messages as $topic_message)
                                @if($loop->last)

                                    <div class="col-md-8 text-end">
                                        <button class="btn text-secondary" style="padding: 0; font-size: medium;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ \Carbon\Carbon::parse($topic_message->created_at)->format('j M, Y@H:m') }}">
                                            <small>{{ $topic_message->formatted_message_time }}</small>
                                        </button>
                                        <br>
                                        <a  class="text-secondary" style="padding: 0; font-size: medium;"  data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                            data-bs-placement="top" title="{{ $topic_message->author }}" data-bs-content="
                                            Joined: {{ $topic_message->user->joined_date  }}
                                            Level: {{ $topic_message->user->level  }}
                                            Messages: {{ $topic_message->where('author', $topic_message->author)->count() }}
                                            ">
                                            <strong><small> {{ $topic_message->author }}</small></strong>
                                        </a>
                                    </div>

                                    <div class="col-md-2 text-start">
                                        <img src="/profile_pictures/{{ $topic_message->user->profile_url }}"
                                             alt="" width="40" height="45">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                <hr style="color: #cec1c1;">
                @endforeach

        @endif
    </div>
@endsection
