<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
            $table->integer('job_id')->unsigned();
            $table->integer('parameter_id')->unsigned();
            $table->string('name');
            $table->string('value');

            $table->foreign('job_id')
                  ->references('id')
                  ->on('jobs')
                  ->onDelete('cascade');

            $table->foreign('parameter_id')
                  ->references('id')
                  ->on('parameters');
            /* don't need to cascade, cause parameter will only be deleted by simulation,
             * which cascades to jobs, which cascades to variables */

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('variables');
	}

}
