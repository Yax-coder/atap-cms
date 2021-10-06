@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <div class="row mt">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">EDIT DEPARTMENT</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('departments.update', [$department->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group clearfix">
                            <label for="name" class="col-sm-2 control-label">Department Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Department Name" value="{{ $department->name }}" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-offset-2 col-sm-6">
                                <input type="submit" class="btn btn-success btn-lg" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')

@endsection
