<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('merchants', function($table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('site_id');
            $table->string('vendor', 10);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->boolean('blocked')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('merchants');
	}

}
