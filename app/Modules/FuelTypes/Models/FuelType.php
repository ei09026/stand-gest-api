<?php

namespace App\Modules\FuelTypes\Models;

use Illuminate\Database\Eloquent\Model;

class FuelType extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'id';

	protected $table = 'fuel-types';
	
	protected static $rules = [
        'description' => 'required|unique:fuel-types'
    ];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description', 'created_at', 'created_by', 'updated_by', 'deleted_at'];
}