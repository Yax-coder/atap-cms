@extends('_layouts.admin')

@section('title', 'Dashboard')

@section('styles')

@endsection

@section('content')
    <h3></i>Courses</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <h4>List of Courses
                    @if (Auth::user()->account_type == 1)
                        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm pull-right mr-3">New</a>
                        <a href="{{ route('courses.index') }}" class="btn btn-info btn-sm pull-right mr-3">My Courses</a>
                        <a href="{{ route('courses.index', ['view_as'=>'admin']) }}" class="btn btn-info btn-sm pull-right mr-3">All Courses</a>
                    @elseif(Auth::user()->account_type == 3)
                        <a href="{{ url('courses/register') }}" class="btn btn-info btn-sm pull-right mr-3">Register Courses</a>
                    @endif
                </h4>
                <hr>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Lecturers</th>
                            <th>Students</th>
                            @if (Auth::user()->account_type == 1)
                                <th style="min-width:150px;">Actions</th>
                            @endif
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->code }}</td>
                            <td><a href="{{ route('courses.show', [$course]) }}">{{ $course->title }}</a></td>
                            <td>
                                @foreach($course->lecturers as $lecturer)
                                    {{ $lecturer->name }}
                                    @if(!$loop->last)
                                    , 
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $course->students()->count() }}</td>
                            @if (Auth::user()->account_type == 1)
                            <td>
                                <a href="{{ route('courses.show', [$course]) }}" class="btn btn-info btn-xs">View</a>
                                <a href="{{ route('courses.edit', [$course]) }}" class="btn btn-warning btn-xs">Edit</a>
                                <button class="btn btn-danger btn-xs btn-delete" data-delete-url="courses/{{ $course->id }}">Delete</button>
                            </td>
                            @endif
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
