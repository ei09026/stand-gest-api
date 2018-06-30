<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['device_id', 'facebook_id', 'photo_url', 'email', 'f_name', 'l_name'];

    public function spoilers()
    {
        return $this->belongsToMany('App\Modules\Spoilers\Models\Spoiler', 'pivot_user_spoiler', 'user_id', 'spoiler_id');
    }

    public function shows()
    {
        return $this->belongsToMany('App\Modules\Shows\Models\Show', 'pivot_user_show', 'user_id', 'show_slug')->withTimestamps();
    }
}