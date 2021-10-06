<?php

namespace App\Http\Controllers;

use App\Model\Answer;
use App\Model\Assignment;
use App\Model\Course;
use App\Model\Lecturer;
use App\Model\Student;
use App\Traits\FileSystem;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AssignmentController extends Controller
{
    use FileSystem;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view_as = null)
    {
        if(Auth::user()->account_type == 1 && Input::get('view_as') == 'admin'){
            $assignments = Assignment::with(['course', 'answers'])->get();
            return view('assignments.lecturer.index')->withAssignments($assignments);
        }else if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2){
            $assignments = $this->getLecturerAssignments()
                            ->sortBy('due_at');
            return view('assignments.lecturer.index')->withAssignments($assignments);
        }else if(Auth::user()->account_type == 3){
            $assignments = $this->getStudentAssignments()
                            ->where('published_at', '<' , Carbon::now())
                            ->sortBy('due_at');
                            // dd($assignments);
            return view('assignments.student.index')->withAssignments($assignments);
        }

        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lecturer = Lecturer::with('courses')->find(Auth::user()->lecturer->id);
        $courses = $lecturer->courses;
        return view('Assignments.lecturer.create')->withCourses($courses);
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
            'course' => 'required',
            'title' => 'required',
            'upload_file' => 'required|file|mimes:pdf,doc,docx',
            'published_at' => 'date',
            'due_at' => 'date'
        ]);

        if(!$request->hasFile('upload_file')){
            Session::flash('fail', 'Please Upload a PDF File');
            return back()->withInput();
        }

        $title = $request->title;
        $upload = $request->file('upload_file');

        $filename = str_slug($title . '-'. Carbon::now(), '_');
        $ext = $upload->getClientOriginalExtension();

        \DB::beginTransaction();
        try {
            $upload_path = $this->upload($upload, 'uploads/user'.Auth::user()->id.'/assignments', $filename.'.'.$ext);

            $assignment = Assignment::create([
                'lecturer_id' => Auth::user()->lecturer->id,
                'course_id' => $request->course,
                'title' => $request->title,
                'upload_path' => $upload_path,
                'extra' => $request->extra,
                'published_at' => $request->published_at,
                'due_at' => $request->due_at
            ]);

        } catch(QueryException $ex) {
            \DB::rollBack();

            if($upload_path){
                Storage::delete($upload_path);
            }

            Session::flash('fail', 'Assignment Creation Failed');
            return back()->withInput();
        }
        \DB::commit();

        Session::flash('success', 'Assignment Created Successfully');
        return redirect()->route('assignments.index');
    }

    public function submitAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        return view('assignments.student.submit')->withAssignment($assignment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSubmitAssignment(Request $request)
    {
        $this->validate($request, [
            'assignment' => 'required',
            'upload_file' => 'required|file|mimes:pdf,doc,docx'
        ]);

        if(!$request->hasFile('upload_file')){
            Session::flash('fail', 'Please Upload a PDF File');
            return back()->withInput();
        }

        $check = Answer::where([
            ['assignment_id', $request->assignment],
            ['student_id', Auth::user()->student->id]
        ])->get();

        if(count($check) > 0){
            Session::flash('fail', 'You have already Submitted an Answer');
            return back()->withInput();
        }

        $assignment = Assignment::findOrFail($request->assignment);

        if(Carbon::now() > $assignment->due_at){
            Session::flash('fail', 'Late Submission Not Accepted');
            return back()->withInput();
        }

        $title = $assignment->title;
        $upload = $request->file('upload_file');

        $filename = str_slug(Auth::user()->student->name. '-' . $title . '-'. Carbon::now(), '_');
        $ext = $upload->getClientOriginalExtension();

        \DB::beginTransaction();
        try {
            $upload_path = $this->upload($upload, 'uploads/user'.Auth::user()->id.'/answer', $filename.'.'.$ext);

            $answer = Answer::create([
                'student_id' => Auth::user()->student->id,
                'assignment_id' => $request->assignment,
                'upload_path' => $upload_path,
                'extra' => $request->extra,
                'submitted_at' => Carbon::now()
            ]);

        } catch(QueryException $ex) {
            \DB::rollBack();

            if($upload_path){
                Storage::delete($upload_path);
            }

            Session::flash('fail', 'Assignment Submission Failed');
            return back()->withInput();
        }
        \DB::commit();

        Session::flash('success', 'Assignment Submitted Successfully');
        return redirect()->route('assignments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        $assignment = Assignment::with(['course', 'answers.student'])->find($assignment->id);
        if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2){
            $assignment = Assignment::with(['course', 'answers.student'])->find($assignment->id);
            // return view('assignments.lecturer-show')->withAssignment($assignment);
        }else if(Auth::user()->account_type == 3){
            $assignment = Assignment::with(['course'])->find($assignment->id);
            $assignment->answer = Answer::where([
                                ['student_id', Auth::user()->student->id],
                                ['assignment_id', $assignment->id]
                            ])->first();
            // return view('assignments.student-show')->withAssignment($assignment);
        }
        
        // dd($assignment);
        return view('assignments.show')->withAssignment($assignment);
    }

    public function viewAnswer($id)
    {
        $answer = Answer::with(['assignment.course', 'student'])->find($id);

        return view('assignments.lecturer.score')->withAnswer($answer);
    }

    public function scoreAnswer(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'answer' => 'required',
            'score' => 'required'
        ]);
        $answer = Answer::find($request->answer);
        if(!$answer){
            Session::flash('fail', 'Answer Not Found');
            return back()->withInput();
        }

        \DB::beginTransaction();
        try {
            $answer->score = $request->score;
            $answer->save();

        } catch(QueryException $ex) {
            \DB::rollBack();

            if($upload_path){
                Storage::delete($upload_path);
            }

            Session::flash('fail', 'Scoring Answer Failed');
            return back()->withInput();
        }
        \DB::commit();

        Session::flash('success', 'Scoring Answer Successful');
        return redirect()->route('assignments.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }

    public function downloadAssignment($id)
    {
        $assignment = Assignment::find($id);

        if($assignment->upload_path == null){
            Session::flash('fail', 'File does not Exist');
            return back();
        }
        $explode = explode('.', $assignment->upload_path);
        $ext = end($explode);

        return response()->download(storage_path('app/'.$assignment->upload_path), str_slug($assignment->title, '_').".$ext");
    }

    public function downloadAnswer($id)
    {
        $answer = Answer::find($id);

        if($answer->upload_path == null){
            Session::flash('fail', 'File does not Exist');
            return back();
        }
        $explode = explode('.', $answer->upload_path);
        $ext = end($explode);

        return response()->download(storage_path('app/'.$answer->upload_path), str_slug($answer->student->name.'-'.$answer->assignment->title, '_').".$ext");
    }

    public function getStudentAssignments()
    {
        $user = User::with(['student.courses'])->find(Auth::user()->id);
        $courses = $user->student->courses->pluck('id')->toArray();
        $assignments = Assignment::with(['answers'])
                        ->whereIn('course_id', $courses)
                        ->get();
        $assignments->each(function($assignment) use ($user){
            $assignment->answer = Answer::where([
                                    ['student_id', $user->student->id],
                                    ['assignment_id', $assignment->id]
                                ])->first();
        });
        // dd($assignments);
        return $assignments;
    }

    public function getLecturerAssignments()
    {
        $user = User::with(['lecturer'])->find(Auth::user()->id);
        $assignments = Assignment::with(['course.students', 'answers'])->where('lecturer_id', $user->lecturer->id)->get();
        return $assignments;
    }

    public function sampleCheck()
    {
        if(Auth::user()->account_type == 1 && Input::get('view_as') == 'admin'){
            $assignments = Assignment::with(['course', 'answers'])->get();
            return view('assignments.lecturer-index')->withAssignments($assignments);
        }else if(Auth::user()->account_type == 1 || Auth::user()->account_type == 2){
            $assignments = $this->getLecturerAssignments()
                            ->sortBy('due_at');
            return view('assignments.lecturer-index')->withAssignments($assignments);
        }else if(Auth::user()->account_type == 3){
            $assignments = $this->getStudentAssignments()
                            ->where('published_at', '<' , Carbon::now())
                            ->sortBy('due_at');
            return view('assignments.student-index')->withAssignments($assignments);
        }
    }
}
