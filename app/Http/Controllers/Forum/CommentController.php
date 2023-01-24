<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Forum\CommentService;
use App\Services\Forum\MessageService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * @var MessageService
     */
    private $_commentService;

    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth');
        $this->_commentService = $commentService;
    }

    /**
     * create a new reply/comment
     */
    public function save_message_reply(Request $request)
    {
        return $this->_commentService->saveMessageReply($request);
    }

    /**
     * show form to edit a comment on a certain message
     */
    public function show_message_reply_form($message_reply_id)
    {
        return $this->_commentService->messageReplyForm($message_reply_id);
    }

    /**
     * update a comment belonging to a certain message
     */
    public function update_message_reply(Request $request,$reply_id)
    {
        return $this->_commentService->updateMessageReply($request, $reply_id);
    }

    /**
     * delete a comment
     */
    public function delete_message_reply(Request $request)
    {
        return $this->_commentService->deleteMessageReply($request);
    }
}
