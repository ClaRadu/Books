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
            $table->string('ID');
//			$table->increments('ID');
			$table->string('title');
//			$table->json('authors')->default(new Expression('(JSON_ARRAY())'));
			$table->string('authors'); // plan change
			$table->int('publisher_id');
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
