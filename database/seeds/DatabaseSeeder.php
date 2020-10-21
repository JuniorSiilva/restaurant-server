<?php

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
        factory(App\Models\Category::class, 30)->create();

        factory(App\Models\Table::class, 10)->create();
    }
}
