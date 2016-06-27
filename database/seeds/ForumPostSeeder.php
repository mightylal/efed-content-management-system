<?php

use Illuminate\Database\Seeder;

class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Efed\Models\ForumPost::class, 50)->create();
    }
}
