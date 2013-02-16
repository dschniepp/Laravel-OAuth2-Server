<?php

/**
 * Default structure for the table handling the refresh tokens.
 */
$table->string('refresh_token', 40);
$table->string('client_id');
$table->integer('user_id')->unsigned();
$table->integer('expires');
$table->string('scope', 255)->nullable();
$table->timestamps();
$table->primary('refresh_token');
