<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'parking_id', 'code', 'cancellation', 'expire_time'];

    public function saveReservation($reservation)
	{
		return $this->create($reservation);
	}
}
