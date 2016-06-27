<?php

use Efed\Models\Wrestler;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminRosterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var $user
     */
    private $user;

    /**
     * @test
     */
    public function guest_cannot_view_admin_roster_pages()
    {
        // roster
        $this->call('GET', '/admin/roster');
        $this->assertRedirectedToRoute('signin');
        // applications
        $this->call('GET', '/admin/roster/applications');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function user_cannot_view_admin_roster_pages()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        // roster
        $this->call('GET', '/admin/roster');
        $this->assertRedirectedToRoute('home');
        // applications
        $this->call('GET', '/admin/roster/applications');
        $this->assertRedirectedToRoute('home');
    }
    
    /**
     * @test
     */
    public function admin_releases_wrestler()
    {
        $this->adminLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $input = [
            'id' => [$wrestler->id => $wrestler->id]
        ];
        $this->visit('/admin/roster')
             ->submitForm('Release', $input);
        $this->notSeeInDatabase('wrestler', [
            'id' => $wrestler->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * @test
     */
    public function staff_releases_wrestler()
    {
        $this->staffLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $input = [
            'id' => [$wrestler->id => $wrestler->id]
        ];
        $this->visit('/admin/roster')
            ->submitForm('Release', $input);
        $this->notSeeInDatabase('wrestler', [
            'id' => $wrestler->id,
            'deleted_at' => null,
        ]);
    }
    
    /**
     * @test
     */
    public function admin_accepts_application()
    {
        $this->adminLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create(['activated' => 0]);
        $input = [
            'id' => [$wrestler->id => $wrestler->id],
            'decide' => 'accept',
        ];
        $this->visit('/admin/roster/applications')
             ->submitForm('Submit', $input);
        $this->seeInDatabase('wrestler', [
            'id' => $wrestler->id,
            'activated' => 1,
        ]);
    }

    /**
     * @test
     */
    public function staff_accepts_application()
    {
        $this->staffLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create(['activated' => 0]);
        $input = [
            'id' => [$wrestler->id => $wrestler->id],
            'decide' => 'accept',
        ];
        $this->visit('/admin/roster/applications')
            ->submitForm('Submit', $input);
        $this->seeInDatabase('wrestler', [
            'id' => $wrestler->id,
            'activated' => 1,
        ]);
    }
    
    /**
     * @test
     */
    public function admin_declines_application()
    {
        $this->adminLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create(['activated' => 0]);
        $input = [
            'id' => [$wrestler->id => $wrestler->id],
            'decide' => 'decline',
        ];
        $this->visit('/admin/roster/applications')
            ->submitForm('Submit', $input);
        $this->notSeeInDatabase('wrestler', [
            'id' => $wrestler->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_declines_application()
    {
        $this->staffLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create(['activated' => 0]);
        $input = [
            'id' => [$wrestler->id => $wrestler->id],
            'decide' => 'decline',
        ];
        $this->visit('/admin/roster/applications')
            ->submitForm('Submit', $input);
        $this->notSeeInDatabase('wrestler', [
            'id' => $wrestler->id,
        ]);
    }

    /**
     * Admin is logged in.
     */
    private function adminLogIn()
    {
        $this->user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($this->user->id);
    }

    /**
     * Staff is logged in.
     */
    private function staffLogIn()
    {
        $this->user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($this->user->id);
        factory(Efed\Models\Staff::class)->create(['wrestler_id' => $this->user->id]);
    }
}
