<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('states', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('description')->unique();

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
		//
		Schema::drop('states');
	}

}
