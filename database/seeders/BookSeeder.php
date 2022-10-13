<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('Books')->insert([ 'title' => 'OOP Principles', 'price' => 10.5 ]);
		DB::table('Books')->insert([ 'title' => 'REST Api - the basics', 'price' => 2 ]);
		DB::table('Books')->insert([ 'title' => 'Making IT exciting', 'price' => 5.25 ]);
    }
}
