<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('vehicles', function(Blueprint $table)
		{
            $table->increments('id');

            //General
            $table->string('plate')->unique();
            $table->bigInteger('brand_id');
            $table->bigInteger('model_id');
            $table->bigInteger('category_id');
            $table->bigInteger('type_id');
            $table->date('purchase_date');
            $table->integer('month');
            $table->integer('year');
            $table->bigInteger('color_id');
            $table->bigInteger('fuel_id');
            $table->bigInteger('number_of_doors_id');
            $table->bigInteger('number_of_places_id');
            $table->string('board_number')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->bigInteger('number_of_owners')->nullable();;

            //State
            $table->bigInteger('state_id');

            //Negotiation
            $table->decimal('purchase_price');
            $table->decimal('discount');
            $table->decimal('sale_price');

            $table->timestamps();
            $table->bigInteger('created_by');

            //Foreign Keys
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('brand_id')
                ->references('id')->on('brands')
                ->onDelete('cascade');

            $table->foreign('model_id')
                ->references('id')->on('models')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')->on('vehicle_types')
                ->onDelete('cascade');

            $table->foreign('color_id')
                ->references('id')->on('colors')
                ->onDelete('cascade');

            $table->foreign('fuel_id')
                ->references('id')->on('fuels')
                ->onDelete('cascade');

            $table->foreign('number_of_doors_id')
                ->references('id')->on('number_of_doors')
                ->onDelete('cascade');

            $table->foreign('number_of_places_id')
                ->references('id')->on('number_of_places')
                ->onDelete('cascade');

            $table->foreign('state_id')
                ->references('id')->on('states')
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
		Schema::drop('vehicles');
	}

}
