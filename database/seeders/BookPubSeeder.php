<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookPubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // book 1
		DB::table('BookPub')->insert([ 'author_id' => 1, 'book_id' => 1, 'publisher_id' => 1 ]);
		DB::table('BookPub')->insert([ 'author_id' => 2, 'book_id' => 1, 'publisher_id' => 1 ]);
		DB::table('BookPub')->insert([ 'author_id' => 3, 'book_id' => 1, 'publisher_id' => 1 ]);
		// book 2
		DB::table('BookPub')->insert([ 'author_id' => 2, 'book_id' => 2, 'publisher_id' => 3 ]);
		// book 3
		DB::table('BookPub')->insert([ 'author_id' => 1, 'book_id' => 3, 'publisher_id' => 2 ]);
		DB::table('BookPub')->insert([ 'author_id' => 3, 'book_id' => 3, 'publisher_id' => 2 ]);
    }
}
