<?php

namespace App\Traits;

trait FileSystem
{
	public function upload($upload, $folder, $filename)
	{
		// dd($upload);
		$path = $upload->storeAs($folder, $filename);
		
		return $path;
	}
}