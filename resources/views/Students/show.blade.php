@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>{{ strtoupper($student->name) }}</h3>
    <h4>{{ strtoupper($student->department->name) }}</h4>
    <div class="row mt">
        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">COURSES REGISTERED</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('courses.show', [$course]) }}">{{ $course->title }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SUBMITTED ANSWERS</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Assignment</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->answers as $answer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $answer->assignment->title }}</td>
                                    <td>{{ $answer->assignment->course->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')

@endsection
