<?php

namespace App\Modules\Colors\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'id';

	protected $table = 'colors';
	
	protected static $rules = [
        'description' => 'required|unique:colors'
    ];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description', 'rank_id', 'created_at', 'created_by', 'updated_by', 'deleted_at'];
}