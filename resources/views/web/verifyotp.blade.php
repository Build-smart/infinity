@extends('web.layout')
@section('content')


<div class="container-fuild">
	<nav aria-label="breadcrumb">
		<div class="container">
			<ol class="breadcrumb">
			  <li class="breadcrumb-item"><a href="{{ URL::to('/')}}">@lang('website.Home')</a></li>
			  <li class="breadcrumb-item active" aria-current="page">@lang('website.Login')</li>

			</ol>
		</div>
	  </nav>
  </div> 

<!-- page Content -->
<section class="page-area">
  <div class="container">
 
      <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-6" >
         <h3 class="text-center">Do Not Refresh the Page </h3> 
        
            @if(Session::has('flash_message'))
                    <div class="alert alert-success" style="margin-top:50px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
           
							 
          
          <div class="col-12 my-5">

             <h5>Verify OTP</h5>
             <hr style="margin-bottom: 0;">
                <div class="tab-content" id="registerTabContent">
                  <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                      <div class="registration-process">
                      <form name="verifyotpform" id="verifyotpform" enctype="multipart/form-data" class="form-validate"  action="{{ URL::to('/verifyCustomOTP')}}" method="post">
                        {{csrf_field()}}
                 
                      
                                                      <input class="form-control"  type="hidden" name="phone" id="phone" value="{{$phone}}"  placeholder="Please Enter OTP">
                                                       <input class="form-control"  type="hidden" name="email" id="email" value="{{$email}}"  placeholder="Please Enter OTP">
                        
                          <div class="from-group mb-3">
                            <div class="col-12"> <label for="inlineFormInputGroup">OTP</label></div>
                            <div class="input-group col-12">
                              <div class="input-group-prepend">
                                  <div class="input-group-text"><i class="fas fa-lock"></i></div>
                              </div>
                              <input class="form-control" type="text" name="phone_otp_code" id="phone_otp_code"  placeholder="Please Enter OTP">
                              <span class="help-block error-content" hidden>@lang('website.Please enter your valid email address')</span>                            </div>
                          </div>
                            <div class="col-6 col-sm-12">
                                <button type="submit"  class="btn btn-secondary">VERIFY NOW</button>
 
                            </div>
                            
                            
                                                   <div class="col-12 col-sm-12" style="text-align: right;">
                                <button type="button"  id="resendotp" class="btn btn-secondary">Resend</button>
 
                            </div>
                      </form>
                                            <!-- form  name="signup" enctype="multipart/form-data" class="form-validate"  action="{{ URL::to('/resendLoginVerificationOTP')}}" method="post"-->
                    
                        
                          <h3 style="color:navyblue" align="center">
 <span id='timer'></span>
 </h3>

                            
                            <!-- /form -->
                      

                  </div>

                   
                </div>
          </div>
        </div>
</div>
      </div>
  </div>
</section>


@endsection






