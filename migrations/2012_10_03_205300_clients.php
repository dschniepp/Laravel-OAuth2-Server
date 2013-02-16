<?php

class Oauth2_Server_Clients {

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
      Schema::create(Config::get('oauth2-server::bundle.tables.clients', 'clients'), function($table)
      {
         if ( ! file_exists($f = __DIR__.'/'.Config::get('oauth2-server::bundle.migrations', 'default').'/clients'.EXT))
         {
            throw new Exception('Unable to load the migration details for the clients table');
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
      Schema::drop(Config::get('oauth2-server::bundle.tables.clients', 'clients'));
   }

}
