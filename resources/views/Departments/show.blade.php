@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>{{ strtoupper($department->name) }}</h3>
    <div class="row mt">
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">LECTURERS</h3>
                </div>
                <div class="panel-body">
                    @foreach ($department->lecturers as $lecturer)
                        <p>{{ $loop->iteration }}. <a href="#">{{ $lecturer->first_name .' '. $lecturer->last_name }}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">STUDENTS</h3>
                </div>
                <div class="panel-body">
                    @foreach ($department->students as $student)
                        <p>{{ $loop->iteration }}. <a href="#">{{ $student->first_name .' '. $student->last_name }}</a></p>
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
