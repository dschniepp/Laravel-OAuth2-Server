<?php

class Oauth2Server_Auth_Codes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auth_codes', function($table)
		{
		    $table->string('code', 40);
		    $table->string('client_id');
		    $table->integer('user_id')->unsigned();
		    $table->string('redirect_uri', 200);		    		    
		    $table->integer('expires');		    
		    $table->string('scope', 200)->nullable();
		    $table->timestamps();
		    $table->primary('code');	    
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auth_codes');
	}

}