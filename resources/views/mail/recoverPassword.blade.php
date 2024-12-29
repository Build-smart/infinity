<div style="width: 100%; display:block;">
    <img  src="https://buildermart.in/images/media/2021/11/uksTb18406.png"><a style="margin-left:20px" href="https://buildermart.in/login">Your Account</a>  <a style="margin-left:20px" href="https://buildermart.in/">Buildermart.in</a> 

<h2>{{ trans('labels.EcommercePasswordRecovery') }}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $existUser[0]->first_name }} {{ $existUser[0]->last_name }}!</strong><br>
	{{ trans('labels.recoverPasswordEmailText') }}<br>
	{{ trans('labels.Yourpasswordis') }} <strong>{{ $existUser[0]->password }}</strong><br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>
