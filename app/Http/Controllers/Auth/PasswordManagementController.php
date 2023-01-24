<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Member\PasswordManagementService;
use Illuminate\Http\Request;

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
