<?php

use Illuminate\Database\Seeder;

class CalendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Calender::class, 50)->create();
    }
}
