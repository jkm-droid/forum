<?php

namespace App\Http\Controllers\Forum;

use App\Helpers\GetRepetitiveItems;
use App\Http\Controllers\Controller;
use App\Services\Forum\ForumService;

class ForumController extends Controller
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
     * show all the categories
     */
    public function showForumList()
    {
        return $this->_forumService->forumList();
    }

}
