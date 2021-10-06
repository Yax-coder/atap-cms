@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3></i>Assignments</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4>Assignments
                        <a href="{{ route('assignments.create') }}" class="btn btn-primary btn-sm pull-right mr-3">New</a>
                    @if (Auth::user()->account_type == 1)
                        <a href="{{ route('assignments.index') }}" class="btn btn-info btn-sm pull-right mr-3">My Assignments</a>
                        <a href="{{ route('assignments.index', ['view_as'=>'admin']) }}" class="btn btn-info btn-sm pull-right mr-3">All Assignments</a>
                    @endif
                </h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class=" fa fa-book"></i>Course Code</th>
                            <th><i class=" fa fa-book"></i>Title</th>
                            <th><i class=" fa fa-book"></i>Submitted</th>
                            <th><i class=" fa fa-book"></i>Date Due</th>
                            <th><i class=" fa fa-edit"></i>Published At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assignment->course->code }}</td>
                            <td><a href="{{ route('assignments.show', [$assignment]) }}">{{ $assignment->title }}</a></td>
                            <td>{{ $assignment->answers->count() .'/'. $assignment->course->students->count() }}</td>
                            <td>{{ $assignment->due_at }}</td>
                            <td>{{ $assignment->published_at }}</td>
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
