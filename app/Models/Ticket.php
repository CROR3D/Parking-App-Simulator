<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'temp_user_id', 'parking_id', 'code', 'price', 'paid', 'entrance_time', 'bonus_time', 'price'];

    public $timestamps = false;
    public $incrementing = false;

    public function saveTicket($ticket)
	{
		return $this->create($ticket);
	}
}
