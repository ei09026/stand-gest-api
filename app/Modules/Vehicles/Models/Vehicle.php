<?php

namespace App\Modules\Vehicles\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'id';

	protected $table = 'vehicles';
	
	protected static $rules = [
    ];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['plate', 'brand_id', 'model_id', 'category_id', 'type_id', 'purchase_date', 'month', 'year', 'color_id', 'fuel_id', 'number_of_doors_id',
	'board_number', 'engine_capacity', 'number_of_owners', 'state_id', 'purchase_price', 'discount', 'sale_price', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}
