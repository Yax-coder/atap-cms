<?php

namespace App\Http\Controllers;

use App\Support\RandomGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HelperController extends Controller
{
    public function generatePassword()
    {
    	$generator = new RandomGenerator();
    	$password = $generator->alphanumeric(8);

    	$info = [
    	    'status'=>'success',
    	    'data' => $password
    	];
    	
    	return Response::json($info);
    }
}
