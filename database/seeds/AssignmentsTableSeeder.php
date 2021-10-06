<?php

use App\Model\Answer;
use App\Model\Assignment;
use App\Model\Lecturer;
use App\Model\Student;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AssignmentsTableSeeder extends Seeder
{
	// public $faker;
    public $lecturers;
    public $students;

    public function __construct()
    {
        // $this->faker = Factory::create('en_NG');

        $this->lecturers = Lecturer::with('courses')->get();
        $this->students = Student::with('courses')->get();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();

    	Assignment::truncate();
    	Answer::truncate();
        

        // Create Assignments
        foreach($this->lecturers as $lecturer){
        	foreach ($lecturer->courses as $course) {
        		foreach (range(1,mt_rand(1,3)) as $i){

        			$now = Carbon::now();
		        	$d = mt_rand(1, 30);
		            $h = mt_rand(1, 24);
		            $min = $faker->randomElement([10,20,30,40,50]);
		        	$published = Carbon::create($now->year, $now->month,  $d, $h, $min, 0);
		            $due = Carbon::create($now->year, $now->month,  $d+mt_rand(1,7), $h+mt_rand(6,24), $min, 0);

		        	$assignment = Assignment::create([
		        		'lecturer_id' => $lecturer->id,
		        		'course_id' => $course->id,
		        		'title' => $faker->sentence(10),
		        		'upload_path' => 'tests/assignment.pdf',
		        		'extra' => $faker->sentence(50),
		        		'published_at' => $published,
		        		'due_at' => $due,
		        	]);
        		}
        	}
        }

        // Create Answers
        foreach($this->students as $student){
        	foreach ($student->courses as $course) {
        		foreach ($course->assignments as $assignment){
        			$skip = mt_rand(0,9);

        			if($skip>0){
        				$answer = Answer::create([
        					'student_id' => $student->id,
        					'assignment_id' => $assignment->id,
        					'upload_path' => 'tests/answer.pdf',
        					'extra' => $faker->sentence($faker->randomElement([0,20])),
        					'submitted_at' => Carbon::now()
        				]);
        			}
        		}
        	}
        }
    }
}
