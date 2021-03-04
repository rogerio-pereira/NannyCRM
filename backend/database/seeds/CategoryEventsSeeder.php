<?php

use App\Models\CategoryEvent;
use Illuminate\Database\Seeder;

class CategoryEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CategoryEvent::class)->create(['name' => 'Reunião']);
        factory(CategoryEvent::class)->create(['name' => 'Trabalho']);
        factory(CategoryEvent::class)->create(['name' => 'Ligação']);
    }
}
