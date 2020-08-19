@extends('layout',[ 'title' => "Update Post" ])

@section('bodyDashboard')
 
   	<!-- INLINE FORM ELELEMNTS -->
       <div class="row mt">
          		<div class="col-lg-12 ">
          			<div class="form-panel ">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> Accaunt Settings </h4>
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
                      <form class="form-horizontal" role="form" method="post" action="/accaunt/settings" >
                          <input type="hidden" name="_token" id="csrf_token" value="{{ Session::token() }}" >
                          {{ method_field('PUT') }}

                          <div class="form-group">
                              <label class="col-sm-1 control-label">Fullname</label>
                              <div class="col-sm-5">
                                  <input name="fullname" value="{{ $user->fullname }}" type="text" class="form-control round-form">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-1 control-label">Email</label>
                              <div class="col-sm-5">
                                    <input name="email" value="{{ $user->email }}" type="email" class="form-control round-form">
                              </div>
                          </div> 
                          <div class="form-group">
                              <label class="col-sm-2 control-label">Birth Date</label>
                              <div class="col-sm-5">
                                  <input name="birth_date" value="{{ $user->birth_date }}" type="date" class="form-control round-form">
                              </div>
                          </div>
                          
                          <button type="submit" class="btn btn-info">Save</button>
                      </form>
          			</div><!-- /form-panel -->
          		</div><!-- /col-lg-12 -->
              </div><!-- /row -->

@endsection('bodyDashboard')