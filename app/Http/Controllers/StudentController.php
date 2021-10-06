<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('user')->get();

        return view('students.index')->withStudents($students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $student = Student::with(['user', 'courses', 'department', 'answers.assignment.course'])->find($student->id);

        return view('Students.show')->withStudent($student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $student = Student::with(['user', 'courses'])->find($student->id);
        $departments = Department::get();

        return view('Students.edit')->withStudent($student)->withDepartments($departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->validate($request, [
            'matric_no' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required|integer'
        ]);

        \DB::beginTransaction();
        try {
            $student = Student::find($student->id);
            $student->matric_no = $request->matric_no;
            $student->first_name = $request->first_name;
            $student->middle_name = $request->middle_name;
            $student->last_name = $request->last_name;
            $student->department_id = $request->department;
            $student->save();

        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('fail', 'student Update Failed');
            return redirect()->route('students.index');
        }
        \DB::commit();

        Session::flash('success', 'Student Updated Successfully');
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        \DB::beginTransaction();
        try {
            $student->delete();
            User::destroy($student->user_id);
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Student Deletion Failed');
            return redirect()->route('students.index');
        }
        \DB::commit();

        Session::flash('success', 'Student Deleted Successfully');
        return redirect()->route('students.index');
    }
}
