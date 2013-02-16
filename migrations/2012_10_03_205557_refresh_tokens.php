<?php

class Oauth2_Server_Refresh_Tokens {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('refresh_tokens', function($table)
		{
		    $table->string('refresh_token', 40);
		    $table->string('client_id');
		    $table->integer('user_id')->unsigned();
		    $table->integer('expires');
		    $table->string('scope', 255)->nullable();
		    $table->timestamps();
		    $table->primary('refresh_token');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('refresh_tokens');
	}

}
