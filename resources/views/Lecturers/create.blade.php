@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
@endsection

@section('content')
    <h3></i>CREATE LECTURER</h3>
    <div class="row mt">
        <div class="col-lg-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">CREATE LECTURER</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('lecturers.store') }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="form-group clearfix">
                            <label for="email" class="col-sm-2 control-label required">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="password" class="col-sm-2 control-label required">Password (min: 8)</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <span class="help-text">Please write down password</span>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="password_confirmation" class="col-sm-2 control-label required">Confirm Password</label>
                            <div class="col-sm-6">
                                <input type="password_confirmation" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="title" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Eg. Dr.">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="first_name" class="col-sm-2 control-label required">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="middle_name" class="col-sm-2 control-label">Middle Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="last_name" class="col-sm-2 control-label required">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label for="department" class="col-sm-2 control-label required">Departments</label>
                            <div class="col-sm-6">
                                <select id="department" name="department" class="form-control" required>
                                    <option value="">Choose a Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group clearfix">
                            <label for="courses" class="col-sm-2 control-label required">Courses</label>
                            <div class="col-sm-6">
                                <select id="courses" name="courses[]" class="form-control" multiple="multiple">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
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
