<?php

use Efed\Segment\WrestlersInSegment;

class WrestlersInSegmentTest extends TestCase
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
     * @expectedException Efed\Exceptions\ValidationException
     */
    public function winner_is_not_in_match()
    {
        $segmentWrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\SegmentWrestlerRepository');
        $segmentWrestlerRepo->shouldReceive('exists')->andReturn(false, false)->twice();
        $segmentWrestlerRepo->shouldReceive('differentTeams')->andReturn(false)->once();
        (new WrestlersInSegment($segmentWrestlerRepo))->check(1, 1, 2);
    }

    /**
     * @test
     * @expectedException Efed\Exceptions\ValidationException
     */
    public function loser_is_not_in_match()
    {
        $segmentWrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\SegmentWrestlerRepository');
        $segmentWrestlerRepo->shouldReceive('exists')->andReturn(false, false)->twice();
        $segmentWrestlerRepo->shouldReceive('differentTeams')->andReturn(false)->once();
        (new WrestlersInSegment($segmentWrestlerRepo))->check(1, 1, 2);
    }

    /**
     * @test
     * @expectedException Efed\Exceptions\ValidationException
     */
    public function winner_and_loser_are_on_same_teams()
    {
        $segmentWrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\SegmentWrestlerRepository');
        $segmentWrestlerRepo->shouldReceive('exists')->andReturn(true, true)->twice();
        $segmentWrestlerRepo->shouldReceive('differentTeams')->andReturn(false)->once();
        (new WrestlersInSegment($segmentWrestlerRepo))->check(1, 1, 2);
    }

    /**
     * @test
     */
    public function match_is_legit()
    {
        $segmentWrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\SegmentWrestlerRepository');
        $segmentWrestlerRepo->shouldReceive('exists')->andReturn(true, true)->twice();
        $segmentWrestlerRepo->shouldReceive('differentTeams')->andReturn(true)->once();
        (new WrestlersInSegment($segmentWrestlerRepo))->check(1, 1, 2);
    }
}
