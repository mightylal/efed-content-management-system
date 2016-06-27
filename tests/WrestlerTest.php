<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WrestlerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function guest_cannot_edit_wrestler()
    {
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $this->call('GET', '/roster/' . $wrestler->slug . '/edit');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function user_cannot_edit_someone_elses_wrestler()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $this->call('GET', '/roster/' . $wrestler->slug . '/edit');
        $this->assertRedirectedToRoute('home');
    }
    
    /**
     * @test
     */
    public function user_edits_wrestler()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $this->visit('/roster/' . $user->slug . '/edit')
             ->type('Test Wrestler', 'name')
             ->type('28', 'age')
             ->select('Male', 'gender')
             ->type('6 feet 1 in', 'height')
             ->type(225, 'weight')
             ->type('This is a bio.', 'bio')
             ->press('Edit');
        $this->seeInDatabase('wrestler', [
            'id' => $user->id,
            'name' => 'Test Wrestler',
            'slug' => 'test-wrestler',
            'age' => 28,
            'gender' => 'Male',
            'height' => '6 feet 1 in',
            'weight' => 225,
        ]);
    }

    /**
     * @test
     */
    public function wrestler_does_not_exist()
    {
        $this->call('GET', '/roster/test-wrestler');
        $this->assertRedirectedToRoute('home');
    }
}
