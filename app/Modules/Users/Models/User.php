<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $primaryKey = 'id';
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
	protected $fillable = ['email', 'name', 'username', 'password', 'picture', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'];
}