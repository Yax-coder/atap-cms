<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseLecturer extends Model
{
    protected $table = 'course_lecturers';
    protected $fillable = ['course_id', 'lecturer_id'];
}
