<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = ['user_id', 'first_name', 'last_name', 'middle_name', 'department_id', 'matric_no'];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function department()
    {
    	return $this->belongsTo('App\Model\Department', 'department_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Model\Course', 'course_students', 'student_id', 'course_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Model\Answer', 'student_id');
    }

    // Accessors and Mutators
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
