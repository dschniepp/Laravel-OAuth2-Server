<?php

class Oauth2_Server_Clients {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function($table)
		{
		    $table->string('client_id');
		    $table->string('client_secret');
		    $table->string('redirect_uri');
		    $table->timestamps();
		    $table->primary('client_id');	    
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clients');
	}

}