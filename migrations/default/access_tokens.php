<?php

/**
 * Default structure for the table handling the access tokens.
 */
$table->string('oauth_token', 40);
$table->string('client_id');
$table->integer('user_id')->unsigned();
$table->integer('expires');
$table->string('scope', 255)->nullable();
$table->timestamps();
$table->primary('oauth_token');
