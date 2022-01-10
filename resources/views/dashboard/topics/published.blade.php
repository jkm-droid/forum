@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Topics</li>
            <li class="breadcrumb-item active" aria-current="page">Published ({{ $publishes }})</li>
        </ol>
    </nav>
    <!--End Page Heading -->

    <h5>Published Topics</h5>
    @if(count($topics) > 0)

        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Body</th>
                <th>Category</th>
                <th>No. Messages</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($topics as $topic)
                <tr>
                    <td>{{ $f++ }}</td>
                    <td>{{ $topic->title }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $topic->id }}">
                            <i class="fa fa-eye"></i>Body
                        </button>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop-{{ $topic->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">{{ $topic->title }}</h5>
                                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times-circle text-danger"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ $topic->body }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    @if($topic->status == 1)
                                        <form action="{{ route('topic.publish.draft', $topic->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>Draft
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('topic.publish.draft', $topic->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fa fa-check"></i>Publish
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
                    <td>{{ $topic->category->title }}</td>
                    <td>{{ $topic->messages->count() }}</td>
                    <td>
                        @if($topic->status == 1)
                            <span class="badge badge-success ">Published</span>
                        @else
                            <span class="badge badge-danger">Draft</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('topic.delete', $topic->id) }}">
                            <a class="btn btn-sm btn-info" href="{{ route('topic.view', $topic->id) }}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('show.topic.edit', $topic->id) }}">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($topic->status == 1)
                            <form action="{{ route('topic.publish.draft', $topic->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>Draft
                                </button>
                            </form>
                        @else
                            <form action="{{ route('topic.publish.draft', $topic->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fa fa-check"></i>Publish
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $topics->links() }}
    @else
        @include('admin_partials.alert')
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
                Oops! No published categories were found
            </div>
        </div>
    @endif

@endsection
