<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
		DB::table('Publishers')->insert([ 'name' => 'AnalTech' ]);
		DB::table('Publishers')->insert([ 'name' => 'McJunkin' ]);
		DB::table('Publishers')->insert([ 'name' => 'Cockram' ]);
    }
}
