<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Efed\Segment\SegmentWrestlerInsert;

class SegmentWrestlerInsertTest extends TestCase
{
    /**
     * @test
     */
    public function it_formats_a_1v1()
    {
        $wrestlers = [1,2];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '1v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_1v1v1()
    {
        $wrestlers = [1,2,3];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '1v1v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_1v1v1v1()
    {
        $wrestlers = [1,2,3,4];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '1v1v1v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_1v1v1v1v1()
    {
        $wrestlers = [1,2,3,4,5];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 5],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '1v1v1v1v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_1v1v1v1v1v1()
    {
        $wrestlers = [1,2,3,4,5,6];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 5],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 6],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '1v1v1v1v1v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_2v2()
    {
        $wrestlers = [1,2,3,4];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '2v2', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_2v2v2()
    {
        $wrestlers = [1,2,3,4,5,6];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 3],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '2v2v2', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_2v2v2v2()
    {
        $wrestlers = [1,2,3,4,5,6,7,8];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 4],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '2v2v2v2', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_3v3()
    {
        $wrestlers = [1,2,3,4,5,6];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '3v3', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_4v4()
    {
        $wrestlers = [1,2,3,4,5,6,7,8];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '4v4', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_5v5()
    {
        $wrestlers = [1,2,3,4,5,6,7,8,9,10];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 9, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 10, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '5v5', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_2v1()
    {
        $wrestlers = [1,2,3];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '2v1', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_3v2()
    {
        $wrestlers = [1,2,3,4,5];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 2],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '3v2', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_10_man_battle_royal()
    {
        $wrestlers = [1,2,3,4,5,6,7,8,9,10];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 5],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 6],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 7],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 8],
            ['segment_id' => 1, 'wrestler_id' => 9, 'team_id' => 9],
            ['segment_id' => 1, 'wrestler_id' => 10, 'team_id' => 10],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '10', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_20_man_battle_royal()
    {
        $wrestlers = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 5],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 6],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 7],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 8],
            ['segment_id' => 1, 'wrestler_id' => 9, 'team_id' => 9],
            ['segment_id' => 1, 'wrestler_id' => 10, 'team_id' => 10],
            ['segment_id' => 1, 'wrestler_id' => 11, 'team_id' => 11],
            ['segment_id' => 1, 'wrestler_id' => 12, 'team_id' => 12],
            ['segment_id' => 1, 'wrestler_id' => 13, 'team_id' => 13],
            ['segment_id' => 1, 'wrestler_id' => 14, 'team_id' => 14],
            ['segment_id' => 1, 'wrestler_id' => 15, 'team_id' => 15],
            ['segment_id' => 1, 'wrestler_id' => 16, 'team_id' => 16],
            ['segment_id' => 1, 'wrestler_id' => 17, 'team_id' => 17],
            ['segment_id' => 1, 'wrestler_id' => 18, 'team_id' => 18],
            ['segment_id' => 1, 'wrestler_id' => 19, 'team_id' => 19],
            ['segment_id' => 1, 'wrestler_id' => 20, 'team_id' => 20],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '20', $wrestlers));
    }

    /**
     * @test
     */
    public function it_formats_a_30_man_battle_royal()
    {
        $wrestlers = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
        $segmentWrestlerInsert = new SegmentWrestlerInsert;
        $result = [
            ['segment_id' => 1, 'wrestler_id' => 1, 'team_id' => 1],
            ['segment_id' => 1, 'wrestler_id' => 2, 'team_id' => 2],
            ['segment_id' => 1, 'wrestler_id' => 3, 'team_id' => 3],
            ['segment_id' => 1, 'wrestler_id' => 4, 'team_id' => 4],
            ['segment_id' => 1, 'wrestler_id' => 5, 'team_id' => 5],
            ['segment_id' => 1, 'wrestler_id' => 6, 'team_id' => 6],
            ['segment_id' => 1, 'wrestler_id' => 7, 'team_id' => 7],
            ['segment_id' => 1, 'wrestler_id' => 8, 'team_id' => 8],
            ['segment_id' => 1, 'wrestler_id' => 9, 'team_id' => 9],
            ['segment_id' => 1, 'wrestler_id' => 10, 'team_id' => 10],
            ['segment_id' => 1, 'wrestler_id' => 11, 'team_id' => 11],
            ['segment_id' => 1, 'wrestler_id' => 12, 'team_id' => 12],
            ['segment_id' => 1, 'wrestler_id' => 13, 'team_id' => 13],
            ['segment_id' => 1, 'wrestler_id' => 14, 'team_id' => 14],
            ['segment_id' => 1, 'wrestler_id' => 15, 'team_id' => 15],
            ['segment_id' => 1, 'wrestler_id' => 16, 'team_id' => 16],
            ['segment_id' => 1, 'wrestler_id' => 17, 'team_id' => 17],
            ['segment_id' => 1, 'wrestler_id' => 18, 'team_id' => 18],
            ['segment_id' => 1, 'wrestler_id' => 19, 'team_id' => 19],
            ['segment_id' => 1, 'wrestler_id' => 20, 'team_id' => 20],
            ['segment_id' => 1, 'wrestler_id' => 21, 'team_id' => 21],
            ['segment_id' => 1, 'wrestler_id' => 22, 'team_id' => 22],
            ['segment_id' => 1, 'wrestler_id' => 23, 'team_id' => 23],
            ['segment_id' => 1, 'wrestler_id' => 24, 'team_id' => 24],
            ['segment_id' => 1, 'wrestler_id' => 25, 'team_id' => 25],
            ['segment_id' => 1, 'wrestler_id' => 26, 'team_id' => 26],
            ['segment_id' => 1, 'wrestler_id' => 27, 'team_id' => 27],
            ['segment_id' => 1, 'wrestler_id' => 28, 'team_id' => 28],
            ['segment_id' => 1, 'wrestler_id' => 29, 'team_id' => 29],
            ['segment_id' => 1, 'wrestler_id' => 30, 'team_id' => 30],
        ];
        $this->assertEquals($result, $segmentWrestlerInsert->format(1, '30', $wrestlers));
    }
}
