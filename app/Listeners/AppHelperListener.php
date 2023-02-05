<?php

namespace App\Listeners;

use App\Constants\AppConstants;
use App\Events\AppHelperEvent;
use App\Helpers\AppHelperEventsService;
use App\Helpers\AppHelperService;
use App\Mail\MemberSendMail;
use App\Services\Member\SystemLogsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AppHelperListener
{
    /**
     * @var AppHelperService
     * @var SystemLogsService
     */
    private $_helperService;
    private $_systemLogsService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AppHelperEventsService $helperService, SystemLogsService $systemLogsService)
    {
        $this->_helperService = $helperService;
        $this->_systemLogsService = $systemLogsService;
    }

    /**
     * Handle the event.
     *
     * @param AppHelperEvent $event
     * @return void
     */
    public function handle(AppHelperEvent $event)
    {
        $event_category = $event->eventDetails;
        switch ($event_category['event'])
        {
            case AppConstants::$events['admin_email']:
                $this->_helperService->SendAdminEmail($event);
                break;
            case AppConstants::$events['member_email']:
                $this->_helperService->SendMemberEmail($event);
                break;
            case AppConstants::$events['new_message']:
                $this->_helperService->sendNewMessageNotification($event);
                break;
            case AppConstants::$events['system_logs']:
                $this->_systemLogsService->saveSystemActivities($event);
                break;
            default:
                throw new BadRequestException("Event {$event_category['event']} not supported");
        }
    }
}
