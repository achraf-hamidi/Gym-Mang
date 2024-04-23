<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	protected $fillable = [
		'message',
	];

	public function users() {
		return $this->belongsToMany('App\User')->withPivot('id', 'user_id', 'to_user_id', 'seen_it');
	}

	 
}
