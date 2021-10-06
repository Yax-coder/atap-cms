@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>USERS</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>USER ID</th>
                            <th>Email</th>
                            <th>Account Type</th>
                            @if (Auth::user()->account_type == 1)
                                <th style="min-width:150px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->account_type == 1)
                                    ADMINISTRATOR
                                @elseif ($user->account_type == 2)
                                    LECTURER
                                @else
                                    STUDENT
                                @endif
                            </td>
                            @if (Auth::user()->account_type == 1)
                            <td>
                                <a href="{{ url($user->url) }}" class="btn btn-info btn-xs">View</a>
                                <a href="{{ url('/administration/users/'.$user->id.'/edit') }}" class="btn btn-warning btn-xs">EDIT USER INFO</a>
                                {{-- <button class="btn btn-danger btn-xs btn-delete" data-delete-url="users/{{ $lecturer->id }}">Delete</button> --}}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><! --/content-panel -->
        </div><!-- /col-md-12 -->
    </div><!-- row -->
@endsection

@section('modal')

@endsection


@section('scripts')

@endsection
