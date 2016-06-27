<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function guest_cannot_see_messages()
    {
        // messages
        $this->call('GET', '/messages');
        $this->assertRedirectedToRoute('signin');
        // message
        $messageBody = factory(Efed\Models\MessageBody::class)->create(['wrestler_id' => 1]);
        $messageOneWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => 1]);
        $messageTwoWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => 2]);
        $this->call('GET', '/messages/' . $messageBody->message_id);
        $this->assertRedirectedToRoute('signin');
    }

    /**
     * @test
     */
    public function user_creates_a_message()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        $userTo = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $this->visit('/messages/create')
             ->type($userTo->name, 'name')
             ->type('Random Subject', 'subject')
             ->type('Random Message', 'message')
             ->press('Create');
        $this->seeInDatabase('message', [
            'subject' => 'Random Subject'
        ]);
        $this->seeInDatabase('messageBody', [
            'wrestler_id' => $user->id,
        ]);
        $this->seeInDatabase('messageWrestler', [
            'wrestler_id' => $user->id
        ]);
        $this->seeInDatabase('messageWrestler', [
            'wrestler_id' => $userTo->id
        ]);
    }
    
    /**
     * @test
     */
    public function user_replies_to_a_message()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $userTo = factory(Efed\Models\Wrestler::class)->create();
        $messageBody = factory(Efed\Models\MessageBody::class)->create(['wrestler_id' => $userTo->id]);
        $messageOneWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $user->id]);
        $messageTwoWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $userTo->id]);
        $this->visit('/messages/' . $messageBody->message_id)
             ->type('This is a test message.', 'message')
             ->press('Send');
        $this->seeInDatabase('messageBody', [
            'message_id' => $messageBody->message_id,
            'wrestler_id' => $user->id,
        ]);
    }

    // delete message
    /**
     * @test
     */
    public function user_deletes_a_message()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $userTo = factory(Efed\Models\Wrestler::class)->create();
        $messageBody = factory(Efed\Models\MessageBody::class)->create(['wrestler_id' => $userTo->id]);
        $messageOneWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $user->id]);
        $messageTwoWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $userTo->id]);
        $input = [
            'id' => [$messageBody->message_id => $messageBody->message_id]
        ];
        $this->visit('/messages')
             ->submitForm('Delete', $input);
        $this->notSeeInDatabase('messageWrestler', [
            'id' => $messageOneWrestler->id,
            'deleted_at' => null,
        ]);
    }

    // user must be in message to view message
    /**
     * @test
     */
    public function user_must_be_in_message_to_view()
    {
        $user = factory(Efed\Models\Wrestler::class)->create();
        $userTwo = factory(Efed\Models\Wrestler::class)->create();
        $userThree = factory(Efed\Models\Wrestler::class)->create();
        Auth::loginUsingId($user->id);
        $userTo = factory(Efed\Models\Wrestler::class)->create();
        $messageBody = factory(Efed\Models\MessageBody::class)->create(['wrestler_id' => $userTwo->id]);
        $messageOneWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $userTwo->id]);
        $messageTwoWrestler = factory(Efed\Models\MessageWrestler::class)->create(['message_id' => $messageBody->message_id, 'wrestler_id' => $userThree->id]);
        $this->call('GET', '/messages/' . $messageBody->message_id);
        $this->assertRedirectedToRoute('messages');
    }
}
