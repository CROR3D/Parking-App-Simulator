<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $fillable = ['user_id', 'about', 'expire_time'];

    public function saveError($error)
	{
		return $this->create($error);
	}
}
