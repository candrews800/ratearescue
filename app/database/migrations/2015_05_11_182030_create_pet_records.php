<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetRecords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pet_records', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('pet_id');
            $table->string('breed');
            $table->string('name');
            $table->text('description');
            $table->text('photos');
            $table->enum('animal', array('dog', 'cat'));
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pet_records');
	}

}
