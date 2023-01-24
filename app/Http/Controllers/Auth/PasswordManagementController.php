<?php

namespace App\Http\Controllers\Forum\Member\Forum\Auth;

use App\Http\Controllers\Forum\Member\Forum\Controller;
use App\Models\User;
use App\Services\Member\PasswordManagementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordManagementController extends Controller
{
    /**
     * @var PasswordManagementService
     */
    private $_passwordService;

    public function __construct(PasswordManagementService $passwordService)
    {
        $this->middleware('guest');
        $this->_passwordService = $passwordService;
    }

    public function forgotPassForm()
    {
        return $this->_passwordService->showForgotPassForm();
    }

    public function submitForgotPassForm(Request $request)
    {
        return $this->_passwordService->processForgotPassForm($request);
    }

    public function resetPassForm($token)
    {
        return $this->_passwordService->processResetPassForm($token);
    }

    public function resetPass(Request $request)
    {
        return $this->_passwordService->processResetPassForm($request);
    }
}
