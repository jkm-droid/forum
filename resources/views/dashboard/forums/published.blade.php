@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item" >Forums</li>
            <li class="breadcrumb-item active" aria-current="page">Published</li>
        </ol>
    </nav>
    <!--End Page Heading -->

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

@endsection
