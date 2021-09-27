<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // populate table with data
		DB::table('Authors')->insert([ 'first_name' => 'Jenny', 'last_name' => 'Tayla', ]);
		DB::table('Authors')->insert([ 'first_name' => 'Ben', 'last_name' => 'Dover', ]);
		DB::table('Authors')->insert([ 'first_name' => 'Connie', 'last_name' => 'Lingus', ]);
    }
}
