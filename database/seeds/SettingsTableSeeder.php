<?php

use App\Model\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Setting::truncate();
    	
        $settings = [
        	'app_name' => 'ATAP',
        	'site_home' => 'http://www.example.com',
        	'site_views' => 0,
        	'site_blog' => '',
        	'support_phone' => '0812345678',
        	'support_email' => 'support@example.com',
        	'date_format' => 'F jS, Y',
        	'time_format' => 'h:i:s',
        	'meta_description' => '',
        	'meta_keywords' => '',
        	// 'key' => 'value',
        ];

        foreach ($settings as $key => $value) {
        	Setting::create([
        		'option_key' => $key,
        		'option_value' => $value
        	]);
        }
    }
}
