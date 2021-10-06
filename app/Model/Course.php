<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['unique_name', 'code', 'title'];

    public function lecturers()
    {
    	return $this->belongsToMany('App\Model\Lecturer', 'course_lecturers', 'course_id', 'lecturer_id');
    }

    public function students()
    {
    	return $this->belongsToMany('App\Model\Student', 'course_students', 'course_id', 'student_id');
    }

    public function assignments()
    {
    	return $this->hasMany('App\Model\Assignment', 'course_id');
    }
}
