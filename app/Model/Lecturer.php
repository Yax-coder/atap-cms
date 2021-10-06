<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $table = 'lecturers';
    protected $fillable = ['user_id', 'title', 'first_name', 'last_name', 'middle_name', 'department_id'];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function department()
    {
    	return $this->belongsTo('App\Model\Department', 'department_id');
    }

    public function assignments()
    {
    	return $this->hasMany('App\Model\Assignment', 'lecturer_id');
    }

    public function courses()
    {
    	return $this->belongsToMany('App\Model\Course', 'course_lecturers', 'lecturer_id', 'course_id');
    }


    // Accessors and Mutators
    public function getNameAttribute()
    {
        return "{$this->title} {$this->first_name} {$this->last_name}";
    }
}
