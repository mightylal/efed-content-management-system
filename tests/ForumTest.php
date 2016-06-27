<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ForumTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var $user
     */
    private $user;

    /**
     * @test
     */
    public function guest_cannot_edit_post()
    {
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id]);
        $this->call('GET', '/forum/' . $topic->category_id . '/topic/' . $topic->id . '/post/' . $post->id . '/edit');
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function non_activated_user_cannot_edit_post()
    {
        $user = factory(Efed\Models\Wrestler::class)->create(['activated' => 0]);
        Auth::loginUsingId($user->id);
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id]);
        $this->call('GET', '/forum/' . $topic->category_id . '/topic/' . $topic->id . '/post/' . $post->id . '/edit');
        $this->assertRedirectedToRoute('home');
    }

    /**
     * @test
     */
    public function user_creates_topic()
    {
        $user = $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $forum = factory(Efed\Models\Forum::class)->create();
        $this->visit('/forum/' . $forum->id)
             ->type('Test Topic', 'name')
             ->type('Test post.', 'post')
             ->press('Create');
        $this->seeInDatabase('forumTopic', [
            'wrestler_id' => $user->id,
            'name' => 'Test Topic',
        ]);
    }

    /**
     * @test
     */
    public function user_creates_reply()
    {
        $user = $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
             ->type('This is a post.', 'post')
             ->press('Create');
        $this->seeInDatabase('forumPost', [
            'topic_id' => $topic->id,
            'wrestler_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function user_edits_post()
    {
        $user = $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id . '/post/' . $post->id . '/edit')
             ->type('This is an edit.', 'post')
             ->press('Submit');
        $this->seeInDatabase('forumPost', [
            'id' => $post->id,
        ]);
    }

    /**
     * @test
     */
    public function admin_locks_topic()
    {
        $this->adminLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
             ->click('Lock');
        $this->seeInDatabase('forumTopic', [
            'locked' => 1,
        ]);
    }

    /**
     * @test
     */
    public function staff_locks_topic()
    {
        $this->staffLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Lock');
        $this->seeInDatabase('forumTopic', [
            'locked' => 1,
        ]);
    }

    /**
     * @test
     */
    public function admin_unlocks_topic()
    {
        $this->adminLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create(['locked' => 1]);
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Unlock');
        $this->seeInDatabase('forumTopic', [
            'locked' => 0,
        ]);
    }

    /**
     * @test
     */
    public function staff_unlocks_topic()
    {
        $this->staffLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create(['locked' => 1]);
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Unlock');
        $this->seeInDatabase('forumTopic', [
            'locked' => 0,
        ]);
    }

    /**
     * @test
     */
    public function admin_pins_topic()
    {
        $this->adminLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Pin');
        $this->seeInDatabase('forumTopic', [
            'pinned' => 1,
        ]);
    }

    /**
     * @test
     */
    public function staff_pins_topic()
    {
        $this->staffLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create();
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Pin');
        $this->seeInDatabase('forumTopic', [
            'pinned' => 1,
        ]);
    }

    /**
     * @test
     */
    public function admin_unpins_topic()
    {
        $this->adminLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create(['pinned' => 1]);
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Unpin');
        $this->seeInDatabase('forumTopic', [
            'pinned' => 0,
        ]);
    }

    /**
     * @test
     */
    public function staff_unpins_topic()
    {
        $this->staffLogIn();
        $topic = factory(Efed\Models\ForumTopic::class)->create(['pinned' => 1]);
        $post = factory(Efed\Models\ForumPost::class)->create(['topic_id' => $topic->id, 'wrestler_id' => $this->user->id]);
        $this->visit('/forum/' . $topic->category_id . '/topic/' . $topic->id)
            ->click('Unpin');
        $this->seeInDatabase('forumTopic', [
            'pinned' => 0,
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