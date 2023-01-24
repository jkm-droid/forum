<?php

namespace App\Services\Forum;

use App\Models\Like;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function likeMessage($request){
        $message_id = $request->message_id;
        $message = Message::where('id', $message_id)->first();

        $alreadyLiked = Auth::user()->likes()->where('message_id', $message_id)->first();
        $likeCount = $message->likes;

        $data = array();
        if (!$alreadyLiked) {
            $message->likes = $message->likes + 1;
            $message->update();

            $like = new Like();
            $like->user_id = Auth::user()->getAuthIdentifier();
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
