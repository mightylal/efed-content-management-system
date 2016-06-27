<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditPageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function admin_edits_home_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($user->id);
        $this->visit('/edit')
             ->type('This is some text', 'home')
             ->press('Submit Changes');
        $this->visit('/')
             ->see('This is some text');
    }

    /**
     * @test
     */
    public function staff_edits_home_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        factory(Efed\Models\Staff::class)->create(['wrestler_id' => $user->id]);
        $this->visit('/edit')
            ->type('This is some text', 'home')
            ->press('Submit Changes');
        $this->visit('/')
            ->see('This is some text');
    }
    
    /**
     * @test
     */
    public function admin_edits_a_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create();
        $this->visit('/pages/' . $page->id . '/edit')
             ->type('A page title', 'name')
             ->select('Everyone', 'access')
             ->type('This is some text.', 'content')
             ->press('Submit Changes');
        $this->visit('/pages/' . $page->id)
             ->see('This is some text.');
    }

    /**
     * @test
     */
    public function staff_edits_a_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        factory(Efed\Models\Staff::class)->create(['wrestler_id' => $user->id]);
        $page = factory(Efed\Models\Page::class)->create();
        $this->visit('/pages/' . $page->id . '/edit')
            ->type('A page title', 'name')
            ->select('Everyone', 'access')
            ->type('This is some text.', 'content')
            ->press('Submit Changes');
        $this->visit('/pages/' . $page->id)
            ->see('This is some text.');
    }

    /**
     * @test
     */
    public function delete_a_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create();
        $this->visit('/pages/' . $page->id . '/edit')
             ->press('Delete');
        $this->notSeeInDatabase('fedPage', ['id' => $page->id]);
    }

    /**
     * @test
     */
    public function user_cannot_view_a_staff_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create(['access' => 'Staff']);
        $this->call('GET', '/pages/' . $page->id);
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function guest_cannot_view_a_staff_page()
    {
        $page = factory(Efed\Models\Page::class)->create(['access' => 'Staff']);
        $this->call('GET', '/pages/' . $page->id);
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function admin_can_view_a_staff_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create(['access' => 'Staff']);
        $this->visit('/pages/'. $page->id)
             ->see($page->content);
    }

    /**
     * @test
     */
    public function staff_can_view_a_staff_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        factory(Efed\Models\Staff::class)->create(['wrestler_id' => $user->id]);
        $page = factory(Efed\Models\Page::class)->create(['access' => 'Staff']);
        $this->visit('/pages/'. $page->id)
            ->see($page->content);
    }

    /**
     * @test
     */
    public function user_cannot_edit_a_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create();
        $this->call('GET', '/pages/' . $page->id . '/edit');
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function user_cannot_edit_home_page()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $page = factory(Efed\Models\Page::class)->create();
        $this->call('GET', '/edit');
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function guest_cannot_edit_a_page()
    {
        $page = factory(Efed\Models\Page::class)->create();
        $this->call('GET', '/pages/' . $page->id . '/edit');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function guest_cannot_edit_home_page()
    {
        $page = factory(Efed\Models\Page::class)->create();
        $this->call('GET', '/edit');
        $this->assertRedirectedToRoute('signin');
    }
}
