@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>
    <!--End Page Heading -->

    <div class="card">
        <div class="card-header">
            <a class="btn btn-info btn-sm" >{{ $categoryCount }} Categories</a>
            <a class="btn btn-primary btn-sm" href="{{ route('show.category.create') }}">Add New</a>
        </div>

        <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Forum</th>
                <th>No. Topics</th>
                <th>No. Messages</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $f++ }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->forumlist->title }}</td>
                    <td>{{ \App\Models\Category::thousandsCurrencyFormat($category->topics->count()) }}</td>
                    <td>{{ \App\Models\Category::thousandsCurrencyFormat($category->messages->count()) }}</td>
                    <td>
                        @if($category->status == 1)
                            <span class="badge badge-success ">Published</span>
                        @else
                            <span class="badge badge-danger">Draft</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('category.delete', $category->id) }}">
                            <a class="btn btn-sm btn-info" href="{{ route('category.view', $category->id) }}">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn btn-sm btn-primary" href="{{ route('show.category.edit', $category->id) }}">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($category->status == 1)
                            <form action="{{ route('category.publish.draft', $category->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>Draft
                                </button>
                            </form>
                        @else
                            <form action="{{ route('category.publish.draft', $category->id) }}" method="post">
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

        {{ $categories->links() }}
    </div>
@endsection
