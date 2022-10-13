<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create table
		 Schema::create('Books', function (Blueprint $table) {
//			$table->string('ID'); // plan change
			$table->increments('ID');
			$table->string('title');
			// initially, the plan ( not my plan tbh ) was to link the table to a json array of IDs
			// but that's error phrone so I'm ditchig that plan to go for a classical approach
//			$table->json('authors')->default(new Expression('(JSON_ARRAY())'));
			$table->float('price', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop table - if exists
		Schema::dropIfExists('Books');
    }
}
