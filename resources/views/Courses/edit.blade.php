@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="/lineicons/style.css">
    <script src="/js/chart-master/Chart.js"></script>
@endsection

@section('content')
    <h3></i>EDIT COURSE</h3>
    <div class="row mt">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">EDIT COURSE</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('courses.update', [$course->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group clearfix">
                            <label for="name" class="col-sm-2 control-label">Course Title</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="title" placeholder="Course Title" required value="{{ $course->title }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="code" class="col-sm-2 control-label">Course Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="code" name="code" placeholder="Course Code" required value="{{ $course->code }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="lecturers" class="col-sm-2 control-label">Lecturers</label>
                            <div class="col-sm-6">
                                <select id="lecturers" name="lecturers[]" class="form-control" multiple="multiple">
                                    @foreach ($lecturers as $lecturer)
                                        <option value="{{ $lecturer->id }}"
                                            @if ($lecturer->selected == true)
                                                selected="selected"
                                            @endif>
                                        {{ $lecturer->first_name .' '. $lecturer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-offset-2 col-sm-6">
                                <input type="submit" class="btn btn-success btn-lg" value="Submit">
                            </div>
                        </div>
                        <!-- <div class="form-group col-lg-4 col-md-4 col-sm-4">
                            <select class="form-control col-lg-4 col-md-4 col-sm-4">
                                <option selected>Courses Under Dept.</option>
                                <option value="1">Accountancy</option>
                                <option value="2">Agricultural Technology</option>
                                <option value="3">Animal Health And Production Technology</option>
                                <option value="3">Banking And Finance</option>
                                <option value="3">Building Technology</option>
                                <option value="3">Business Administration and Management</option>
                                <option value="3">Computer Science</option>
                                <option value="3">Electrical / Electronic Engineering</option>
                                <option value="3">Estate Mangement And Valuation</option>
                                <option value="3">Fisheries Technology</option>
                                <option value="3">Forestry Technology</option>
                                <option value="3">Mechanical Engineering Technology</option>
                                <option value="3">Public Administration</option>

                            </select>
                        </div> -->

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection


@section('scripts')
<script src="/js/select2.full.min.js"></script>
<script>
    {{-- $('#lecturers').select2(); --}}
</script>
@endsection
