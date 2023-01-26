<?php

namespace App\Http\Controllers\Forum;

use App\Events\AdminEvent;
use App\Events\HelperEvent;
use App\Helpers\GetRepetitiveItems;
use App\Helpers\HelperService;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Tag;
use App\Models\Topic;
use App\Models\View;
use App\Notifications\AdminNotification;
use App\Services\Forum\TopicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TopicController extends Controller
{
    /**
     * @var TopicService
     */
    private $_topicService;

    public function __construct(TopicService $topicService)
    {
        $this->middleware('auth')->except('showTopic','showTopTopics');
        $this->_topicService = $topicService;
    }

    /**
     * show the form to create a new topic/thread
     */

    public function show_create_new_topic_form()
    {
        return $this->_topicService->createNewTopicForm();
    }

    /**
     * save a new topic
     */
    public function save_new_topic(Request $request)
    {
        return $this->_topicService->saveNewTopic($request);
    }

    /**
     * show form to edit a topic
     */
    public function show_edit_topic_form($topic_id)
    {
        return $this->_topicService->editTopicForm($topic_id);
    }

    /**
     * edit a topic
     */
    public function update_topic(Request $request, $topic_id)
    {
       return $this->_topicService->updateTopic($request, $topic_id);
    }

    /**
     * delete a particular topic
     */
    public function delete_topic(Request $request)
    {
        return $this->_topicService->deleteTopic($request);
    }

    /**
     * show a single topic alongside the body, messages and comments
     */
    public function showTopic($slug)
    {
        return $this->_topicService->showTopic($slug);
    }

    /**
     * show all the top topics, rank them based on their messages
     */
    public function showTopTopics()
    {
        return $this->_topicService->topTopics();
    }

    /**
     * get topic view status based on user_id and topic_id
     */
    public function get_topic_view_status(Request $request)
    {
        return $this->_topicService->topicViewStatus($request);
    }
}
