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
		DB::table('Books')->insert([ 'title' => 'OOP Principles', 'publisher_id' => 1, 'authors' => '1,2,3']);
		DB::table('Books')->insert([ 'title' => 'REST Api - the basics', 'publisher_id' => 3, 'authors' => '2']);
		DB::table('Books')->insert([ 'title' => 'Making IT exciting', 'publisher_id' => 2, 'authors' => '1,3']);
    }
}
