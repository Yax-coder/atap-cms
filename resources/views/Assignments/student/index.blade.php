@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3><i class="fa fa-angle-right"></i>Assignments</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4><i class="fa fa-angle-right"></i>List of Assignments</h4>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class=" fa fa-book"></i>Course Code</th>
                            <th><i class=" fa fa-book"></i>Title</th>
                            <th><i class=" fa fa-book"></i>Date Due</th>
                            <th><i class=" fa fa-edit"></i>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assignment->course->code }}</td>
                            <td><a href="{{ route('assignments.show', [$assignment]) }}">{{ $assignment->title }}</a></td>
                            <td>{{ $assignment->due_at->format('d/m/Y h:i A') }}</td>
                            <td>
                                @if($assignment->answer)
                                    <span class="label label-success">Submitted</span>
                                @else
                                    <span class="label label-danger">Not Submitted</span>
                                @endif
                            </td>
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
