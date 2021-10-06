<?php

use App\Model\Course;
use App\Model\Department;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FixedDataTableSeeder extends Seeder
{
	public $faker;

    public function __construct()
    {
        $this->faker = Factory::create('en_NG');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->createDepartments();
    }

    public function createDepartments()
    {
    	Course::truncate();
    	Department::truncate();

        $department = Department::create([
            'name' => 'Computer Science'
        ]);

        // $this->testingData();
    }

    public function testingData()
    {
        $deps = [
            ['Mathematics', 'MAT', 10],
            ['Medicine', 'MED', 2]
        ];

        foreach ($deps as $dep) {
            $department = Department::create([
                'name' => $dep[0]
            ]);

            for ($i=0; $i < $dep[2]; $i++) {
                $code = $dep[1].' '.mt_rand(101,499);
                Course::create([
                    'unique_name' => str_slug($code),
                    'code' => $code,
                    'title' => 'Course Title '. $this->faker->sentence(mt_rand(2,4)),
                ]);
            }
        }
    }
}
