<?php

namespace App\Modules\Extras\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'id';

	protected $table = 'extras';
	
	protected static $rules = [
        'description' => 'required|unique:extras'
    ];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description', 'rank_id', 'created_at', 'created_by', 'updated_by', 'deleted_at'];
}