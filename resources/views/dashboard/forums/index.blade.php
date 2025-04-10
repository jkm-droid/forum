@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Forums</li>
        </ol>
    </nav>
    <!--End Page Heading -->

    <div class="card">
        @if(count($forums) > 0)
            <div class="card-header">
                <a class="btn btn-info btn-sm">{{ $no_forums }} Forums</a>
                <a class="btn btn-primary btn-sm" href="{{ route('show.forum.create') }}">Add New</a>
            </div>

            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>No. Categories</th>
                        <th>No. Topics</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forums as $forum)
                        <tr>
                            <td>{{ $f++ }}</td>
                            <td>{{ $forum->title }}</td>
                            <td>{{ $forum->description }}</td>
                            <td>{{ $forum->categories->count() }}</td>
                            <td>{{ $forum->topics->count() }}</td>
                            <td>
                                @if($forum->status == 1)
                                    <span class="badge badge-success ">Published</span>
                                @else
                                    <span class="badge badge-danger">Draft</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('forum.delete', $forum->id) }}">
                                    <a class="btn btn-sm btn-info" href="{{ route('forum.view', $forum->id) }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-primary" href="{{ route('show.forum.edit', $forum->id) }}">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($forum->status == 1)
                                    <form action="{{ route('forum.publish.draft', $forum->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-times"></i>Draft
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('forum.publish.draft', $forum->id) }}" method="post">
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
            </div>
        @else
            <p class="text-center text-danger">No forums found</p>
        @endif
    </div>
@endsection
