<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('quests', function($table)
        {
            $table->increments('id')->unique();
            $table->integer('user_id');
            $table->integer('site_id');
            $table->integer('visitor_id');
            $table->string('text');
            $table->string('href');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('quests');
	}

}
