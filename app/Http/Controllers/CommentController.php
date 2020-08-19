<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Comment;

class CommentController extends Controller
{
    public function create( $postId, Request $request){
        $this->validate($request,[
            "message" => 'required'
        ]);

        $newComment = new Comment();

        $newComment->post_id = $postId;
        $newComment->user_id = auth()->user()->id;
        $newComment->message = $request['message'];

        $newComment->save();

        return back();

    }

    public function update(  Request $request){
        
        $comment = Comment::findOrFail( $request['edit_comment_id'] );
        $comment->message = $request['message'];

        $comment->update();

        return back();
    }

    public function delete( $commentId ){

        $comment = Comment::findOrFail( $commentId );
  
        $comment->delete();
        return 200; 
    }
}
