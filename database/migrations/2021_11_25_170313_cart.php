<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create table cart
		 Schema::create('Cart', function (Blueprint $table) {
            $table->increments('id');
			$table->string('book_id');
			$table->integer('qtty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
	 * drop table, if the case
     */
    public function down() { Schema::dropIfExists('Authors'); }
}
