@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3 class="mb-2">DEPARTMENTS</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4>List of Depatments
                    <a href="{{ route('departments.create') }}" class="btn btn-primary pull-right mr-3" style="margin-right:1rem;">New</a>
                </h4>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Lecturers</th>
                            <th>Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->lecturers_count }}</td>
                            <td>{{ $department->students_count }}</td>
                            <td>
                                <a href="{{ route('departments.show', [$department]) }}" class="btn btn-info btn-xs">View</a>
                                <a href="{{ route('departments.edit', [$department]) }}" class="btn btn-warning btn-xs">Edit</a>
                                <button class="btn btn-danger btn-xs btn-delete" data-delete-url="departments/{{ $department->id }}">Delete</button>
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
