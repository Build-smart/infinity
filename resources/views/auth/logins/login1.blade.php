
<style>
.padding{
padding : 20px;
}

</style>
<!-- login Content -->
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
 
<section class="page-area pro-content">
	<div class="container">
 <div class="row">
				<div class="col-12 col-lg-4 col-sm-12 col-md-4 ">
					<img src="{{asset('images/construction/detailed.jpg')}}" width="500" alt="Login image">
				</div>
<div class="col-12 col-lg-2 col-sm-2 col-md-2 ">
</div>
				<div class="col-12 col-lg-6 col-sm-12 col-md-6">
				
				@if(Session::has('loginError'))
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="">@lang('website.Error'):</span>
									{!! session('loginError') !!}

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
							</div>
					@endif
					@if(Session::has('success'))
							<div class="alert alert-success alert-dismissible fade show" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="">@lang('website.success'):</span>
									{!! session('success') !!}

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
							</div>
					@endif
					<div class="col-12"><h4 class="heading login-heading">@lang('website.LOGIN')</h4></div>
					<div class="registration-process">

						<form  enctype="multipart/form-data"  class="form-validate-login" action="{{ URL::to('/process-login')}}" method="post">
							{{csrf_field()}}
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong> Phone Number Or Email</strong></label></div>
									<div class="input-group col-12">
										<input type="text" name="email" id="email" placeholder="Please enter your valid Email Address Or Phone Number"class="form-control email-validate-login">
										<span class="form-text text-muted error-content" hidden>Please enter your valid Email Address Or Phone Number</span>
								 </div>
								</div>
								<div class="from-group mb-3">
										<div class="col-12"> <label for="inlineFormInputGroup"><strong>@lang('website.Password')</strong></label></div>
										<div class="input-group col-12">
											<input type="password" name="password" id="password-login" placeholder="Please Enter Password" class="form-control password-login">
											<span class="form-text text-muted error-content" hidden>@lang('website.This field is required')</span>										</div>
									</div>

									<div class="col-12 col-sm-12">
										<button type="submit" class="btn btn-secondary">@lang('website.Login')</button>
									<a href="{{ URL::to('/forgotPassword')}}" class="btn btn-link">@lang('website.Forgot Password')</a>
									<a href="{{ URL::to('/create_account')}}" class="btn btn-link"><button type="button" class="btn btn-primary"> Create Account</button></a>
									 
								</div>
						</form>
					</div>
				 
				</div>
				 
			</div>

		 
				<!--div class="col-12 col-sm-12 my-5">
						<div class="registration-socials">
					<div class="row align-items-center justify-content-between">
									<div class="col-12 col-sm-6">
										@lang('website.Access Your Account Through Your Social Networks')
									</div>
									<div class="col-12 col-sm-6 right">

											@if($result['commonContent']['setting'][61]->value==1)
												<a href="login/google" type="button" class="btn btn-google"><i class="fab fa-google-plus-g"></i>&nbsp; @lang('website.Google') </a>
											@endif
											@if($result['commonContent']['setting'][2]->value==1)
												<a  href="login/facebook" type="button" class="btn btn-facebook"><i class="fab fa-facebook-f"></i>&nbsp;@lang('website.Facebook')</a>
											@endif
									</div>
							</div>
					</div>
				</div -->
				<!-- Button trigger modal -->

 	
			 

	</div>
</section>
