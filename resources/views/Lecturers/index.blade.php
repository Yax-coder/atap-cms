@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>Lecturers</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4>List of Lecturers
                    <a href="{{ route('lecturers.create') }}" class="btn btn-primary btn-sm pull-right">New</a>
                </h4>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class=" fa fa-book"></i>Name</th>
                            <th><i class=" fa fa-book"></i>Department</th>
                            <th><i class=" fa fa-edit"></i>Courses</th>
                            @if (Auth::user()->account_type == 1)
                                <th style="min-width:150px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lecturers as $lecturer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lecturer->name }}</td>
                            <td>{{ $lecturer->department->name }}</td>
                            <td>
                                @foreach($lecturer->courses as $course)
                                    {{ $course->code }}
                                    @if(!$loop->last)
                                    , 
                                    @endif
                                @endforeach
                            </td>
                            @if (Auth::user()->account_type == 1)
                            <td>
                                <a href="{{ route('lecturers.show', [$lecturer]) }}" class="btn btn-info btn-xs">View</a>
                                <a href="{{ route('lecturers.edit', [$lecturer]) }}" class="btn btn-warning btn-xs">Edit</a>
                                <button class="btn btn-danger btn-xs btn-delete" data-delete-url="lecturers/{{ $lecturer->id }}">Delete</button>
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
