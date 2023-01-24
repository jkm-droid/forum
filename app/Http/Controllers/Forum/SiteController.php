<?php

namespace App\Http\Controllers\Forum;

use App\Helpers\GetRepetitiveItems;
use App\Http\Controllers\Controller;
use App\Services\Forum\ForumService;

class SiteController extends Controller
{
    use GetRepetitiveItems;

    /**
     * @var ForumService
     */
    private $_forumService;

    public function __construct(ForumService $forumService){
        $this->_forumService = $forumService;
    }

    /**
     *show home page alongside all categories
     * and latest topics
     */
    public function showWelcomePage()
    {
        return $this->_forumService->welcomePage();
    }

    /**
     * show a single category based on its slug alongside
     * all its topics
     */
    public function showSingleCategory($slug)
    {
        return $this->_forumService->singleCategory($slug);
    }

    /**
     * show a single topic alongside the body, messages and comments
     */
    public function showTopic($slug)
    {
        return $this->_forumService->showTopic($slug);
    }

    /**
     * show all the top topics, rank them based on their messages
     */
    public function showTopTopics()
    {
        return $this->_forumService->topTopics();
    }

    /**
     * get a single message alongside its comments
     */
    public function getSingleMessage($message_id)
    {
        return $this->_forumService->getSingleMessage($message_id);
    }

    /**
     * show all the categories
     */
    public function showForumList()
    {
        return $this->_forumService->forumList();
    }

}
