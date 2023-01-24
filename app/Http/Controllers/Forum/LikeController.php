<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Services\Forum\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * @var LikeService
     */
    private $_likeService;

    public function __construct(LikeService $likeService){
        $this->middleware('auth');
        $this->_likeService = $likeService;
    }

    public function like_message(Request $request)
    {
        return $this->_likeService->likeMessage($request);
    }
}
