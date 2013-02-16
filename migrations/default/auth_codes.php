<?php

/**
 * Default structure for the table handling the authorization codes.
 */
$table->string('code', 40);
$table->string('client_id');
$table->integer('user_id')->unsigned();
$table->string('redirect_uri', 255);
$table->integer('expires');
$table->string('scope', 255)->nullable();
$table->timestamps();
$table->primary('code');
