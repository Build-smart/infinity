<div style="width: 100%; display:block;">
    
    <img  src="https://buildermart.in/images/media/2021/11/uksTb18406.png"><a style="margin-left:20px" href="https://buildermart.in/login">Your Account</a>  <a style="margin-left:20px" href="https://buildermart.in/">Buildermart.in</a> 

<h2>{{ trans('labels.NewProductEmailTitle') }}</h2>
<p>
	<strong>{{ trans('labels.Hi') }} {{ $customers_data->first_name }} {{ $customers_data->last_name }}!</strong><br>
	
    {{ trans('labels.NewProductEmailPart1') }} <strong>{{$customers_data->product[0]->products_name}}</strong> {{ trans('labels.NewProductEmailPart2') }}
    <br><br>
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ trans('labels.regardsForThanks') }}
</p>
</div>