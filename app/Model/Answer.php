<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = ['student_id', 'assignment_id', 'upload_path', 'extra', 'submitted_at', 'score'];

    public function assignment()
    {
    	return $this->belongsTo('App\Model\Assignment', 'assignment_id');
    }

    public function student()
    {
    	return $this->belongsTo('App\Model\Student', 'student_id');
    }
}
