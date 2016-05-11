<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_id');
            $table->string('receiever_id');
						$table->string('body');
						$table->string('hidden_to_sender');
						$table->string('hidden_to_receiver');
						$table->string('receiever_read');
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
		Schema::drop('messages');
	}

}
