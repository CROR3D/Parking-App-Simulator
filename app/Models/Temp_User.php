<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temp_User extends Model
{
    protected $table = 'temp_users';

    public function saveTempUser($temp_user)
	{
		return $this->create($temp_user);
	}
}
