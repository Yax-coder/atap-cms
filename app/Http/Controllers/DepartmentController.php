<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::withCount(['lecturers', 'students'])->get();

        return view('departments.index')->withDepartments($departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lecturers = Lecturer::get();
        return view('Departments.create')->withLecturers($lecturers);
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
            'name' => 'required'
        ]);

        \DB::beginTransaction();
        try {
            $department = Department::create([
                'name' => $request->name
            ]);
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Department Creation Failed');
            return redirect()->route('departments.index');
        }
        \DB::commit();

        Session::flash('success', 'Department Created Successfully');
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $department = Department::with(['lecturers', 'students'])->find($department->id);

        return view('departments.show')->withDepartment($department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $department = Department::find($department->id);

        return view('departments.edit')->withDepartment($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        \DB::beginTransaction();
        try {
            $department->name = $request->name;
            $department->save();
        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('fail', 'Department Update Failed');
            return redirect()->route('departments.index');
        }
        \DB::commit();

        Session::flash('success', 'Department updated Successfully');
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        \DB::beginTransaction();
        try {
            $department->delete();
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'Department Deletion Failed');
            return redirect()->route('departments.index');
        }
        \DB::commit();

        Session::flash('success', 'Department Deleted Successfully');
        return redirect()->route('departments.index');
    }
}
