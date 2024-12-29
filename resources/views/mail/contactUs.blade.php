

<div style="width: 100%; display:block;">
    
    <img  src="https://buildermart.in/images/media/2021/11/uksTb18406.png"><a style="margin-left:20px" href="https://buildermart.in/login">Your Account</a>  <a style="margin-left:20px" href="https://buildermart.in/">Buildermart.in</a> 

<h2>{{ trans('labels.back') }}</h2>
<p>
	<strong>
   	{{ trans('labels.HiAdmin') }}!
   	</strong><br><br>
    
	{{ trans('labels.Name') }}: {{ $data['name'] }}<br>
	{{ trans('labels.Email') }}: {{ $data['email'] }}<br><br>
	
	{{ $data['message'] }}<br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.ecommerceAppTeam') }}
</p>
</div>