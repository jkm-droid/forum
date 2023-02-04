<?php

namespace App\Listeners;

use App\Constants\AppConstants;
use App\Helpers\AppHelperService;
use App\Mail\MemberSendEmail;
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
    public function __construct(AppHelperService $helperService, SystemLogsService $systemLogsService)
    {
        $this->_helperService = $helperService;
        $this->_systemLogsService = $systemLogsService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event_category = $event->eventDetails;
        switch ($event_category)
        {
            case AppConstants::$events['admin_email']:
                $this->_helperService->SendAdminEmail($event);
                break;
            case AppConstants::$events['member_email']:
                $this->_helperService->SendMemberEmail($event);
                break;
            case AppConstants::$events['system_logs']:
                $this->_helperService->sendNewMessageNotification($event);
                break;
            default:
                throw new BadRequestException("Event {$event_category} not supported");
        }
    }
}
