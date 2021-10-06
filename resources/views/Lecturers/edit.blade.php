@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
@endsection

@section('content')
    <h3></i>EDIT LECTURER</h3>
    <div class="row mt">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">EDIT LECTURER</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('lecturers.update', [$lecturer->id]) }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group clearfix">
                            <label for="title" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Eg. Dr." value="{{ $lecturer->title }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="first_name" class="col-sm-2 control-label required">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required value="{{ $lecturer->first_name }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="middle_name" class="col-sm-2 control-label">Middle Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" value="{{ $lecturer->middle_name }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="last_name" class="col-sm-2 control-label required">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required value="{{ $lecturer->last_name }}">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="account_type" class="col-sm-2 control-label required">Account Type</label>
                            <div class="col-sm-6">
                                <select id="account_type" name="account_type" class="form-control" required>
                                    <option value="1" @if ($lecturer->user->account_type == 1) selected="selected" @endif>Admin</option>
                                    <option value="2" @if ($lecturer->user->account_type == 2) selected="selected" @endif>Lecturer</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="department" class="col-sm-2 control-label required">Departments</label>
                            <div class="col-sm-6">
                                <select id="department" name="department" class="form-control" required>
                                    <option value="">Choose a Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            @if ($lecturer->department_id == $department->id)
                                                selected="selected"
                                            @endif
                                        >{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group clearfix">
                            <label for="courses" class="col-sm-2 control-label required">Courses</label>
                            <div class="col-sm-6">
                                <select id="courses" name="courses[]" class="form-control" multiple="multiple">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            @if ($course->selected == true)
                                                selected="selected"
                                            @endif
                                        >{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
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
<script src="/js/select2.min.js"></script>
<script>
    {{-- $('#lecturers').select2(); --}}
</script>
@endsection
