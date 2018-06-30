<?php

namespace App\Modules\Shows\Models;

use Illuminate\Database\Eloquent\Model;

class Show extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'slug';

    protected $table = 'shows';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'year', 'trakt', 'slug', 'tvdb', 'imdb', 'tmdb', 'tvrage'];

    public function users()
    {
        return $this->belongsToMany('App\Modules\Users\Models\User', 'pivot_user_show', 'user_id', 'show_slug')->withTimestamps();;
    }
}