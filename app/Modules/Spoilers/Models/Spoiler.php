<?php

namespace App\Modules\Spoilers\Models;


use Illuminate\Database\Eloquent\Model;

class Spoiler extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'spoilers';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['show_slug', 'description', 'mad_count', 'not_mad_count', 'relavance'];

    public function users()
    {
        return $this->belongsToMany('App\Modules\Users\Models\User', 'pivot_user_show', 'user_id', 'show_slug');
    }
}