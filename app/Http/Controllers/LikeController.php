<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function like_message(Request $request){
        $message_id = $request->message_id;
        $message = Message::where('id', $message_id)->first();

        $alreadyLiked = Auth::user()->likes()->where('message_id', $message_id)->first();
        $likeCount = $message->likes;

        $data = array();
        if (!$alreadyLiked) {
            $message->likes = $message->likes + 1;
            $message->update();

            $like = new Like();
            $like->user_id = Auth::user()->id;
            $like->message_id = $message_id;

            //like saved
            if ($like->save()) {
                $status = 200;
                $msg = "success";
            } else {
                $status = 201;
                $msg = "error";
            }
            $likeCount = $message->likes;

            $data = array(
                'status'=>$status,
                'message'=>$msg,
                'likeCount'=>$likeCount
            );

        }else {
            $data = array(
                'status' => 204,
                'message' => "success",
                'likeCount'=>$likeCount
            );
        }

        return response()->json($data);
    }

}
