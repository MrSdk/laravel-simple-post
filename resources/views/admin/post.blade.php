@extends('layout',[ 'title' => "Post" ])

<link rel="stylesheet" href="{{ asset('/bootstrap/css/chat.css') }}">

@section('bodyDashboard')

<h1>  {{ $post->title }} </h1>
<hr>
<div class="container">
  <div class="card mb-3">
    <img class="card-img-top" src="{{ asset('/uploads/post/'.$post->image) }}" alt="Not found image">
    
    <div class="card-body"> 
    <p><i>Created by: </i> <span style="font-weight: bold">{{ $post->user_name }} </span></p>
      <p class="card-text">{{ $post->description }}</p>
      <p class="card-text"><small class="text-muted">Posted at {{ $post->created_at }}</small></p>
   
    <div class="nav justify-content-end">
      <div class="row" >
      <button onclick="onLiked(1)" style="margin: 5px" type="button" class="btn btn-primary " {{ ($my_like == 1 ) ? 'disabled' : ''}}>
        Like <span class="badge badge-light">{{ $likes }}</span>
        <span class="sr-only">unread messages</span>
      </button>
      <button onclick="onLiked(0)" style="margin: 5px" type="button" class="btn btn-primary " {{ ($my_like == 2 ) ? 'disabled' : ''}}>
        DisLike <span class="badge badge-light">{{ $dislikes }}</span>
        <span class="sr-only">unread messages</span>
      </button> 
      </div>
    </div>
    </div>
    <hr>
    <div class="card-body">
<!-------------------------------------------------------------------->
      <!-- Komments here ! -->
      <div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex">
            <div class="col-md-4">
                <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Chat Messages</h3> 
                    </div>
                    <div class="box-body">
                        <div class="direct-chat-messages">
                          @foreach( $comments as $comment )

                            @if( $comment->user_id != auth()->user()->id )
                            <div class="direct-chat-msg left">
                                <span class="direct-chat-name pull-left-name">{{ $comment->user_name }}</span>
                                <div class="direct-chat-text"> {{ $comment->message }} <br>
                                <span class="direct-chat-timestamp pull-right">{{ $comment->created_at }}</span> 
                                </div>
                            </div>
                            @else
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-info clearfix"> <span class="direct-chat-name pull-right-name " style="font-size: 15px">{{ $comment->user_name }}</span>  </div> <img class="direct-chat-img" src="{{ asset('/uploads/User2.jpg') }}" alt="message user image">
                                <div class="direct-chat-text"> {{ $comment->message }} <br>
                                <span class="direct-chat-timestamp pull-left">{{ $comment->created_at }}</span>
                                <hr>
                                <div>
                                <button  onclick="getComment( {{ $comment }} )" class="btn btn-link" data-toggle="modal"  href="#myModal2" >Edit</button>
                                <button  onclick="delete_id = {{ $comment->id }}" class="btn btn-link" data-toggle="modal"  href="#myModal" >Delete</button>
                                </div>
                                </div>
                            </div>
                            @endif   
                          @endforeach
                        </div>
                    </div>
                    <div class="box-footer">
                        <form action="/comment/{{ $post->id }}" method="post">
                            <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" >
                       
                            <div class="input-group"> <input type="text" name="message" placeholder="Type Message ..." class="form-control"> <span class="input-group-btn"> <button type="submit" class="btn btn-warning btn-flat">Send</button> </span> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-------------------------------------------------------------------->

   <!-- Modal - DELETE -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          
		                      </div>
		                      <div class="modal-body"> 

                                <h4><i>Are you sure to delete this komment ?</i></h4>
                                
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-danger" type="button" onclick="deleteComment()">Delete</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
          <!-- modal -->

   <!-- Modal - UPDATE -->
   <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
                        <form action="/comment/update" method="post">
                          @csrf
                          {{ method_field('PUT') }}
                          
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          
		                      </div>
		                      <div class="modal-body"> 

                                
                                <div class="input-group"> <input id="edit_message" type="text" name="message" placeholder="Type Message ..." class="form-control">  </div>
                                <input type="hidden" id="edit_comment_id" name="edit_comment_id">
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-info" type="submit" >Update</button>
                          </div>
                          </form>
		                  </div>
		              </div>
		          </div>
          <!-- modal -->
    </div>
  </div>
</div>



  
<script>
  
  let delete_id;
 
    function deleteComment(){

            let data = {};
                data._token = $("#csrf_token").val(),
            
            $.ajax({
                url: "/comment/"+delete_id,
                method: 'delete',
                data: data,
                success: function( data2 ){  

                    // console.log(data2)
                    location.reload()
                }
            })
    }

    function getComment( comment ){
                
      $("#edit_message").val( comment.message ) 
      $("#edit_comment_id").val( comment.id )
      
    }

  function onLiked( status ){
    $.ajax({
     url: "/post/onlike/{{ $post->id }}/"+status,
     method: 'get',
     success: function( resu ){
        location.reload()
     } 
    })
  }
</script>
@endsection('bodyDashboard')