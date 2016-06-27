<?php

use Illuminate\Database\Seeder;

use Efed\Models\Wrestler;

class WrestlerSeeder extends Seeder
{
    /**
     * @var Wrestler
     */
    private $model;

    /**
     * Start new Wrestler.
     *
     * @param Wrestler $model
     * @return void
     */
    public function __construct(Wrestler $model)
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
            'name' => 'Ronnie Rockovich',
            'username' => 'lal',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'slug' => 'ronnie-rockovich',
            'age' => 25,
            'gender' => 'Male',
            'height' => '6ft 1in',
            'weight' => 230,
            'bio' => 'This is a bio.',
            'activated' => 1,
            'admin' => 1
        ];
        $this->model->firstOrCreate($attributes);
    }
}
