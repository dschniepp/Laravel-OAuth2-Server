<?php

class Oauth2_Server_Refresh_Tokens {

   /**
    * Create a new migration instance.
    *
    * @return void
    */
   public function __construct()
   {
      Bundle::start('oauth2-server');
   }

   /**
    * Make changes to the database.
    *
    * @return void
    * @throws Exception
    */
   public function up()
   {
      Schema::create(Config::get('oauth2-server::bundle.tables.refresh_tokens', 'refresh_tokens'), function($table)
      {
         if ( ! file_exists($f = __DIR__.'/'.Config::get('oauth2-server::bundle.migrations', 'default').'/refresh_tokens'.EXT))
         {
            throw new Exception('Unable to load the migration details for the refresh_tokens table');
         }
         require $f;
      });
   }

   /**
    * Revert the changes to the database.
    *
    * @return void
    */
   public function down()
   {
      Schema::drop(Config::get('oauth2-server::bundle.tables.refresh_tokens', 'refresh_tokens'));
   }

}
