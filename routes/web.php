<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/login', 'PageController@loginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('post_login');
Route::get('/register', 'PageController@register')->name('new_register');
Route::post('/register', 'PageController@studentRegistion')->name('post_register');
Route::get('/logout', 'HomeController@logout');

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/generate-password', 'HelperController@generatePassword');

Route::get('lecturers/courses/{course}', 'CourseController@lecturers');
Route::get('students/courses/{course}', 'CourseController@students');
Route::get('courses/assignment/{course}', 'CourseController@assignments');

//Admin Routes
Route::group(['middleware' => ['auth']], function(){
	Route::resource('departments', 'DepartmentController');
	Route::get('courses/register', 'CourseController@showRegisterCourses');
	Route::post('courses/register', 'CourseController@postRegisterCourses');
	Route::resource('courses', 'CourseController');
	Route::resource('lecturers', 'LecturerController');
	Route::resource('students', 'StudentController');

	Route::get('/dashboard', 'HomeController@dashboard');


	Route::get('/assignment/answer/{id}', 'AssignmentController@viewAnswer');
	Route::post('/assignment/score/', 'AssignmentController@scoreAnswer');
	Route::get('/answer/download/{id}', 'AssignmentController@downloadAnswer');


	Route::get('/assignment/submit/{id}', 'AssignmentController@submitAssignment');
	Route::post('/assignment/submit/{id}', 'AssignmentController@postSubmitAssignment')->name('post_submit');
	Route::get('/assignment/download/{id}', 'AssignmentController@downloadAssignment');
	Route::resource('assignments', 'AssignmentController');


	Route::get('administration/users', 'UserController@index');
	Route::get('administration/users/{id}/edit', 'UserController@edit');
	Route::put('administration/users/{id}', 'UserController@update')->name('users.update');
});