@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3>{{ strtoupper($answer->assignment->title) }}</h3>
    <div class="row mt">
        <div class="col-md-6">
            @if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2)
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">ANSWER</h3>
                </div>
                <div class="panel-body">
                        <h4>{{ strtoupper($answer->student->name) }}</h4>
                        <p><b>Submitted At: </b>{{ strtoupper($answer->submitted_at) }}</p>
                        <p><b>Extra: </b>{{ strtoupper($answer->extra) }}</p>
                        <p><a href="{{ url('/answer/download/'.$answer->id) }}" class="btn btn-success btn-lg mt-3">Download ANSWER</a></p>
                </div>
            </div>
            @endif
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">QUESTION</h3>
                </div>
                <div class="panel-body">
                    <h4>{{ strtoupper($answer->assignment->course->title) }}</h4>
                    <p>{{ strtoupper($answer->assignment->course->code) }}</p>
                    <p><b>Instruction: </b>{{ strtoupper($answer->assignment->extra) }}</p>
                    <p><b>Published At: </b>{{ strtoupper($answer->assignment->published_at) }}</p>
                    <p><b>Due At: </b>{{ strtoupper($answer->assignment->due_at) }}</p>
                    @if (Auth::user()->account_type == 3)
                        @if($assignment->answer)
                            <span class="label label-success">Submitted</span>
                        @else
                            <span class="label label-warning">Not Submitted</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        @if (Auth::user()->account_type == 1 || Auth::user()->account_type == 2)
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SCORE</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ url('/assignment/score/') }}" method="POST"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group clearfix">
                            <input type="hidden" class="form-control" id="answer" name="answer" placeholder="Score" required value="{{ $answer->id }}">
                            <label for="score" class="col-sm-2 control-label required">Score</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="score" name="score" placeholder="Score" required value="{{ $answer->score }}">
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

        @if (Auth::user()->account_type == 3)
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">SUBMIT</h3>
                </div>
                <div class="panel-body">
                    <h2>Score: {{ $answer->score }}</h2>
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
