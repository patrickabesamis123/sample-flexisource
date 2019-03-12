<?php

use Illuminate\Database\Seeder;

class SalutationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Salutation::class, 50)->create();
    }
}
