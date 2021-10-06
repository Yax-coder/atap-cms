<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use App\Model\Course;
use App\Model\Department;
use App\Model\Student;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\withInput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function output(){
    	$output = Department::get()->pluck('id');
    	$output = Course::get()->pluck('id');
    	$faker = Factory::create();
    	dd($output->shuffle()->slice(0,4));
    }

    public function register()
    {
        $departments = Department::get();
        return view('register')->withDepartments($departments);
    }

    public function loginForm()
    {
        return view('login');
    }

    public function login()
    {
        return view('login');
    }

    public function studentRegistion(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'email' => 'bail|required|unique:users,email',
            'matric_no' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required|integer',
            'password' => 'required|confirmed|min:8'
        ]);

        \DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'account_type' => 3,
                'password' => bcrypt($request->password),
                'first_login' => 0
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'matric_no' => $request->matric_no,
                'department_id' => $request->department
            ]);
        } catch(QueryException $ex) {
            \DB::rollBack();
            return back()->withInput();
        }
        \DB::commit();

        Session::flash('success', 'Registration Successfully. Login');
        return redirect()->route('login');
    }
}
