<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminControlPanelTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * @var $user
     */
    private $user;
    
    /**
     * @test
     */
    public function guest_cannot_view_control_panel()
    {
        // settings
        $this->call('GET', '/admin/settings');
        $this->redirectToSignIn();
        // titles
        $this->call('GET', '/admin/titles');
        $this->redirectToSignIn();
        // title
        $title = factory(Efed\Models\Title::class)->create();
        $this->call('GET', '/admin/titles/' . $title->id . '/edit');
        $this->redirectToSignIn();
        // design
        $this->call('GET', '/admin/design');
        $this->redirectToSignIn();
        // pages
        $this->call('GET', '/admin/pages/');
        $this->redirectToSignIn();
        // forum
        $this->call('GET', '/admin/forum');
        $this->redirectToSignIn();
        // category
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->call('GET', '/admin/forum/' . $forum->id . '/edit');
        $this->redirectToSignIn();
        // staff
        $this->call('GET', '/admin/staff');
        $this->redirectToSignIn();

    }

    /**
     * @test
     */
    public function user_cannot_view_control_panel()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        // settings
        $this->call('GET', '/admin/settings');
        $this->redirectToHome();
        // titles
        $this->call('GET', '/admin/titles');
        $this->redirectToHome();
        // title
        $title = factory(Efed\Models\Title::class)->create();
        $this->call('GET', '/admin/titles/' . $title->id . '/edit');
        $this->redirectToHome();
        // design
        $this->call('GET', '/admin/design');
        $this->redirectToHome();
        // pages
        $this->call('GET', '/admin/pages/');
        $this->redirectToHome();
        // forum
        $this->call('GET', '/admin/forum');
        $this->redirectToHome();
        // category
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->call('GET', '/admin/forum/' . $forum->id . '/edit');
        $this->redirectToHome();
        // staff
        $this->call('GET', '/admin/staff');
        $this->redirectToHome();

    }

    /**
     * @test
     */
    public function admin_edits_settings()
    {
        $this->adminLogIn();
        factory(Efed\Models\Settings::class)->create();
        $this->visit('/admin/settings')
             ->select(10, 'roleplayLimit')
             ->select('Everyone', 'gradeRights')
             ->press('Update');
        $this->seeInDatabase('settings', [
            'roleplayLimit' => 10,
            'gradeRights' => 'Everyone',
        ]);
    }

    /**
     * @test
     */
    public function staff_edits_settings()
    {
        $this->staffLogIn();
        factory(Efed\Models\Settings::class)->create();
        $this->visit('/admin/settings')
            ->select(10, 'roleplayLimit')
            ->select('Everyone', 'gradeRights')
            ->press('Update');
        $this->seeInDatabase('settings', [
            'roleplayLimit' => 10,
            'gradeRights' => 'Everyone',
        ]);
    }

    /**
     * @test
     */
    public function admin_creates_title()
    {
        $this->adminLogIn();
        $this->visit('/admin/titles')
             ->type('Test Wrestling Title', 'name')
             ->select('Single', 'type')
             ->press('Create');
        $this->seeInDatabase('fedTitle', [
            'name' => 'Test Wrestling Title',
            'type' => 'Single',
        ]);
    }

    /**
     * @test
     */
    public function staff_creates_title()
    {
        $this->staffLogIn();
        $this->visit('/admin/titles')
            ->type('Test Wrestling Title', 'name')
            ->select('Single', 'type')
            ->press('Create');
        $this->seeInDatabase('fedTitle', [
            'name' => 'Test Wrestling Title',
            'type' => 'Single',
        ]);
    }

    /**
     * @test
     */
    public function admin_edits_title()
    {
        $this->adminLogIn();
        $title = factory(Efed\Models\Title::class)->create();
        $titleReign = factory(Efed\Models\TitleReign::class)->create(['title_id' => $title->id]);
        $input = [
            'name' => 'Test Wrestling Championship',
            'doAssign' => 'yes',
            'assign' => [$this->user->id]
        ];
        $this->visit('/admin/titles/' . $title->id . '/edit')
             ->submitForm('Update', $input);
        $this->seeInDatabase('fedTitle', [
            'name' => 'Test Wrestling Championship',
        ]);
        $this->seeInDatabase('fedTitleReign', [
            'title_id' => $title->id,
            'wrestler_id_one' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_edits_tag_team_title()
    {
        $this->adminLogIn();
        $title = factory(Efed\Models\Title::class)->create(['type' => 'Tag Team']);
        $titleReign = factory(Efed\Models\TitleReign::class)->create(['title_id' => $title->id]);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $input = [
            'name' => 'Test Wrestling Championship',
            'doAssign' => 'yes',
            'assign' => [$this->user->id, $wrestler->id]
        ];
        $this->visit('/admin/titles/' . $title->id . '/edit')
            ->submitForm('Update', $input);
        $this->seeInDatabase('fedTitle', [
            'name' => 'Test Wrestling Championship',
        ]);
        $this->seeInDatabase('fedTitleReign', [
            'title_id' => $title->id,
            'wrestler_id_one' => $this->user->id,
            'wrestler_id_two' => $wrestler->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_edits_title()
    {
        $this->staffLogIn();
        $title = factory(Efed\Models\Title::class)->create();
        $titleReign = factory(Efed\Models\TitleReign::class)->create(['title_id' => $title->id]);
        $input = [
            'name' => 'Test Wrestling Championship',
            'doAssign' => 'yes',
            'assign' => [$this->user->id]
        ];
        $this->visit('/admin/titles/' . $title->id . '/edit')
            ->submitForm('Update', $input);
        $this->seeInDatabase('fedTitle', [
            'name' => 'Test Wrestling Championship',
        ]);
        $this->seeInDatabase('fedTitleReign', [
            'title_id' => $title->id,
            'wrestler_id_one' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_deletes_title()
    {
        $this->adminLogIn();
        $title = factory(Efed\Models\Title::class)->create();
        $titleReign = factory(Efed\Models\TitleReign::class)->create(['title_id' => $title->id]);
        $this->visit('/admin/titles/' . $title->id . '/edit')
             ->press('Delete');
        $this->notSeeInDatabase('fedTitle', [
            'id' => $title->id,
        ]);
        $this->notSeeInDatabase('fedTitleReign', [
            'id' => $titleReign->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_deletes_title()
    {
        $this->staffLogIn();
        $title = factory(Efed\Models\Title::class)->create();
        $titleReign = factory(Efed\Models\TitleReign::class)->create(['title_id' => $title->id]);
        $this->visit('/admin/titles/' . $title->id . '/edit')
            ->press('Delete');
        $this->notSeeInDatabase('fedTitle', [
            'id' => $title->id,
        ]);
        $this->notSeeInDatabase('fedTitleReign', [
            'id' => $titleReign->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_edits_design()
    {
        $this->adminLogIn();
        factory(Efed\Models\Style::class)->create();
        $this->visit('/admin/design')
             ->type('CC0000', 'primary1')
             ->type('FF0000', 'primary2')
             ->type('EEE588', 'secondary1')
             ->type('UF8909', 'secondary2')
             ->type('789FF0', 'secondary3')
             ->type('FFF909', 'secondary4')
             ->press('Update');
        $this->seeInDatabase('fedStyle', [
            'primary1' => 'CC0000',
            'primary2' => 'FF0000',
            'secondary1' => 'EEE588',
            'secondary2' => 'UF8909',
            'secondary3' => '789FF0',
            'secondary4' => 'FFF909',
        ]);
    }

    /**
     * @test
     */
    public function staff_edits_design()
    {
        $this->staffLogIn();
        factory(Efed\Models\Style::class)->create();
        $this->visit('/admin/design')
            ->type('CC0000', 'primary1')
            ->type('FF0000', 'primary2')
            ->type('EEE588', 'secondary1')
            ->type('UF8909', 'secondary2')
            ->type('789FF0', 'secondary3')
            ->type('FFF909', 'secondary4')
            ->press('Update');
        $this->seeInDatabase('fedStyle', [
            'primary1' => 'CC0000',
            'primary2' => 'FF0000',
            'secondary1' => 'EEE588',
            'secondary2' => 'UF8909',
            'secondary3' => '789FF0',
            'secondary4' => 'FFF909',
        ]);
    }

    /**
     * @test
     */
    public function admin_creates_page()
    {
        $this->adminLogIn();
        $this->visit('/admin/pages')
             ->type('Testing Page', 'name')
             ->select('Everyone', 'access')
             ->press('Create');
        $this->seeInDatabase('fedPage', [
            'name' => 'Testing Page',
            'access' => 'Everyone',
        ]);
    }

    /**
     * @test
     */
    public function staff_creates_page()
    {
        $this->staffLogIn();
        $this->visit('/admin/pages')
            ->type('Testing Page', 'name')
            ->select('Everyone', 'access')
            ->press('Create');
        $this->seeInDatabase('fedPage', [
            'name' => 'Testing Page',
            'access' => 'Everyone',
        ]);
    }
    
    /**
     * @test
     */
    public function admin_creates_forum()
    {
        $this->adminLogIn();
        $this->visit('/admin/forum')
             ->type('Category Test', 'name')
             ->type('Category description goes here.', 'description')
             ->select('Everyone', 'access')
             ->select('Everyone', 'posting')
             ->press('Create');
        $this->seeInDatabase('forum', [
            'name' => 'Category Test',
            'description' => 'Category description goes here.',
            'access' => 'Everyone',
            'posting' => 'Everyone',
        ]);
        $this->see('Forum created successfully.');
    }

    /**
     * @test
     */
    public function staff_creates_forum()
    {
        $this->staffLogIn();
        $this->visit('/admin/forum')
            ->type('Category Test', 'name')
            ->type('Category description goes here.', 'description')
            ->select('Everyone', 'access')
            ->select('Everyone', 'posting')
            ->press('Create');
        $this->seeInDatabase('forum', [
            'name' => 'Category Test',
            'description' => 'Category description goes here.',
            'access' => 'Everyone',
            'posting' => 'Everyone',
        ]);
        $this->see('Forum created successfully.');
    }
    
    /**
     * @test
     */
    public function admin_edits_forum()
    {
        $this->adminLogIn();
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->visit('/admin/forum/' . $forum->id . '/edit')
             ->type('Category Testing Forum', 'name')
             ->press('Update');
        $this->seeInDatabase('forum', [
            'name' => 'Category Testing Forum',
        ]);
        $this->see('Forum updated successfully.');
    }

    /**
     * @test
     */
    public function staff_edits_forum()
    {
        $this->staffLogIn();
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->visit('/admin/forum/' . $forum->id . '/edit')
            ->type('Category Testing Forum', 'name')
            ->press('Update');
        $this->seeInDatabase('forum', [
            'name' => 'Category Testing Forum',
        ]);
        $this->see('Forum updated successfully.');
    }
    
    /**
     * @test
     */
    public function admin_deletes_forum()
    {
        $this->adminLogIn();
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->visit('/admin/forum/' . $forum->id . '/edit')
             ->press('Delete');
        $this->notSeeInDatabase('forum', [
            'id' => $forum->id,
        ]);
        $this->see('Forum deleted successfully.');
    }

    /**
     * @test
     */
    public function staff_deletes_forum()
    {
        $this->staffLogIn();
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->visit('/admin/forum/' . $forum->id . '/edit')
            ->press('Delete');
        $this->notSeeInDatabase('forum', [
            'id' => $forum->id,
        ]);
        $this->see('Forum deleted successfully.');
    }

    /**
     * @test
     */
    public function staff_cannot_view_staff_page()
    {
        $this->staffLogIn();
        $this->call('GET', '/admin/staff');
        $this->redirectToHome();
    }

    /**
     * @test
     */
    public function admin_adds_staff()
    {
        $this->adminLogIn();
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $this->visit('/admin/staff')
             ->type($wrestler->name, 'name')
             ->press('Add');
        $this->seeInDatabase('fedStaff', [
            'wrestler_id' => $wrestler->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_removes_staff()
    {
        $this->adminLogIn();
        $staff = factory(Efed\Models\Staff::class)->create();
        $input = [
            'id' => [$staff->id => $staff->id],
        ];
        $this->visit('/admin/staff')
             ->submitForm('Remove', $input);
        $this->notSeeInDatabase('fedStaff', [
            'id' => $staff->id
        ]);
    }

    /**
     * Assert redirect to sign in route.
     */
    private function redirectToSignIn()
    {
        return $this->assertRedirectedToRoute('signin');
    }

    /**
     * Assert redirect to home route.
     */
    private function redirectToHome()
    {
        return $this->assertRedirectedToRoute('home');
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
