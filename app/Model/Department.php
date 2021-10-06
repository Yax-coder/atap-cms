<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name'];

    public function lecturers()
    {
    	return $this->hasMany('App\Model\Lecturer', 'department_id');
    }

    public function students()
    {
    	return $this->hasMany('App\Model\Student', 'department_id');
    }
}
