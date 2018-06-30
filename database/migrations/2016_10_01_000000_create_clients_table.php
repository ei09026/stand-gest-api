<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('identification_number')->unique();
			$table->string('name');
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('tin')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('observations')->nullable();
			$table->rememberToken()->nullable();
			$table->timestamps();

            $table->bigInteger('created_by');

            //Foreign Keys
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}
}
