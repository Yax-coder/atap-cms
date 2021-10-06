@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>{{ strtoupper($assignment->title) }}</h3>
    <div class="row mt">
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">ASSIGNMENTS</h3>
                </div>
                <div class="panel-body">
                    <h4>{{ strtoupper($assignment->course->title) }}</h4>
                    <p>{{ strtoupper($assignment->course->code) }}</p>
                    <p><b>Instruction: </b>{{ strtoupper($assignment->extra) }}</p>
                    <p><b>Published At: </b>{{ strtoupper($assignment->published_at) }}</p>
                    <p><b>Due At: </b>{{ strtoupper($assignment->due_at) }}</p>
                    @if (Auth::user()->account_type == 3)
                        @if($assignment->answer)
                            <span class="label label-success">Submitted</span>
                        @else
                            <span class="label label-warning">Not Submitted</span>
                        @endif
                    @endif
                    <p><a href="{{ url('/assignment/download/'.$assignment->id) }}" class="btn btn-success btn-lg mt-3">Download</a></p>
                </div>
            </div>
        </div>

        @if (Auth::user()->account_type == 1 || Auth::user()->account_type == 2)
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SUBMITTED ANSWERS</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignment->answers as $answer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $answer->student->name }}</td>
                                    <td>{{ $answer->score }}</td>
                                    <td><a href="{{ url('/assignment/answer/'.$answer->id) }}" class="btn btn-primary btn-xs">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @if (Auth::user()->account_type == 3)
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SUBMIT</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ url('/assignment/submit/'.$assignment->id) }}" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" class="form-control" id="assignment" name="assignment" placeholder="File" required value="{{ $assignment->id }}">
                        <div class="form-group clearfix">
                            <label for="title" class="col-sm-2 control-label required">Assignment</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" placeholder="File" required value="{{ $assignment->title }}" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="upload_file" class="col-sm-2 control-label required">File</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="upload_file" name="upload_file" placeholder="File" required>
                                <span class="hep-text">Only .pdf, .doc, .docx Allowed</span>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="extra" class="col-sm-2 control-label">Extra</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="extra" name="extra" rows="5" placeholder="Instructions"></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-success btn-lg" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')

@endsection
