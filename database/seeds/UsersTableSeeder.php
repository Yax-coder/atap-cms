<?php

use App\Model\Course;
use App\Model\CourseLecturer;
use App\Model\CourseStudent;
use App\Model\Department;
use App\Model\Lecturer;
use App\Model\Student;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public $faker;
    public $depatrments;
    public $courses;

    public function __construct()
    {
        $this->faker = Factory::create('en_NG');

        $this->departments = Department::get()->pluck('id');
        $this->courses = Course::get()->pluck('id');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Lecturer::truncate();
        Student::truncate();
        CourseLecturer::truncate();
        CourseStudent::truncate();
        $this->createAdmin();
        // $this->createLecturers();
        // $this->createStudents();
        
    }

    public function createAdmin()
    {
        $user = User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'account_type' => 1,
        ]);

        $lecturer = Lecturer::create([
            'user_id' => $user->id,
            'title' => '',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'middle_name' => '',
            'department_id' => 1
        ]);

        $lecturer->courses()->attach($this->courses->shuffle()->slice(0,3)->toArray());
    }

    public function createLecturers()
    {
        for ($i=1; $i < 11; $i++) {
            $user = User::create([
                'email' => 'lecturer'.$i.'@example.com',
                'password' => bcrypt('password'),
                'account_type' => 2,
            ]);

            $lecturer = Lecturer::create([
                'user_id' => $user->id,
                'title' => $this->faker->title,
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'middle_name' => '',
                'department_id' => $this->faker->randomElement($this->departments->toArray()),
            ]);

            $lecturer->courses()->attach($this->courses->shuffle()->slice(0,mt_rand(1, 3))->toArray());
        }
    }

    public function createStudents()
    {
        $years = ['2015', '2016', '2017'];
        for ($i=1; $i < 51; $i++) {
            $user = User::create([
                'email' => 'student'.$i.'@example.com',
                'password' => bcrypt('password'),
                'account_type' => 3,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'middle_name' => '',
                'department_id' => $this->faker->randomElement($this->departments->toArray()),
                'matric_no' => 'ATAP/'.$this->faker->numberBetween(100000, 999999),
            ]);

            $student->courses()->attach($this->courses->shuffle()->slice(0,mt_rand(6, 10))->toArray());
        }
    }
}
