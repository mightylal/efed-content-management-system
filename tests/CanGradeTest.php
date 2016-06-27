<?php

use Efed\Models\Settings;
use Efed\Grading\CanGrade;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CanGradeTest extends TestCase
{
    use DatabaseTransactions;
    
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
    public function wrestler_can_grade_roleplay()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->never();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(false)->once();
        $this->settings();
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertTrue($grade->check(1, 1));
    }

    /**
     * @test
     */
    public function wrestler_cannot_grade_roleplay_because_wrestler_has_already_has_graded()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->never();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(true)->once();
        $this->settings();
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertFalse($grade->check(1, 1));
    }

    /**
     * @test
     */
    public function wrestler_cannot_grade_roleplay_because_wrestler_is_not_activated()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->never();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(false)->once();
        $this->settings();
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertFalse($grade->check(1, 1));
    }

    /**
     * @test
     */
    public function wrestler_cannot_grade_roleplay_because_wrestler_is_roleplay_owner()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->never();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(false)->once();
        $this->settings();
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertFalse($grade->check(1, 1));
    }

    /**
     * @test
     */
    public function wrestler_can_grade_roleplay_because_wrestler_is_admin()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->andReturn(true)->once();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(false)->once();
        $this->settings('Staff');
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertTrue($grade->check(1, 1));
    }

    /**
     * @test
     */
    public function wrestler_cannot_grade_roleplay_because_wrestler_is_not_admin()
    {
        $roleplayRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayRepository');
        $roleplayGradeRepo = Mockery::mock('Efed\Contracts\Repositories\RoleplayGradeRepository');
        $wrestlerRepo = Mockery::mock('Efed\Contracts\Repositories\WrestlerRepository');
        $roleplayRepo->shouldReceive('isOwner')->andReturn(false)->once();
        $wrestlerRepo->shouldReceive('isActivated')->andReturn(true)->once();
        $wrestlerRepo->shouldReceive('isAdmin')->andReturn(false)->once();
        $roleplayGradeRepo->shouldReceive('hasGraded')->andReturn(false)->once();
        $this->settings('Staff');
        $grade = new CanGrade($wrestlerRepo, $roleplayRepo, $roleplayGradeRepo);
        $this->assertFalse($grade->check(1, 1));
    }

    /**
     * Check to see if settings have been set.
     *
     * @param string $gradeRights
     * @return object
     */
    private function settings($gradeRights = 'Everyone')
    {
        return (new Settings)->create(['roleplayLimit' => 3, 'gradeRights' => $gradeRights]);
    }
}
