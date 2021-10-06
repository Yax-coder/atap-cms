<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }

        return view('login');
    }

    public function dashboard(){
        if(Auth::user()->account_type == 1){
            $info = $this->getAdminDashboard();
        } else if(Auth::user()->account_type == 2){
            $info = $this->getLecturerDashboard();
        } else if(Auth::user()->account_type == 3){
            $info = $this->getStudentDashboard();
        } else{
            return redirect('/login');
        }
        return view('dashboard')->withInfo($info);
    }

    public function getAdminDashboard()
    {
        
    }

    public function getLecturerDashboard()
    {
        
    }

    public function getStudentDashboard()
    {
        $cc = new CourseController();
        $ac = new AssignmentController();
        $courses = $cc->getStudentCourses();
        $assignments = $ac->getStudentAssignments()->where('published_at', '<' ,Carbon::now())->sortBy('published_at');

        return [
            'stat' => [$courses->count(), $assignments->count()],
            'assignments' => $assignments
        ];
    }
}
