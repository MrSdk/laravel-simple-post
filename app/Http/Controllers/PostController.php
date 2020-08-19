<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Models\Post;
use App\Http\Models\Like;
use App\Http\Models\Comment;
use App\User;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\MessageBag;

class PostController extends Controller
{
    public function show(){
        $posts = Post::all();
 
        return view('admin.posts',[ 'route'=>'posts','posts' => $posts ]);
    }

    public function showMyBlogs(){
        $posts = Post::all()->where('user_id',auth()->user()->id);
 
        return view('admin.myblog',[ 'posts' => $posts ]);
    }

    public function showUpdate( $id ){
        $post = Post::find( $id );
        $errors = new MessageBag();

        if( $post ){
            if( $post->user_id == auth()->user()->id ){
                
                return view('admin.edit',[ 'post' => $post ]);

            }else{
                $errors->add('error','You cannot edit this post :(');
        
                return back()->withErrors($errors);
            }

        }else{
            $errors->add('error','Not found this post :(');
    
            return redirect('/accaunt/blogs')->withErrors($errors);

        }

    }

    public function showPost( $id ){
        // 1 => like | 2 => dislike
        $my_like = 0;
        $cur_user_id = auth()->user()->id;

        $post = Post::findorFail( $id );
        $post->user_name = User::findOrFail( $post->user_id )['fullname'];

        $comments = Comment::all()->where('post_id',$id);
        $users = User::all();

        $likes = Like::all()->where('post_id',$id)->where('like',1);
        $dislikes = Like::all()->where('post_id',$id)->where('dislike',1);
         
        foreach( $comments as $comment ){
         
            foreach( $users as $user ){
                if( $user->id == $comment->user_id ) {
                    $comment->user_name = $user->fullname; 
                
                    break; 
                };
            }

        }

        foreach( $likes as $like ){
            if( $like->user_id == $cur_user_id ) { $my_like = 1; break; }
        }
        foreach( $dislikes as $dislike ){
            if( $dislike->user_id == $cur_user_id ) { $my_like = 2; break; }
        }

        return view('admin.post',[ 'comments'=>$comments,'users'=>$users,'post' => $post, 'my_like' => $my_like, 'likes'=>count($likes),'dislikes'=>count($dislikes) ]);
    }
////////////////////////////////////////////////////////////////////////////////////////////////////

    public function create(Request $request)
    {
        $this->validate($request, [
          'title' => 'required',
          'description' => 'required',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $request['title'].'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/post');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $post->image = $name;
        }
 
        $post->user_id = auth()->user()->id;
        $post->title = $request['title'];
        $post->description = $request['description'];
        
        $post->save();

        return back()->with('success', 'Your post has been added successfully. Please wait for the admin to approve.');
   }

   public function update( $id, Request $request ){
    
    $post = Post::findOrFail( $id );
    
        if( $post ){
                
            $post->user_id = auth()->user()->id;
            $post->title = $request['title'];
            $post->description = $request['description'];

            if ($request->hasFile('image')) {
            // remove current file
            $image_path_which_remove = public_path().'/uploads/post/'.$post->image ; 

            if (File::exists($image_path_which_remove)) {
                //File::delete($image_path); 
                unlink($image_path_which_remove);
            }

                $image = $request->file('image');
                $name = $request['title'].'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/post');
                $imagePath = $destinationPath. "/".  $name;
                $image->move($destinationPath, $name);
 
                $post->image = $name;
            }

            $post->save();

            return redirect('/accaunt/blogs')->with('success', 'Your post has been updated successfully.');

        }else {
            return back();
        }

   }

   public function delete( $id ){
 
    // try {
        
        $post = Post::findOrFail( $id );

        $image_path = public_path().'/uploads/post/'.$post['image'] ; 

        if (File::exists($image_path)) {
            //File::delete($image_path); 
            unlink($image_path);
        } 

    // } catch (\Throwable $th) {
    //     return $th; 
    // }
    
    $post->delete();
    return 200; 
    }

    public function onliked( $postId, $status ){
        $userId = auth()->user()->id;

        $hasUser = Like::all()->where('post_id',$postId)->where('user_id',$userId)->first();
        
        if( !$hasUser ){

            $newLike = new Like();

            $newLike->user_id = $userId;
            $newLike->post_id = $postId;
            $newLike->like = $status == 1 ? 1 : 0;
            $newLike->dislike = $status == 0 ? 1 : 0;

            $newLike->save();
        }else{
            $hasUser->like = $status == 1 ? 1 : 0;
            $hasUser->dislike = $status == 0 ? 1 : 0;

            $hasUser->update();
        }
        
        return 200;
    }
}
