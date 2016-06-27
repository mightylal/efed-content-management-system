<?php

namespace Efed\Http\Controllers;

use Illuminate\Http\Request;

use Efed\Http\Requests;
use Efed\Http\Controllers\Controller;
use Efed\Services\ForumService;
use Efed\Contracts\Repositories\ForumRepository;
use Efed\Contracts\Repositories\ForumPostRepository;
use Efed\Forum\Topics;
use Efed\Exceptions\ValidationException;

class ForumController extends Controller
{
    /**
     * @var ForumService
     */
    private $forumService;
    
    /**
     * @var ForumRepository
     */
    private $forumRepo;

    /**
     * @var ForumPostRepository
     */
    private $forumPostRepo;

    /**
     * @var Topics
     */
    private $topics;

    /**
     * Start new ForumController.
     *
     * @param ForumService $forumService
     * @param ForumRepository $forumRepo
     * @param ForumPostRepository $forumPostRepo
     * @param Topics $topics
     */
    public function __construct(ForumService $forumService, ForumRepository $forumRepo, ForumPostRepository $forumPostRepo, Topics $topics)
    {
        $this->forumService = $forumService;
        $this->forumRepo = $forumRepo;
        $this->forumPostRepo = $forumPostRepo;
        $this->topics = $topics;
    }

    /**
     * Display the forum categories.
     *
     * @return view
     */
    public function index()
    {
        $forums = $this->forumRepo->all();
        return view('forum', compact('forums'));
    }
    
    /**
     * Display the forum topics.
     * 
     * @param string $id
     * @return view
     */
    public function category($id)
    {
        $forum = $this->forumRepo->topics($id);
        $topics = $this->topics->get($id);
        return view('forum_category', compact('forum', 'topics'));
    }

    /**
     * Display the forum posts for topic.
     * 
     * @param string $category_id
     * @param string $topic_id
     * @return view
     */
    public function topic($category_id, $topic_id)
    {
        if ($this->wrestlerId()) {
            $this->forumService->viewTopic($category_id, $topic_id, $this->wrestlerId());
        }
        $forum = $this->forumRepo->posts($category_id, $topic_id);
        $posts = $this->forumPostRepo->getByTopic($topic_id);
        return view('forum_topic', compact('forum', 'posts'));
    }

    /**
     * Display the edit post form.
     *
     * @param string $category_id
     * @param string $topic_id
     * @param string $post_id
     * @return view
     */
    public function edit($category_id, $topic_id, $post_id)
    {
        $post = $this->forumPostRepo->get($post_id, ['id', 'topic_id', 'post']);
        return view('edit_forum_post', compact('category_id', 'post'));
    }

    /**
     * Create a topic.
     *
     * @param string $id
     * @param Request $request
     * @return response
     */
    public function storeTopic($id, Request $request)
    {
        try {
            $topic_id = $this->forumService->createTopic($this->wrestlerId(), trim($id), array_map('trim', $request->only('name', 'post')));
            return redirect()->route('forum.topic', ['category' => $id, 'topic' => $topic_id])->with('message', 'Topic created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('forum.category', ['category' => $id])->withErrors($error->getErrors());
        }
    }

    /**
     * Create a post.
     *
     * @param string $category_id
     * @param string $topic_id
     * @param Request $request
     * @return response
     */
    public function storePost($category_id, $topic_id, Request $request)
    {
        try {
            $this->forumService->createPost($this->wrestlerId(), trim($topic_id), array_map('trim', $request->only('post')));
            return redirect()->route('forum.topic', ['category' => $category_id, 'topic' => $topic_id])->with('message', 'Post created successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('forum.topic', ['category' => $category_id, 'topic' => $topic_id])->withErrors($error->getErrors());
        }
    }
    
    /**
     * Lock the topic.
     * 
     * @param string $category_id
     * @param string $topic_id
     * @return response
     */
    public function lock($category_id, $topic_id)
    {
        $message = $this->forumService->lockToggle($topic_id);
        return redirect()->route('forum.topic', ['category' => $category_id, 'topic' => $topic_id])->with('message', 'Topic ' . $message . ' successfully.');
    }
    
    /**
     * Pin the topic.
     * 
     * @param string $category_id
     * @param string $topic_id
     * @return response
     */
    public function pin($category_id, $topic_id)
    {
        $message = $this->forumService->pinToggle($topic_id);
        return redirect()->route('forum.topic', ['category' => $category_id, 'topic' => $topic_id])->with('message', 'Topic ' . $message . ' successfully.');
    }

    /**
     * Update the post.
     *
     * @param string $category_id
     * @param string $topic_id
     * @param string $post_id
     * @param Request $request
     * @return response
     */
    public function update($category_id, $topic_id, $post_id, Request $request)
    {
        try {
            $this->forumService->updatePost(trim($post_id), array_map('trim', $request->only('post')));
            return redirect()->route('forum.topic', ['category' => $category_id, 'topic' => $topic_id])->with('message', 'Post updated successfully.');
        } catch (ValidationException $error) {
            return redirect()->route('forum.edit', ['category' => $category_id, 'topic' => $topic_id, 'post' => $post_id])->withErrors($error->getErrors());
        }
    }
}
