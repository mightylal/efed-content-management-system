<?php

namespace Efed\Title;

use Carbon\Carbon;
use Efed\Contracts\Repositories\TitleReignRepository;

class Title
{
    /**
     * @var TitleReignRepository
     */
    private $titleReignRepo;

    /**
     * Start new Title.
     *
     * @param TitleReignRepository $titleReignRepo
     */
    public function __construct(TitleReignRepository $titleReignRepo)
    {
        $this->titleReignRepo = $titleReignRepo;
    }

    /**
     * Assign wrestlers to the titles.
     *
     * @param integer $title_id
     * @param string $type
     * @param array $wrestlers
     */
    public function assign($title_id, $type, $wrestlers)
    {
        $this->endReign($title_id);
        $attributes = ['title_id' => $title_id, 'date_won' => Carbon::now()->toDateTimeString(), 'wrestler_id_one' => $wrestlers[0]];
        if ($type == 'Tag Team') {
            $attributes['wrestler_id_two'] = $wrestlers[1];
        }
        $this->titleReignRepo->create($attributes);
    }

    /**
     * End the title reign of the current holders.
     *
     * @param integer $title_id
     */
    private function endReign($title_id)
    {
        $reign = $this->titleReignRepo->getActive($title_id, ['id']);
        $this->titleReignRepo->update($reign['id'], ['date_lost' => Carbon::now()->toDateTimeString()]);
    }

}