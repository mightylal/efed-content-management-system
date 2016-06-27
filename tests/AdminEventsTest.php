<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminEventsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var $user
     */
    private $user;

    /**
     * @test
     */
    public function guest_cannot_view_admin_events()
    {
        // events
        $this->call('GET', '/admin/events');
        $this->assertRedirectedToRoute('signin');
        // book segment
        $this->call('GET', '/admin/events/segment/create');
        $this->assertRedirectedToRoute('signin');
        // event
        $event = factory(Efed\Models\Event::class)->create();
        $this->call('GET', '/admin/events/' . $event->id . '/edit');
        $this->assertRedirectedToRoute('signin');
        // segment
        $segment = factory(Efed\Models\Segment::class)->create();
        $this->call('GET', '/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function user_cannot_view_admin_events()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        // events
        $this->call('GET', '/admin/events');
        $this->assertRedirectedToRoute('home');
        // book segment
        $this->call('GET', '/admin/events/segment/create');
        $this->assertRedirectedToRoute('home');
        // event
        $event = factory(Efed\Models\Event::class)->create();
        $this->call('GET', '/admin/events/' . $event->id . '/edit');
        $this->assertRedirectedToRoute('home');
        // segment
        $segment = factory(Efed\Models\Segment::class)->create();
        $this->call('GET', '/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit');
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function admin_books_event()
    {
        $this->adminLogIn();
        $input = [
            'name' => 'Test Event Name',
            'scheduled_at' => '2030-05-05',
            'deadline_at' => '2030-05-04',
            'preview' => 'Event preview.'
        ];
        $this->visit('/admin/events')
             ->submitForm('Create', $input);
        $this->seeInDatabase('fedEvent', [
            'name' => 'Test Event Name',
            'scheduled_at' => '2030-05-05',
            'deadline_at' => '2030-05-04',
            'preview' => 'Event preview.',
        ]);
    }

    /**
     * @test
     */
    public function staff_books_event()
    {
        $this->staffLogIn();
        $input = [
            'name' => 'Test Event Name',
            'scheduled_at' => '2030-05-05',
            'deadline_at' => '2030-05-04',
            'preview' => 'Event preview.'
        ];
        $this->visit('/admin/events')
            ->submitForm('Create', $input);
        $this->seeInDatabase('fedEvent', [
            'name' => 'Test Event Name',
            'scheduled_at' => '2030-05-05',
            'deadline_at' => '2030-05-04',
            'preview' => 'Event preview.',
        ]);
    }

    /**
     * @test
     */
    public function admin_edits_event()
    {
        $this->adminLogIn();
        $event = factory(Efed\Models\Event::class)->create();
        $input = [
            'name' => 'Edit Test Event',
            'scheduled_at' => '2030-05-30',
            'preview' => 'Edit event preview.',
        ];
        $this->visit('/admin/events/' . $event->id . '/edit')
             ->submitForm('Update', $input);
        $this->seeInDatabase('fedEvent', [
            'name' => 'Edit Test Event',
            'scheduled_at' => '2030-05-30',
            'preview' => 'Edit event preview.',
        ]);
    }

    /**
     * @test
     */
    public function staff_edits_event()
    {
        $this->staffLogIn();
        $event = factory(Efed\Models\Event::class)->create();
        $input = [
            'name' => 'Edit Test Event',
            'scheduled_at' => '2030-05-30',
            'preview' => 'Edit event preview.',
        ];
        $this->visit('/admin/events/' . $event->id . '/edit')
            ->submitForm('Update', $input);
        $this->seeInDatabase('fedEvent', [
            'name' => 'Edit Test Event',
            'scheduled_at' => '2030-05-30',
            'preview' => 'Edit event preview.',
        ]);
    }

    /**
     * @test
     */
    public function admin_deletes_event()
    {
        $this->adminLogIn();
        $segment = factory(Efed\Models\Segment::class)->create();
        $input = [
            'id' => [$segment->event_id => $segment->event_id]
        ];
        $this->visit('/admin/events')
             ->submitForm('Delete', $input);
        $this->notSeeInDatabase('fedEvent', [
            'id' => $segment->event_id,
        ]);
        $this->notSeeInDatabase('eventSegment', [
            'id' => $segment->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_deletes_event()
    {
        $this->staffLogIn();
        $segment = factory(Efed\Models\Segment::class)->create();
        $input = [
            'id' => [$segment->event_id => $segment->event_id]
        ];
        $this->visit('/admin/events')
            ->submitForm('Delete', $input);
        $this->notSeeInDatabase('fedEvent', [
            'id' => $segment->event_id,
        ]);
        $this->notSeeInDatabase('eventSegment', [
            'id' => $segment->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_books_segment()
    {
        $this->adminLogIn();
        $event = factory(Efed\Models\Event::class)->create();
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $input = [
            'name' => 'Test Segment',
            'event_id' => $event->id,
            'type' => '1v1',
            'wrestler' => [$this->user->id, $wrestler->id],
        ];
        $this->visit('/admin/events/segment/create')
             ->submitForm('Create', $input);
        $this->seeInDatabase('eventSegment', [
            'name' => 'Test Segment',
            'event_id' => $event->id,
            'type' => '1v1',
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'wrestler_id' => $this->user->id,
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'wrestler_id' => $wrestler->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_books_segment()
    {
        $this->staffLogIn();
        $event = factory(Efed\Models\Event::class)->create();
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $input = [
            'name' => 'Test Segment',
            'event_id' => $event->id,
            'type' => '1v1',
            'wrestler' => [$this->user->id, $wrestler->id],
        ];
        $this->visit('/admin/events/segment/create')
            ->submitForm('Create', $input);
        $this->seeInDatabase('eventSegment', [
            'name' => 'Test Segment',
            'event_id' => $event->id,
            'type' => '1v1',
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'wrestler_id' => $this->user->id,
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'wrestler_id' => $wrestler->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_edits_segment()
    {
        $this->adminLogIn();
        $segment = factory(Efed\Models\Segment::class)->create(['type' => '1v1']);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $segmentWrestlerOne = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $this->user->id, 'team_id' => 1]);
        $segmentWrestlerTwo = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $wrestler->id, 'team_id' => 2]);
        $this->visit('/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit')
             ->type('Edit Segment', 'name')
             ->type(0, 'title_id')
             ->type($this->user->id, 'winner')
             ->type($wrestler->id, 'loser')
             ->type('These are some results.', 'result')
             ->press('Save');
        $this->seeInDatabase('eventSegment', [
            'id' => $segment->id,
            'title_id' => 0,
            'name' => 'Edit Segment',
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerOne->id,
            'winner' => 1,
            'loser' => 0,
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerTwo->id,
            'winner' => 0,
            'loser' => 1,
        ]);
    }

    /**
     * @test
     */
    public function staff_edits_segment()
    {
        $this->staffLogIn();
        $segment = factory(Efed\Models\Segment::class)->create(['type' => '1v1']);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $segmentWrestlerOne = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $this->user->id, 'team_id' => 1]);
        $segmentWrestlerTwo = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $wrestler->id, 'team_id' => 2]);
        $this->visit('/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit')
            ->type('Edit Segment', 'name')
            ->type(0, 'title_id')
            ->type($this->user->id, 'winner')
            ->type($wrestler->id, 'loser')
            ->type('These are some results.', 'result')
            ->press('Save');
        $this->seeInDatabase('eventSegment', [
            'id' => $segment->id,
            'title_id' => 0,
            'name' => 'Edit Segment',
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerOne->id,
            'winner' => 1,
            'loser' => 0,
        ]);
        $this->seeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerTwo->id,
            'winner' => 0,
            'loser' => 1,
        ]);
    }

    /**
     * @test
     */
    public function admin_deletes_segment()
    {
        $this->adminLogIn();
        $segment = factory(Efed\Models\Segment::class)->create(['type' => '1v1']);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $segmentWrestlerOne = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $this->user->id, 'team_id' => 1]);
        $segmentWrestlerTwo = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $wrestler->id, 'team_id' => 2]);

        $this->visit('/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit')
             ->press('Remove');
        $this->notSeeInDatabase('eventSegment', [
            'id' => $segment->id,
        ]);
        $this->notSeeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerOne->id,
        ]);
        $this->notSeeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerTwo->id,
        ]);
    }

    /**
     * @test
     */
    public function staff_deletes_segment()
    {
        $this->staffLogIn();
        $segment = factory(Efed\Models\Segment::class)->create(['type' => '1v1']);
        $wrestler = factory(Efed\Models\Wrestler::class)->create();
        $segmentWrestlerOne = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $this->user->id, 'team_id' => 1]);
        $segmentWrestlerTwo = factory(Efed\Models\SegmentWrestler::class)->create(['segment_id' => $segment->id, 'wrestler_id' => $wrestler->id, 'team_id' => 2]);

        $this->visit('/admin/events/' . $segment->event_id . '/segment/' . $segment->id . '/edit')
            ->press('Remove');
        $this->notSeeInDatabase('eventSegment', [
            'id' => $segment->id,
        ]);
        $this->notSeeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerOne->id,
        ]);
        $this->notSeeInDatabase('eventSegmentWrestler', [
            'id' => $segmentWrestlerTwo->id,
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
