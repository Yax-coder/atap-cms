@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>{{ strtoupper($course->title) }}</h3>
    <h3>{{ strtoupper($course->code) }}</h3>
    <div class="row mt">
        <div class="col-md-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">ASSIGNMENTS</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Date Due</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course->assignments as $assignment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('assignments.show', [$assignment]) }}">{{ $assignment->title }}</a></td>
                                    <td>{{ $assignment->due_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if (Auth::user()->account_type == 1 || Auth::user()->account_type == 2)
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">STUDENTS</h3>
                </div>
                <div class="panel-body">
                    @foreach ($course->students as $student)
                        <span class="mr-3"><a href="{{ route('students.show', [$student]) }}">{{ $student->first_name .' '. $student->last_name }}</a></span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">LECTURERS</h3>
                </div>
                <div class="panel-body">
                    @foreach ($course->lecturers as $lecturer)
                        <p>{{ $loop->iteration }}. <a href="{{ route('lecturers.show', [$lecturer]) }}">{{ $lecturer->first_name .' '. $lecturer->last_name }}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')

@endsection
