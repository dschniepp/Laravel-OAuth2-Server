<?php

class Oauth2Server_Access_Tokens {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('access_tokens', function($table)
		{
		    $table->string('oauth_token', 40);
		    $table->string('client_id');
		    $table->integer('user_id')->unsigned();
		    $table->integer('expires');		    
		    $table->string('scope', 255)->nullable();
		    $table->timestamps();
		    $table->primary('oauth_token');	    
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('access_tokens');
	}

}