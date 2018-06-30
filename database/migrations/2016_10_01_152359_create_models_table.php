<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('models', function(Blueprint $table)
		{
            $table->increments('id');

            $table->bigInteger('brand_id')->unique();
            $table->string('description')->unique();

            $table->timestamps();
            $table->bigInteger('created_by');

            //Foreign Keys
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('brand_id')
                ->references('id')->on('brands')
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
		Schema::drop('models');
	}

}
