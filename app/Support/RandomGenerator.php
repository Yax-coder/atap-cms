<?php

namespace App\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RandomGenerator extends Controller
{
	protected $list = '';
	protected $result = '';

	public function __construct(){
        // 0-9, a-z, A-Z
        $this->list = implode(array_merge(range(0,9), range('a', 'z'), range('A', 'Z')), '');
	}

    public function number($count = 9){
        $min = (int) pow(10, $count) / 10;
        $max = (int) pow(10, $count) - 1;

        $this->result = mt_rand($min, $max);

    	return intval($this->result);
    }

    public function alphanumeric($count = 9){
    	$this->result = substr(str_shuffle($this->list), 0, $count);

    	return $this->result;
    }

    public function withSymbols($count = 9){
        $this->list = $this->list . '`~!@#$%^&*()_+-=[]{}\|;:,.<>/?\'\"';
        $this->result = substr(str_shuffle($this->list), 0, $count);

        return $this->result;
    }
}
