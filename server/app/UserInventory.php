<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInventory extends Model
{
    protected $fillable = [
    	'item_id', 'user_id', 'amount',
	];
}
