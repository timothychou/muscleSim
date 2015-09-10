<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parameters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->integer('simulation_id')->unsigned();
            $table->string('type');
            $table->string('name');
            $table->string('defaultVal');
            $table->foreign('simulation_id')
                  ->references('id')
                  ->on('simulations')
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
		Schema::drop('parameters');
	}

}
