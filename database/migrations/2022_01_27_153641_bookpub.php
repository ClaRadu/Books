<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Bookpub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		// create table
		Schema::create('BookPub', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('author_id');
			$table->integer('book_id');
			$table->integer('publisher_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
		Schema::dropIfExists('BookPub'); // drop table - if exists
    }
}
