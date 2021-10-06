<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_students';
    protected $fillable = ['course_id', 'student_id'];
}
