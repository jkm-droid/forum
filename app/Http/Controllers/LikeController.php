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
        if ($request->ajax()) {
            $message_id = $request->message_id;
            $message = Message::where('id', $message_id)->first();

            $alreadyLiked = Auth::user()->likes()->where('message_id', $message_id)->first();

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

                $data = array(
                    'status'=>$status,
                    'message'=>$msg
                );

            }else {
                $data = array(
                    'status' => 204,
                    'message' => "success"
                );
            }

            return response()->json($data);
        }

        $data = array(
            'status'=>202,
            'message'=>"Unsupported method"
        );

        return response()->json($data);
    }
}
