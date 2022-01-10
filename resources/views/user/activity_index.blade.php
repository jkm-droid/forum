@extends('base.index')
@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Activities</li>
        </ol>
    </nav>
    <h5>Activity Log</h5>
    @if(count($activities) > 0)
        @foreach($activities as $activity)
            <p>
                {{ $activity->created_at }} :
                {{ $activity->activity_body }}
            </p>
        @endforeach
    @else
        @include('partials.alert')

        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
                Oops! No activity logs found
            </div>
        </div>
    @endif
@endsection
