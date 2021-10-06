<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';
    protected $fillable = ['lecturer_id', 'course_id', 'title', 'upload_path', 'due_at', 'published_at', 'extra'];

    public function lecturer()
    {
    	return $this->belongsTo('App\Model\Lecturer', 'lecturer_id');
    }

    public function course()
    {
    	return $this->belongsTo('App\Model\Course', 'course_id');
    }

    public function answers()
    {
    	return $this->hasMany('App\Model\Answer', 'assignment_id');
    }

    // Accessors and Mutators
    public function getDueAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value);
    }
}
