<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['student', 'lecturer'])->get();
        
        $users->each(function($user){
        	if($user->student){
        		$user->url = 'students/'.$user->student->id;
        	}else{
        		$user->url = 'lecturers/'.$user->lecturer->id;
        	}
        });

        return view('users.index')->withUsers($users);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('Users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        \DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

        } catch(QueryException $ex) {
            \DB::rollBack();
            Session::flash('fail', 'User Update Failed');
            return redirect()->route('users.index');
        }
        \DB::commit();

        Session::flash('success', 'User Updated Successfully');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$check_admin = User::where('account_type', 1)->get();
        if(count($check_admin) < 2){
            Session::flash('fail', 'Lecturer Deletion Failed. You are the only Admin!');
            return redirect()->route('lecturers.index');
        }

    	$user = User::findOrFail($id);
        \DB::beginTransaction();
        try {
        	Student::where('user_id', $user->id)->delete();
        	Lecturer::where('user_id', $user->id)->delete();
            $user->delete();
        } catch(QueryException $ex) {
            \DB::rollBack();

            Session::flash('fail', 'user Deletion Failed');
            return redirect()->route('users.index');
        }
        \DB::commit();

        Session::flash('success', 'user Deleted Successfully');
        return redirect()->route('users.index');
    }
}
