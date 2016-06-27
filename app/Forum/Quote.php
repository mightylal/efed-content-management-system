<?php

namespace Efed\Forum;

use Efed\Contracts\Repositories\ForumPostRepository;

class Quote
{

    /**
     * @var ForumPostRepository
     */
    private $forumPostRepo;

    /**
     * Start new Quote.
     *
     * @param ForumPostRepository $forumPostRepo
     */
    public function __construct(ForumPostRepository $forumPostRepo)
    {
        $this->forumPostRepo = $forumPostRepo;
    }
    
    /**
     * Put the quote together.
     * 
     * @param string $post
     * @return mixed
     */
    public function handle($post)
    {
        $pattern = "~\[quote=(.*)\](.*)\[\/quote\]~iUs";
        preg_match_all($pattern, $post, $matches);
        if (is_array($matches)) {
            foreach ($matches[0] as $key => $match) {
                $forumPost = $this->forumPostRepo->get($matches[1][$key], ['id', 'wrestler_id']);
                $quote = '';
                if ($forumPost) {
                    $quote = "<p><em>Posted by " . e($forumPost['wrestler']['name']) . "</em></p><div class='well well-sm quote-container'>" . $matches[2][$key] . "</div>";
                }
                $post = str_ireplace($match, $quote, $post);
            }
        }
        return $post;
    }

}