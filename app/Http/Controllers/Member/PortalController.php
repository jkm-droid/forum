<?php

namespace App\Http\Controllers\Member;

use App\Helpers\GetRepetitiveItems;
use App\Helpers\AppHelperService;
use App\Http\Controllers\Controller;

class PortalController extends Controller
{
    use GetRepetitiveItems;
    private $userDetails, $activity, $idGenerator;

    public function __construct(AppHelperService $myHelperClass){
        $this->middleware('auth');
        $this->special_character = array("!", "@", "#", "$", "%", "^", "&", "*", "(", ")", ",", "/", "{", "}", "[", "]", "?");
        $this->userDetails = $myHelperClass;
        $this->activity = $myHelperClass;
        $this->idGenerator = $myHelperClass;
    }

}
