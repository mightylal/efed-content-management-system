<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleplayTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function guest_cannot_create_a_roleplay()
    {
        // create roleplay
        $this->call('GET', '/roleplays/create');
        $this->assertRedirectedToRoute('signin');
        // edit roleplay
        $roleplay = factory(Efed\Models\Roleplay::class)->create();
        $this->call('GET', '/roleplays/' . $roleplay->id . '/edit');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function user_cannot_edit_someone_elses_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $roleplay = factory(Efed\Models\Roleplay::class)->create();
        $this->call('GET', '/roleplays/' . $roleplay->id . '/edit');
        $this->assertRedirectedToRoute('roleplays');
    }
    
    /**
     * @test
     */
    public function user_creates_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $event = factory(Efed\Models\Event::class)->create(['deadline_at' => date('Y-m-d')]);
        factory(Efed\Models\Settings::class)->create();
        $this->visit('/roleplays/create')
             ->select($event->id, 'event_id')
             ->type('Test Roleplay', 'name')
             ->type('Test roleplay body.', 'rp')
             ->press('Submit');
        $this->seeInDatabase('fedRp', [
            'wrestler_id' => $user->id,
            'event_id' => $event->id,
            'name' => 'Test Roleplay',
        ]);
    }

    /**
     * @test
     */
    public function user_edits_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $roleplay = factory(Efed\Models\Roleplay::class)->create(['wrestler_id' => $user->id]);
        $this->visit('/roleplays/' . $roleplay->id . '/edit')
             ->type('Edit Roleplay Title', 'name')
             ->type('This is an edited rp.', 'rp')
             ->press('Update');
        $this->seeInDatabase('fedRp', [
            'id' => $roleplay->id,
            'name' => 'Edit Roleplay Title',
        ]);
    }

    /**
     * @test
     */
    public function user_grades_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $roleplay = factory(Efed\Models\Roleplay::class)->create();
        factory(Efed\Models\Settings::class)->create(['gradeRights' => 'Everyone']);
        $input = [
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ];
        $this->visit('/roleplays/' . $roleplay->id)
             ->submitForm('Submit', $input);
        $this->seeInDatabase('rpGrade', [
            'rp_id' => $roleplay->id,
            'wrestler_id' => $user->id,
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ]);
    }

    /**
     * @test
     */
    public function admin_can_grade_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['admin' => 1]);
        Auth::loginUsingId($user->id);
        $roleplay = factory(Efed\Models\Roleplay::class)->create();
        factory(Efed\Models\Settings::class)->create(['gradeRights' => 'Staff']);
        $input = [
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ];
        $this->visit('/roleplays/' . $roleplay->id)
            ->submitForm('Submit', $input);
        $this->seeInDatabase('rpGrade', [
            'rp_id' => $roleplay->id,
            'wrestler_id' => $user->id,
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ]);
    }

    /**
     * @test
     */
    public function staff_can_grade_roleplay()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        factory(Efed\Models\Staff::class)->create(['wrestler_id' => $user->id]);
        $roleplay = factory(Efed\Models\Roleplay::class)->create();
        factory(Efed\Models\Settings::class)->create(['gradeRights' => 'Staff']);
        $input = [
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ];
        $this->visit('/roleplays/' . $roleplay->id)
            ->submitForm('Submit', $input);
        $this->seeInDatabase('rpGrade', [
            'rp_id' => $roleplay->id,
            'wrestler_id' => $user->id,
            'fed_grade' => 6,
            'comment' => 'This is a comment.',
        ]);
    }
}
