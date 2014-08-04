<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('sites', function($table)
        {
            $table->increments('id');
            $table->string('domain')->unique();
            $table->string('comment');
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
		//
	}

}
