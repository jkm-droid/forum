<?php

namespace App\Http\Controllers\Forum;

use App\Events\ContentCreationEvent;
use App\Events\HelperEvent;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Message;
use App\Notifications\CommentNotification;
use App\Services\Forum\MessageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MessageController extends Controller
{

    /**
     * @var MessageService
     */
    private $_messageService;

    public function __construct(MessageService $messageService)
    {
        $this->middleware('auth');
        $this->_messageService = $messageService;
    }

    /**
     * save a message belonging to a certain topic
     */

    public function save_message(Request $request)
    {
        return $this->_messageService->saveMessage($request);
    }

    /**
     * show form to edit message
     */
    public function show_message_edit_form($message_id)
    {
        return $this->_messageService->messageEditForm($message_id);
    }

    /**
     * update message
     */
    public function update_message(Request $request, $message_id)
    {
        return $this->_messageService->updateMessage($request, $message_id);
    }

    /**
     * delete a message belonging to a certain topic - async
     */
    public function ajax_delete_message(Request $request)
    {
        return $this->_messageService->ajaxDeleteMessage($request);
    }

    /**
     * delete a message belonging to a certain topic - post method
     */
    public function post_delete_message($message_id)
    {
       return $this->_messageService->postDeleteMessage($message_id);
    }
}
