
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
			  <li class="breadcrumb-item active" aria-current="page">Create Account</li>

			</ol>
		</div>
	  </nav>
  </div> 
 
<section class="page-area pro-content">
	<div class="container">
 <div class="row">
				<div class="col-12 col-lg-5 col-sm-12 col-md-5 ">
					<img src="{{asset('images/construction/detailed.jpg')}}" width="500" alt="Login image">
				</div>
<div class="col-12 col-lg-1 col-sm-1 col-md-1 ">
</div>
				<div class="col-12 col-lg-6 col-sm-12 col-md-6">
						<div class="col-12"><h4 class="heading login-heading">Create Account</h4></div>
						<div class="registration-process">
							@if( count($errors) > 0)
								@foreach($errors->all() as $error)
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">@lang('website.Error'):</span>
										{{ $error }}
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
								 @endforeach
							@endif

							@if(Session::has('error'))
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only">@lang('website.Error'):</span>
									{!! session('error') !!}

									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							@endif

							<form name="signup" enctype="multipart/form-data" class="form-validate" action="{{ URL::to('/signupProcess')}}" method="post">
								{{csrf_field()}}
								
								<div class="row">
								
								<div class="col-12 col-lg-6 col-sm-12 col-md-6">
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.First Name')</strong></label></div>
									<div class="input-group col-12">
										<input  name="firstName" tabindex=1 type="text" class="form-control field-validate" id="firstName" placeholder="@lang('website.Please enter your first name')" value="{{ old('firstName') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your first name')</span>
									</div>
								</div>
								

								 

									<div class="from-group mb-3">
										<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.Email Adrress')</strong></label></div>
										<div class="input-group col-12">
											<input  name="email" tabindex=3  type="text" class="form-control email-validate" id="inlineFormInputGroup" placeholder="Enter Your Email or Username" value="{{ old('email') }}">
											<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid email address')</span>
										</div>
									</div>
									
									
									<div class="from-group mb-3">
											<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.Password')</strong></label></div>
											<div class="input-group col-12">
												<input name="password" tabindex=5 id="password" type="password" class="form-control password"  placeholder="@lang('website.Please enter your password')">
												<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your password')</span>

											</div>
										</div>
									
									
								</div>
								
								
								<div class="col-12 col-lg-6 col-sm-12 col-md-6">
								
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.Last Name')</strong></label></div>
									<div class="input-group col-12">										
										<input  name="lastName" tabindex=2 type="text" class="form-control field-validate" id="lastName" placeholder="@lang('website.Please enter your first name')" value="{{ old('lastName') }}">
										<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your last name')</span>
									</div>
								</div>
								
								<div class="from-group mb-3">
												<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.Phone Number')</strong></label></div>
												<div class="input-group col-12">
													<input  name="phone" tabindex=4 type="text" class="form-control phone-validate" maxlength="10" id="phone" placeholder="@lang('website.Please enter your valid phone number')" value="{{ old('phone') }}">
													<span class="form-text text-muted error-content" hidden>@lang('website.Please enter your valid phone number')</span>
												</div>
											</div>
								
								 
											 
										<div class="from-group mb-3">
												<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>@lang('website.Confirm Password')</strong></label></div>
												<div class="input-group col-12">
													<input type="password" tabindex=6 class="form-control password" id="re_password" name="re_password" placeholder="Enter Your Password">
													<span class="form-text text-muted error-content" hidden>@lang('website.Please re-enter your password')</span>
													<span class="form-text text-muted re-password-content" hidden>@lang('website.Password does not match the confirm password')</span>
												</div>
											</div>	
													
											
											
											
								</div>
								<div class="col-12 col-lg-12 col-sm-12 col-md-12">
								
								<div class="from-group mb-3">
												<div class="col-12" > <label for="inlineFormInputGroup"><strong  style="color: red;">*</strong><strong>Customer Type</strong></label></div>
												<div class="input-group col-12">
													<select class="form-control customer_type field-validate" tabindex=7 name="customer_type" id="inlineFormCustomSelect">
														<option selected value="">@lang('website.Choose...')</option>
														<option value="CUSTOMER" @if(!empty(old('customertype')) and old('customertype')=="CUSTOMER") selected @endif>Customer</option>
														<option value="BUSINESSOWNER" @if(!empty(old('customertype')) and old('customertype')=="BUSINESSOWNER") selected @endif>Workforce</option>
														<option value="CLIENT" @if(!empty(old('customertype')) and old('customertype')=="CLIENT") selected @endif>Home Builder or  House Contractor</option>
													</select>
													<span class="form-text text-muted error-content" hidden>Please select customer type</span>
												</div>
											</div>
											</div>
								<div class="col-12 col-lg-12 col-sm-12 col-md-12" id="workforce">
								<div class="from-group mb-3">
									<div class="col-12"> <label for="inlineFormInputGroup"><strong style="color: red;">*</strong><strong>Workforce name</strong></label></div>
									<div class="input-group col-12">										
										<input  name="workforce_name" type="text" class="form-control  " id="workforce_name" placeholder="Please enter Workforce name" value="{{ old('workforce_name') }}">
										<span class="form-text text-muted error-content" hidden>Please enter Workforce name</span>
									</div>
								</div>
								
								</div>
								
								
								
								<div class="col-12 col-lg-12 col-sm-12 col-md-12">
								
								
											<div class="from-group mb-3">
													<div class="input-group col-12">
														<input required style="margin:4px;" tabindex=8 class="form-controlt checkbox-validate" type="checkbox">
														@lang('website.Creating an account means you are okay with our')  @if(!empty($result['commonContent']['pages'][3]->slug))&nbsp;<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][3]->slug)}}">@endif @lang('website.Terms and Services')@if(!empty($result['commonContent']['pages'][3]->slug))</a>@endif, @if(!empty($result['commonContent']['pages'][1]->slug))<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][1]->slug)}}">@endif @lang('website.Privacy Policy')@if(!empty($result['commonContent']['pages'][1]->slug))</a> @endif &nbsp; and &nbsp; @if(!empty($result['commonContent']['pages'][2]->slug))<a href="{{ URL::to('/page?name='.$result['commonContent']['pages'][2]->slug)}}">@endif @lang('website.Refund Policy') @if(!empty($result['commonContent']['pages'][3]->slug))</a>@endif.
														<span class="form-text text-muted error-content" hidden>@lang('website.Please accept our terms and conditions')</span>
													</div>
												</div>
								</div>
								
								</div>
								
									
								<!--div class="col-12 col-sm-12">
									<div class="from-group mb-3">
													<div class="input-group col-12">
										
                @ if(config('services.recaptcha.key'))
    <div class="g-recaptcha"
        data-sitekey="  {   {config('services.recaptcha.key')}}">
    </div>
@ endif</div></div></div -->
								
									
										<div class="col-12 col-sm-12">
												<button type="submit" tabindex=9 class="btn btn-light swipe-to-top">@lang('website.Create an Account')</button>
												
												<!--button class="g-recaptcha btn btn-light swipe-to-top"
data-sitekey="6LcnhcUlAAAAAKKWpmW6LRsTvLzfKo_xDKUpGfUc"
data-callback='onSubmit'
data-action='submit'>@lang('website.Create an Account')</button-->

										</div>
							</form>
						</div>
				</div>
				 
			</div>

		 
				 

 
 
				
			 

	</div>
</section>
