<?php

use Efed\Forum\Quote;

class ForumQuoteTest extends TestCase
{
    /**
     * Tear down.
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function put_together_a_quoted_forum_post()
    {
        $forumPostRepo = Mockery::mock('Efed\Contracts\Repositories\ForumPostRepository');
        $forumPostRepo->shouldReceive('get')->andReturn(['wrestler' => ['name' => 'John Doe']])->once();
        $post = "[quote=1]This is my quote.[/quote]<p>This is some text after the quote.</p>";
        $expected = "<p><em>Posted by John Doe</em></p><div class='well well-sm quote-container'>This is my quote.</div><p>This is some text after the quote.</p>";
        $quote = new Quote($forumPostRepo);
        $this->assertEquals($expected, $quote->handle($post));
    }
}
