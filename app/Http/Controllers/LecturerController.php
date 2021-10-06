<?php

namespace App\Http\Controllers;

use App\Model\Course;
use App\Model\Department;
use App\Model\Lecturer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = Lecturer::with(['user', 'department'])->get();

        return view('lecturers.index')->withLecturers($lecturers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::get();
        $courses = Course::get();
        return view('Lecturers.create')->withDepartments($departments)->withCourses($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required|integer',
            'password' => 'required|confirmed|min:8'
        ]);

        // dd($request->courses);

        \DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'account_type' => 2,
                'password' => bcrypt($request->password),
                'first_login' => 1
            ]);

            $lecturer = Lecturer::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'department_id' => $request->department
            ]);

            $lecturer->courses()->sync($request->courses);
        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('fail', 'Lecturer Creation Failed');
            return redirect()->route('lecturers.index');
        }
        \DB::commit();

        Session::flash('success', 'Lecturer Created Successfully');
        return redirect()->route('lecturers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function show(Lecturer $lecturer)
    {
        $lecturer = Lecturer::with(['user', 'courses.assignments.course'])->find($lecturer->id);

        $lecturer->courses->each(function($item) use ($lecturer){
            if ($item->id == $lecturer->id) {
                $lecturer->assignments[] = $item;
            }
        });
        $lecturer->assignments = $lecturer->assignments->sortByDesc('due_at');

        return view('lecturers.show')->withLecturer($lecturer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function edit(Lecturer $lecturer)
    {
        $lecturer = Lecturer::with(['user', 'courses'])->find($lecturer->id);
        $lecturer_courses = $lecturer->courses->pluck('id')->toArray();
        $departments = Department::get();
        $courses = Course::get();

        $courses->each(function($item) use ($lecturer_courses){
            if(in_array($item->id, $lecturer_courses)){
                $item->selected = true;
            } else{
                $item->selected = false;
            }
        });

        return view('Lecturers.edit')->withLecturer($lecturer)->withCourses($courses)->withDepartments($departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $this->validate($request, [
            'account_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required|integer'
        ]);

        \DB::beginTransaction();
        try {
            $lecturer = Lecturer::find($lecturer->id);
            $lecturer->title = $request->title;
            $lecturer->first_name = $request->first_name;
            $lecturer->middle_name = $request->middle_name;
            $lecturer->last_name = $request->last_name;
            $lecturer->department_id = $request->department;
            $lecturer->courses()->sync($request->courses);
            $lecturer->save();

            User::where('id', $lecturer->user_id)->update(['account_type'=>(int) $request->account_type]);

        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('fail', 'Lecturer Update Failed');
            return redirect()->route('lecturers.index');
        }
        \DB::commit();

        Session::flash('success', 'Lecturer Updated Successfully');
        return redirect()->route('lecturers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Lecturer  $lecturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecturer $lecturer)
    {
        $check_admin = User::where('account_type', 1)->get();
        if(count($check_admin) < 2){
            Session::flash('fail', 'Lecturer Deletion Failed. You are the only Admin!');
            return redirect()->route('lecturers.index');
        }
        \DB::beginTransaction();
        try {
            $lecturer->delete();
            User::destroy($lecturer->user_id);
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Lecturer Deletion Failed');
            return redirect()->route('lecturers.index');
        }
        \DB::commit();

        Session::flash('success', 'Lecturer Deleted Successfully');
        return $lecturer;
    }
}
