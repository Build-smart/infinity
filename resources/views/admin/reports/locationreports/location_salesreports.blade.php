@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Product Sales <small> Product Sales...</small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active"> Product Sales </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Product Sales</h3>

            <div class="box-tools pull-right">
              <form action="{{ URL::to('admin/locationstockreportprint')}}" target="_blank">
                <input type="hidden" name="page" value="invioce">
                <button type='submit' class="btn btn-default pull-right"><i class="fa fa-print"></i> {{ trans('labels.Print') }}</button>
              </form>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ProductID') }}</th>
                      <th>{{ trans('labels.ProductName') }}</th>
                      <th>Billing Price</th>
                    
                    </tr>
                  </thead>
                   <tbody>
                    
                    @foreach ($result['products'] as $pro)                   
                      <tr>
                          <td>{{ $pro->products_id }}</td>  
                          <td>{{ $pro->products_name }}</td>    
 
  
  <?php  // print_r(App\Models\Core\Reports::ajax_attr($pro->products_id));
                    $pro1=App\Models\Core\SaleReports::ajax_attr($pro->products_id);
                    ?>
  
<td>
 
 @if($pro->products_type == '1')
<div class="form-group">
     <div class="col-sm-10 col-md-8">
        @if(count($pro1['attributes'])==0 )
        <input type='hidden' id='has-attribute' value='0'>
<!--             <div class="alert alert-danger" role="alert"> -->
<!--               {  { trans('labels.You can not add stock without attribute for variable product') }} -->
<!--             </div> -->
        @else
        <input type='hidden' id='has-attribute' value='1'>
<!--         <ul class="list-group list-group-root well list-group-root2"> -->
		
		<?php $str1="";  
                 $str2=""; 
                 
                 $stack1 = array();
                 
                 $stack2 = array();
                 $i=1;  ?>
            @foreach ($pro1['attributes'] as $attribute)
  <!--          < li href="#" class="list-group-item"><label style="width:100%"> -->
<!--                     { { $attribute['option']['name']}}</label></li> -->
<!--             <ul class="list-group"> -->
<!--                 <li class="list-group-item"> -->
              
<!--                 { { $attr=array()}} -->
	 <?php $j=0;?>
                    @foreach ($attribute['values'] as $value)
                    <label> {{ $value['value'] }}</label> 
                        
<!--                         $attr=array_push($attr,$value['products_attributes_id']))  -->

<!-- { {!!$products_attributes_id=$value['products_attributes_id']!!}} -->
                         @if($i==1) 
                           
                          <?php 
						  
						   $str1=$str1.",".$value['products_attributes_id'];
						   
						   array_push($stack1, $value['products_attributes_id']);

						 // $str1[$j]=$value['products_attributes_id']'
						  ?>
                            @endif
                           
                            @if($i==2) 
                           
                       <?php $str2=$str2.",".$value['products_attributes_id'] ;
                       array_push($stack2, $value['products_attributes_id']);
                       ?>                       
                           @endif
                         
						 
						 <?php $j=$j+1;?>
                          @endforeach
                             <?php $i=$i+1; ?>
                    
                          
 
 
                          
<!--                           </li> -->
<!--             </ul> -->
            @endforeach
                
                  <?php  //print_r($str1);?>   
  <?php // print_r($str2);?> 
  
  <?php 
    foreach($stack1 as $s1)
  {
	$attributes=array();  
	
	if($stack2){
	  foreach($stack2 as $s2)
  {
  array_push($attributes, $s1,  $s2);
   
   $currentStockComplex1=App\Models\Core\SaleReports::currentstock($pro->products_id,$attributes);
   
   
   //print_r($currentStockComplex1);
   
 //	 echo  count($currentStockComplex1);
 echo "</br>";
  foreach($currentStockComplex1 as $key => $value)
{
	 
	if($key == "Options_values"){
		
		echo "<h3>".$key." = ". $value."</h3></br>";
		
	}else{
		echo $key." = ". $value."</br>";
	}

} 
echo "</p>";
   // echo $csc['Options_values'];
    
    
     
    	$attributes=array();  }
  }else{
  	array_push($attributes, $s1);
  	
  
  	$currentStockComplex2=App\Models\Core\SaleReports::currentstock($pro->products_id,$attributes);
  	 
  	echo "</br>";
  	foreach($currentStockComplex2 as $keys => $values)
  	{
  	
  		if($keys == "Options_values"){
  	
  			echo "<h3>".$keys." = ". $values."</h3></br>";
  	
  		}else{
  			echo $keys." = ". $values."</br>";
  		}
  	
  	}
  	echo "</p>";
  	
  	
  	$attributes=array();
  	 
  	
  }
  }
  ?>
  
    
                           
<!--                {  {  print_r(App\Models\Core\Reports::currentstock())  }}    -->
            
            
            <!--                             { {   App\Models\Core\Reports::currentstock($pro->products_id,$attr)  }}  -->
            
        
            
        </ul>
        @endif
        
    </div>
</div>

@elseif($pro->products_type == '0')
<div class="form-group">
     <div class="col-sm-10 col-md-8">
    <input type='hidden' id='has-attribute' value='1'>
        <input type='hidden' id='has-attribute' value='0'>
<!--             <div class="alert alert-info" role="alert"> -->
<!--               { { trans('labels.Now you can add stock for simple product') }} -->
<!--             </div> -->
         	     
         	     
         	     
         	     <?php 
         	     
         	      $currentStock=App\Models\Core\SaleReports::ajax_min_max($pro->products_id);
         	     /* 
         	      foreach($currentStock as $cs)
         	      {
         	      	echo $cs;
         	      }*/
         	      //$Products_max_stock='';
//          	     if($currentStock['stocks']){
//          	     	echo "Remaning Stock ".$currentStock['stocks']; 
//          	     }else{
//          	     	echo "Remaning Stock 0";
         	     	
//          	     }
         	      echo  "Product Price = ".$currentStock['product_price'];
         	      echo "</br>";
         	      echo  "Stock out = ".$currentStock['stockOut'];
          	    
         	      echo "</br>";
         	     
         	     if($currentStock['billing_price']){
         	     	echo "Billing Price = ".$currentStock['billing_price'];
         	     }else{
         	     	echo "Billing Price = 0";
         	     
         	     }
         	  //   echo "</br>";
         	      
//          	     if($currentStock['products_id']){
//          	     	echo "products_id ".$currentStock['products_id'];
//          	     }else{
//          	     	echo "products_id 0";
         	     	 
//          	     }
//          	     echo "</br>";
         	     
         	  
         	     // print_r($currentStock);
         	    /*foreach($currentStock as $key => $value)
         	      {
         	      
         	      	if($key == "Options_values"){
         	      
         	      		echo "<h3>".$key." = ". $value."</h3></br>";
         	      
         	      	}else{
         	      		echo $key." = ". $value."</br>";
         	      	}
         	      
         	      }
         	      echo "</p>";
         	     */
         	     
         	     
         	     // print_r($currentStock);
         	      
         	      ?> 
                    
                    
  
       
    </div>
</div>
@endif



</td>     
                                                                                            
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="col-xs-12 col-md-6 text-right">
                   {!! $result['products']->appends(\Request::except('page'))->render() !!}

                                </div> 

            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
