@extends('layout',[ 'title' => "Update Post" ])

@section('bodyDashboard')
 
              	<!-- INLINE FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12 ">
          			<div class="form-panel ">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> Update Post </h4>
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
                      <form class="form-horizontal" role="form" method="post" action="/posts/{{ $post->id }}"  enctype="multipart/form-data" >
                          <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" >
                          {{ method_field('PUT') }}

                          <div class="form-group">
                              <label class="col-sm-1 control-label">Title</label>
                              <div class="col-sm-5">
                                  <input name="title" value="{{ $post->title }}" type="text" class="form-control round-form">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Descrition</label>
                              <div class="col-sm-5">
                                  <textarea name="description" class="form-control" cols="10" rows="4">{{ $post->description }}</textarea>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Image </label>
                              <div class="col-sm-5">
                                  <input name="image" value="{{ old('image') }}" class="form-control" type="file">
                                  <p style="color:red">*jpeg,png,jpg,gif,svg</p>
                              </div>
                          </div>
                          
                          <button type="submit" class="btn btn-info">Update</button>
                      </form>
          			</div><!-- /form-panel -->
          		</div><!-- /col-lg-12 -->
              </div><!-- /row -->

@endsection('bodyDashboard')