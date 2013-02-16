<?php

/**
 * Default structure for the table handling the oAuth consumers.
 */
$table->string('client_id');
$table->string('client_secret', 60);
$table->string('redirect_uri');
$table->timestamps();
$table->primary('client_id');
