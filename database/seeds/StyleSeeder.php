<?php

use Illuminate\Database\Seeder;

use Efed\Models\Style;

class StyleSeeder extends Seeder
{
    /**
     * @var Style
     */
    private $model;

    /**
     * Start new Style.
     *
     * @param Style $model
     * @return void
     */
    public function __construct(Style $model)
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
        $attributes = [
            'name' => 'default',
            'primary1' => '000000',
            'primary2' => '333333',
            'secondary1' => 'ff0000',
            'secondary2' => '0000ff',
            'secondary3' => '000000',
            'secondary4' => 'eeeeee',
        ];
        $this->model->firstOrCreate($attributes);
    }
}
