<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
/*		$this->call(AuthorSeeder::class);
		$this->call(BookSeeder::class);
		$this->call(PublisherSeeder::class); */
		
		$as = new AuthorSeeder();
		$as->run();
		$bs = new BookSeeder();
		$bs->run();
		$ps = new PublisherSeeder();
		$ps->run();
		$sh = new BookPubSeeder();
		$sh->run();
    }
}
