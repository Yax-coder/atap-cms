<?php

namespace App\Http\Controllers;

use App\Model\Assignment;
use App\Model\Course;
use App\Model\Lecturer;
use App\Model\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view_as = null)
    {
        
        if(Auth::user()->account_type == 1 && Input::get('view_as') == 'admin'){
            $courses = Course::with(['students', 'lecturers'])->get();
        }else if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2){
            $courses = $this->getLecturerCourses();
        }else if(Auth::user()->account_type == 3){
            $courses = $this->getStudentCourses();
        }
        return view('courses.index')->withCourses($courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lecturers = Lecturer::get();
        return view('Courses.create')->withLecturers($lecturers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->lecturers);
        $this->validate($request, [
            'code' => 'bail|required',
            'title' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $course = Course::create([
                'unique_name' => strtoupper(str_slug($request->code)),
                'code' => strtoupper($request->code),
                'title' => $request->title
            ]);
            if($request->lecturers){
                $course->lecturers()->sync($request->lecturers);
            }
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Course Creation Failed');
            return redirect()->route('courses.index');
        }
        \DB::commit();

        Session::flash('success', 'Course Created Successfully');
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course = Course::with(['assignments', 'lecturers', 'students'])->find($course->id);

        $course->assignments = $course->assignments->sortByDesc('due_at');
        if(Auth::user()->account_type == 3){
            $filtered = $course->assignments->filter(function ($value, $key) {
                return Carbon::now() > $value->published_at;
            });
            $course->assignments = $filtered;
        }

        // dd($course);
        return view('courses.show')->withCourse($course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $course = Course::with('lecturers')->find($course->id);
        $course_lecturers = $course->lecturers->pluck('id')->toArray();
        $lecturers = Lecturer::get();

        $lecturers->each(function($item) use ($course_lecturers){
            if(in_array($item->id, $course_lecturers)){
                $item->selected = true;
            } else{
                $item->selected = false;
            }
        });

        return view('Courses.edit')->withCourse($course)->withLecturers($lecturers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'code' => 'bail|required',
            'title' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $course->unique_name = str_slug($request->code);
            $course->code = $request->code;
            $course->title = $request->title;

            $course->lecturers()->sync($request->lecturers);
            $course->save();
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Course Update Failed');
            return redirect()->route('courses.index');
        }
        \DB::commit();

        Session::flash('success', 'Course Updated Successfully');
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        \DB::beginTransaction();
        try {
            $course->delete();
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Course Deletion Failed');
            return redirect()->route('courses.index');
        }
        \DB::commit();

        Session::flash('success', 'Course Deletion Successfully');
        return $course;
    }

    public function lecturers(Course $course)
    {
        $course = Course::with('lecturers.user')->find($course->id);

        return $course;
    }

    public function students(Course $course)
    {
        $course = Course::with('students.user')->find($course->id);

        return $course;
    }

    public function assignments(Course $course)
    {
        $course = Course::with('assignments')->find($course->id);

        return $course;
    }

    public function getStudentCourses()
    {
        $user = User::with(['student.courses'])->find(Auth::user()->id);
        $courses = $user->student->courses;
        return $courses;
    }

    public function getLecturerCourses()
    {
        $user = User::with(['lecturer.courses'])->find(Auth::user()->id);
        $courses = $user->lecturer->courses;
        return $courses;
    }

    public function showRegisterCourses()
    {
        $courses = Course::with('students')->get();
        $student = Student::where('user_id', Auth::user()->id)->first();

        $courses->each(function($course)use($student){
            
        });

        return view('Courses.register')->withCourses($courses);
    }

    public function postRegisterCourses(Request $request)
    {
        // dd($request->courses);
        $student = Student::where('user_id', Auth::user()->id)->first();

        \DB::beginTransaction();
        try {
            if($request->courses){
                $student->courses()->sync($request->courses);
            }
        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('success', 'Course Resgistration Failed');
            return redirect()->route('courses.index');
        }
        \DB::commit();

        Session::flash('success', 'Course Registered Successfully');
        return redirect()->route('courses.index');
    }
}
