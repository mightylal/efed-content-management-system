<?php

namespace Efed\Forum;

use Illuminate\Database\DatabaseManager;

class Topics
{

    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * Start new Topics.
     *
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve the topics.
     *
     * @param integer $category_id
     * @return collection
     */
    public function get($category_id)
    {
        return $this->db->connection('mysql')->table('forumTopic')
            ->selectRaw("COUNT(forumPost.topic_id) AS posts, forumTopic.name, wrestler.name AS wrestlerName, forumTopic.created_at, forumTopic.id, forumTopic.locked, forumTopic.pinned, forumTopic.updated_at")
            ->join('forumPost', 'forumTopic.id', '=', 'forumPost.topic_id')
            ->join('wrestler', 'forumTopic.wrestler_id', '=', 'wrestler.id')
            ->where('forumTopic.category_id', $category_id)
            ->groupBy('forumTopic.id')
            ->orderBy('forumTopic.pinned', 'desc')
            ->orderBy('forumTopic.updated_at', 'desc')
            ->simplePaginate(15);
    }

}