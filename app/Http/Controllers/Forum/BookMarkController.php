<?php

namespace App\Http\Controllers\Forum\Member\Forum;

use App\Helpers\HelperService;
use App\Http\Controllers\Forum\Member\Controller;
use App\Services\Forum\BookmarkService;
use Illuminate\Http\Request;

class BookMarkController extends Controller
{

    /**
     * @var BookmarkService
     */
    private $_bookmarkService;

    public function __construct(BookmarkService $bookmarkService)
    {
        $this->middleware('auth');
        $this->_bookmarkService = $bookmarkService;
    }

    /**
     * bookmark topic and messages
     */
    public function bookmark_topic_message(Request $request)
    {
        return $this->_bookmarkService->bookmarkTopicMessage($request);
    }

    /**
     * get bookmark status
     */
    public function get_bookmark_status(Request $request)
    {
        return $this->_bookmarkService->getBookmarkStatus($request);
    }

    /**
     * get user bookmarked messages and topics
     */
    public function get_user_bookmarks($user_id)
    {
       return $this->_bookmarkService->getUserBookmarks($user_id);
    }
}
