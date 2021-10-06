<?php

namespace App\Support;

use App\Model\Setting;
use Illuminate\Support\Facades\DB;


class Helper{

	/**
     * Getting System Setting
     * @return  void
     */
    public static function getSettings()
    {
        $settings = Setting::all()->pluck('option_value', 'option_key');
        return $settings;
    }

    // Increment Views
    public static function incrementViews(){
        $row = Setting::where('option_key', 'site_views')->increment('option_value');
        $row->value = (int) $row->value + 1;
        $row->save();
    }

    //Update a Setting
    public static function updateSetting($key, $value){
    	$row = Setting::where('option_key', $key)->first();
        $r = DB::table('settings')->where('option_key', $key)->update(['option_value' => $value]);
    }
}