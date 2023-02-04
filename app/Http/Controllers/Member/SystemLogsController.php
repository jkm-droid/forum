<?php

namespace App\Http\Controllers\Member;

use App\Helpers\GetRepetitiveItems;
use App\Helpers\AppHelperService;
use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Services\Member\SystemLogsService;
use Illuminate\Http\Request;

class SystemLogsController extends Controller
{
    /**
     * @var SystemLogsService
     */
    private $_systemLogsService;

    public function __construct(SystemLogsService $systemLogsService)
    {
        $this->middleware('auth');
        $this->_systemLogsService = $systemLogsService;
    }
    /**
     * view the various activities within the system
     */
    public function view_system_activities()
    {
       return $this->_systemLogsService->systemActivities();
    }
}
