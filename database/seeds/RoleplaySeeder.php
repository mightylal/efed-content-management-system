<?php

use Illuminate\Database\Seeder;

class RoleplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Efed\Models\Roleplay::class, 50)->create();
    }
}
