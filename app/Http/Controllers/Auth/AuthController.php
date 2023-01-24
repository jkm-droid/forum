<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Member\MemberAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @var MemberAuthService
     */
    private $_authService;

    public function __construct(MemberAuthService $authService){
        $this->middleware('guest')->except( 'logout');
        $this->_authService = $authService;
    }

    /**
     * show the login page
     * */
    public function loginPage()
    {
        return $this->_authService->showLoginPage();
    }

    /**
     * attempt to login user to the system
     * */
    public function login(Request $request)
    {
        return $this->_authService->loginUser($request);
    }

    /**
     * show the register page
     * */
    public function registerPage()
    {
        return $this->_authService->showRegisterPage();
    }

    /**
     * create a new user
     * */
    public function register(Request $request)
    {
        return $this->_authService->registerUser($request);
    }

    /**
     * verify user email
     */
    public function verifyEmail($token)
    {
        return $this->_authService->verifyUserEmail($token);
    }

    /**
     * logout user from the system
     * */
    public function logout(Request $request)
    {
        return $this->_authService->logoutUser($request);
    }
}
