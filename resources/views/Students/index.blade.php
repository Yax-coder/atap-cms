@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3></i>Students</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4></i>List of Students</h4>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></i>Name</th>
                            <th></i>Matric No.</th>
                            <th></i>Department</th>
                            <th></i>Courses</th>
                            @if (Auth::user()->account_type == 1)
                                <th style="min-width:150px;">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->matric_no }}</td>
                            <td>{{ $student->department->name }}</td>
                            <td>{{ $student->courses->count() }}</td>
                            @if (Auth::user()->account_type == 1)
                            <td>
                                <a href="{{ route('students.show', [$student]) }}" class="btn btn-info btn-xs">View</a>
                                <a href="{{ route('students.edit', [$student]) }}" class="btn btn-warning btn-xs">Edit</a>
                                <button class="btn btn-danger btn-xs btn-delete" data-delete-url="students/{{ $student->id }}">Delete</button>
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
