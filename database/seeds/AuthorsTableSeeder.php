<?php

use Illuminate\Database\Seeder;
use App\Models\authors;
class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(authors::class,10)->create();
    }
}
