@extends('layout',[ 'title' => "Posts" ])

@section('bodyDashboard')


<section id="main-content">
          <section class="wrapper"> 
              
              	<!-- INLINE FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12 ">
          			<div class="form-panel ">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> Create Post </h4>
                        <hr>
                        @if( $errors )
                            @foreach( $errors->all() as $error )
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                            @endforeach
                        @endif
                        
                        @if( Session::get('success') )
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
					    @endif
                      <form class="form-horizontal" role="form" method="post" action="/posts"  enctype="multipart/form-data" >
                          <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" >
                          
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Title</label>
                              <div class="col-sm-5">
                                  <input name="title" type="text" class="form-control round-form">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Descrition</label>
                              <div class="col-sm-5">
                                  <textarea name="description" class="form-control" cols="10" rows="4"></textarea>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Image </label>
                              <div class="col-sm-5">
                                  <input name="image" value="{{ old('image') }}" class="form-control" type="file">
                                  <p style="color:red">*jpeg,png,jpg,gif,svg</p>
                              </div>
                          </div>
                          
                          <button type="submit" class="btn btn-success">Save</button>
                      </form>
          			</div><!-- /form-panel -->
          		</div><!-- /col-lg-12 -->
              </div><!-- /row -->
              <hr>
           <h4 class="mb"><i class="fa fa-angle-right"></i> All my posts </h4>

<!--------------------------------------------------------------------->
<div class="row">
    @foreach( $posts ?? [] as $post )
    <div class="card border-secondary mb-3" style="max-width: 20rem; margin: 10px">
        <div class="card-header">{{ $post->title }}</div>
        <div class="card-body text-secondary">
            <img class="card-img-top" src="{{ asset('/uploads/post/'.$post->image ) }}" alt="Card image cap">
            
            <p class="card-text">{{ $post->description }}</p>
        <hr>
           <a  class="btn btn-info btn-xs"  href="/posts/edit/{{ $post->id }}"  > edit </a>
           <a onclick="delete_id = {{ $post->id }}" class="btn btn-danger btn-xs" data-toggle="modal"  href="#myModal"  > delete </a>
        </div>
        
             
    </div> 
    @endforeach

    @if( sizeof($posts ?? []) == 0 )
        <div class="m-auto"><h5 style="color: blue">Your posts current empty :(</h5></div>
    @endif
</div>
<!--------------------------------------------------------------------->

   <!-- Modal - DELETE -->
 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          
		                      </div>
		                      <div class="modal-body"> 

                                <h4><i>Are you sure to delete this post details ?</i></h4>
                                
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-danger" type="button" onclick="deletePost()">Delete</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
          <!-- modal -->

		</section> 
      </section> 
 <script>
     
    let delete_id;
    function deletePost(){

            let data = {};
                data._token = $("#csrf_token").val(),
            
            $.ajax({
                url: "/posts/"+delete_id,
                method: 'delete',
                data: data,
                success: function( data2 ){  

                    // console.log(data2)
                    location.reload()
                }
            })
    }
 </script>
 
@endsection('bodyDashboard')