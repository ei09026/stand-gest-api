<?php

namespace App\Modules\Catalogs\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $primaryKey = 'id';

    protected $table = 'brands';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description'];
}