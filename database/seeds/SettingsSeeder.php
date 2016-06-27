<?php

use Illuminate\Database\Seeder;

use Efed\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * @var Settings
     */
    private $model;

    /**
     * Start new SettingsSeeder.
     * 
     * @param Settings $model
     * @return void
     */
    public function __construct(Settings $model)
    {
        $this->model = $model;    
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->firstOrCreate([]);
    }
}
