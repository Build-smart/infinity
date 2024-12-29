<!-- contact Content -->
<style>


.border-none{
	background-color: white !important;
    border: none !important;
}

.text-bold{

font-size:30px !important;
font-weight:700 !important;
}

.text-size{

font-size:30px !important;
 }

.contact-content .contact-info li span {
    width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
</style>
<style>
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  background: #04AA6D;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #04AA6D;
  cursor: pointer;
}
</style>
 
<section class="pro-content">
        
  <div class="container">
    <div class="page-heading-title">
        <h2 >Cost Calculator
        </h2>
     
        </div>
</div>
</section>

<section class="page-area  ">
	<div class="container">
	 
			<div class="row ">
				<div class="col-12 col-sm-12 col-md-6 bordershadows">
					  	<form  enctype="multipart/form-data"  method="get"  class="form-validate-login" action="{{ URL::to('/mobile_cost_calculator')}}" >
							{{csrf_field()}}
					 
					<div class="col-12"><h4 class="heading login-heading">Select Location</h4></div>
 
					 			<div class="from-group mb-3">
												<div class="col-12" > <label for="inlineFormInputGroup">Select City <strong  style="color: red;">*</strong></label></div>
												
												<div class="input-group col-12">
													<select name="selectcity" id="selectcity" onchange="" class="form-control " required="required">
														<option  >Select City</option>
 														@foreach($result['allcities'] as $city)
		 
													<option value="{{$city->city}}" @if($city->city == Session::get('SELECTEDCITY') )
                                                                selected
                                                                @endif>{{$city->city}}</option>
   			  										
													@endforeach
														
													</select>
													<span class="form-text text-muted error-content" hidden>Please select city for construction cost estimation.</span>
												</div>
												</div>
												<div class="from-group mb-3">
													<div class="col-12 mb-3" > <label for="inlineFormInputGroup" >Area in Sq Feet (Drag to change)<strong  style="color: red;">*</strong></label></div>
												<div class="input-group   col-12 "   >
											 
												
														  @if (!empty(Session::get('SELECTEDAREA')))
														<input type="range"  min="0" max="10000" name="area" id="area"  value="{{Session::get('SELECTEDAREA')}}" required="required"     placeholder="Enter In Square Feet" class="  slider">
														   @else
													 
														<input type="range"  min="0" max="10000" name="area" id="area"  value="10" required="required"     placeholder="Enter In Square Feet" class="  slider">
														
														 @endif
	<br><br>													  <span id="selarea"></span>
														 
													 
													
													
													<span class="form-text text-muted error-content" hidden>Enter area of the plot/construction area</span>
											
												</div>
												  
												
											</div>
								 

									<div class="col-12 col-sm-12 ">
										<button type="submit" class="btn btn-secondary">Submit</button>
 									  
								</div>
								
								</form>
 					</div>
					
					<div class="col-12 col-sm-12 col-md-6 bordershadows">
					<div class="col-12"><h4 class="heading login-heading">Total Estimation Cost for  {{Session::get('SELECTEDAREA')}}</h4></div>
					<div class="from-group mb-3">
												 
												
													<div class="input-group col-12">
													
													<div class="col-12" > <label for="inlineFormInputGroup">  </label></div>
										 		 <p class="text-size">₹</p><input type="number" id="totalamount" name="totalamount" value="0" readonly class="form-control border-none text-bold">
 
 												</div>
												
											</div>
					
					</div>
				</div>

				 
			</div>
 
</section>

<input type="hidden" id="requestedarea" value="{{Session::get('SELECTEDAREA')}}">
   @if (!empty(Session::get('SELECTEDCITY')))
	 
<section class="contact-content pro-content">
  <div class="container"> 
  
  
    <div class="row">
      <div class="col-12 col-sm-12 ">
	  
	  <table class="table order-table table table-bordered table-striped table-hover">
	  
	  <thead>
	  <tr class="d-flex">
	  <th class="col-12 col-md-4" >Resource</th>
	  <th class="col-12 col-md-2" >Unit</th>
	  <th class="col-12 col-md-2" >Quantity</th>
	  <th class="col-12 col-md-2">Quality</th>
	  <th class="col-12 col-md-2" >Amount</th>
	  </tr>
	  <thead>
	  
	  <tbody>
	  <tr  class="d-flex">
	  <td class="col-12 col-md-4">Cement</td>
	  <td class="col-12 col-md-2">Bag</td>
	  <td class="col-12 col-md-2">  <input type="text" id="cement_quantity" class="form-control border-none" value="0" readonly></td>
	  <td class="col-12 col-md-2">
	  
	  	@if (!empty(Session::get('SELECTEDCITY')))
		
	   
	   <select    class="form-control cement materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
		
		 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="cement_{{$cost_calculator_data->id}}"   value="{{$cost_calculator_data->cement}}">{{$cost_calculator_data->materialquality}}</option>
  
    @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	
	  
	  </td>
	  <td class="col-12 col-md-2">  <input type="number" id="cement_subtotal" class="subtotal form-control border-none" readonly value="0"></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Steel</td>
	  <td class="col-12 col-md-2">KG</td>
	  <td class="col-12 col-md-2">  <input type="text" id="steel_quantity" class="form-control border-none" value="0" readonly></td> 
	  <td class="col-12 col-md-2">
	  	@if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control steel materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="steel_{{$cost_calculator_data->id}}"   value="{{$cost_calculator_data->steel}}">{{$cost_calculator_data->materialquality}}</option>
  @endif
		
	  @endforeach
	  </select>
	  @else
		 
				PLEASE SELECT CITY AND AREA

		
  @endif
	  
	  </td>
	  <td class="col-12 col-md-2"> <input type="number" id="steel_subtotal" class="subtotal form-control border-none" readonly value="0"></td>
	  </tr>
	  
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Bricks</td>
	  <td class="col-12 col-md-2">Per Piece</td>
	  <td class="col-12 col-md-2"> <input type="text" id="bricks_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
	
	  <select   class="form-control bricks materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
				 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="bricks_{{$cost_calculator_data->id}}"   value="{{$cost_calculator_data->bricks}}">{{$cost_calculator_data->materialquality}}</option>
	 @endif
		
	  @endforeach
	  </select>
	  @else
		 
				PLEASE SELECT CITY AND AREA

		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="bricks_subtotal" class="subtotal form-control border-none" readonly value="0"></td>
	  </tr>
	  
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Aggregate</td>
	  <td class="col-12 col-md-2">Per Cubic feet</td>
	   <td class="col-12 col-md-2"> <input type="text" id="aggregate_quantity"  class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
	
	  <select   class="form-control aggregate materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
				 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="aggregate_{{$cost_calculator_data->id}}"   value="{{$cost_calculator_data->aggregate}}">{{$cost_calculator_data->materialquality}}</option>
	 @endif
		
	  @endforeach
	  </select>
	  @else
		 
				PLEASE SELECT CITY AND AREA

		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="aggregate_subtotal" class="subtotal form-control border-none" readonly value="0"></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Sand</td>
	  <td class="col-12 col-md-2">Per Cubic feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="sand_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control sand materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="sand_{{$cost_calculator_data->id}}"  value="{{$cost_calculator_data->sand}}">{{$cost_calculator_data->materialquality}}</option>
	   @endif
		
	  @endforeach
	  </select>
	  @else
		 
				PLEASE SELECT CITY AND AREA
 
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="sand_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Flooring</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="flooring_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select class="form-control flooring materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="flooring_{{$cost_calculator_data->id}}" value="{{$cost_calculator_data->flooring}}">{{$cost_calculator_data->materialquality}}</option>
	   @endif
		
	  @endforeach
	  </select>
	  @else
		 
				PLEASE SELECT CITY AND AREA

		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="flooring_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Windows</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="windows_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control windows materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
		   
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="windows_{{$cost_calculator_data->id}}" value="{{$cost_calculator_data->windows}}">{{$cost_calculator_data->materialquality}}</option>
	   @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="windows_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Doors</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="doors_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control doors materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="windows_{{$cost_calculator_data->id}}" value="{{$cost_calculator_data->doors}}">{{$cost_calculator_data->materialquality}}</option>
	  @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="doors_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Electrical fittings</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="electricalfittings_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control electricalfittings materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option  data-id="electricalfittings_{{$cost_calculator_data->id}}" value="{{$cost_calculator_data->electricalfittings}}">{{$cost_calculator_data->materialquality}}</option>
	   @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="electricalfittings_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Painting</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="painting_quantity"  class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control painting materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="painting_{{$cost_calculator_data->id}}"  value="{{$cost_calculator_data->painting}}">{{$cost_calculator_data->materialquality}}</option>
	 	   @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="painting_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Sanitary Fittings</td>
	 <td class="col-12 col-md-2">Per Sq feet</td>
	  <td  class="col-12 col-md-2"><input type="text" id="sanitaryfitting_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control sanitaryfitting materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
			 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option  data-id="sanitaryfitting_{{$cost_calculator_data->id}}" value="{{$cost_calculator_data->sanitaryfitting}}">{{$cost_calculator_data->materialquality}}</option>
	     @endif
		
	  @endforeach
	  </select>
	  
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="sanitaryfitting_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Kitchen Work</td>
	 <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="kitchenwork_quantity" class="form-control border-none" value="0" readonly></td> 
	  <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
	
	  <select  class="form-control kitchenwork materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
				 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="kitchenwork_{{$cost_calculator_data->id}}"  value="{{$cost_calculator_data->kitchenwork}}">{{$cost_calculator_data->materialquality}}</option>
	  @endif
		
	  @endforeach
	  </select>
	  
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="kitchenwork_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  <tr class="d-flex">
	  <td class="col-12 col-md-4">Contractor(RCC,BrickWork,plasterwork)</td>
	  <td class="col-12 col-md-2">Per Sq feet</td>
	  <td class="col-12 col-md-2"><input type="text" id="contractorcharges_quantity" class="form-control border-none" value="0" readonly></td> 
	   <td class="col-12 col-md-2">
	  @if (!empty(Session::get('SELECTEDCITY')))
		
	  <select   class="form-control contractorcharges materialquality"> 
	    @foreach($result['cost_calculator'] as $cost_calculator_data)
				 @if($cost_calculator_data->city==Session::get('SELECTEDCITY'))
	  <option data-id="contractorcharges_{{$cost_calculator_data->id}}"  value="{{$cost_calculator_data->contractorcharges}}">{{$cost_calculator_data->materialquality}}</option>
	    @endif
		
	  @endforeach
	  </select>
	  @else
		 
		PLEASE SELECT CITY AND AREA
		
  @endif
	  </td>
	  <td class="col-12 col-md-2"><input type="number" id="contractorcharges_subtotal" class="subtotal form-control border-none" value="0" readonly></td>
	  </tr>
	  
	  </tbody>
	  
	  </table>
	  
      </div>
    </div>
    
  </div>      
</section>
 @endif
<script>
	var slider = document.getElementById("area");


	
	var output = document.getElementById("selarea");

	  
	 
			output.innerHTML = slider.value; // Display the default slider value
	  
	// Update the current slider value (each time you drag the slider handle)
	slider.oninput = function() {
	  output.innerHTML = this.value;
	}

 </script>
<script>  
        $(document).ready(function () {  
        
            
            	//$("#area").on("change", function() {
            
           // $("#selarea").html( $("#area").val()) ;
             
            //	});

		 defaultcalculator();
		
		 	 


					 function defaultcalculator(){
					 
				 var cement_quantity = $("#requestedarea").val() * 0.45;
			 
				 $("#cement_quantity").val(Math.trunc(cement_quantity));
				 
				  var cement_amount=$(".cement").val();
				   
				 var cement_subtotal_amount =  cement_amount * cement_quantity;
				  
				   $("#cement_subtotal").val(Math.trunc(cement_subtotal_amount));
				   
				   
				   		   	 
				 var steel_quantity = $("#requestedarea").val() * 3.5;
 
				 
				 $("#steel_quantity").val(Math.trunc(steel_quantity));
 
				  var steel_amount=$(".steel").val();

				   
				 var steel_subtotal_amount =  steel_amount * steel_quantity;
				  
				   $("#steel_subtotal").val(Math.trunc(steel_subtotal_amount));
				   
				   	 
				
					
					   	 
				 var bricks_quantity = $("#requestedarea").val() * 19;
			 
				 $("#bricks_quantity").val(Math.trunc(bricks_quantity));
				 
				  var bricks_amount=$(".bricks").val();
				   
				 var bricks_subtotal_amount =  bricks_amount * bricks_quantity;
				  
				   $("#bricks_subtotal").val(Math.trunc(bricks_subtotal_amount));
				   
				   
				    var aggregate_quantity = $("#requestedarea").val() * 1.9;
			 
				 $("#aggregate_quantity").val(Math.trunc(aggregate_quantity));
				 
				  var aggregate_amount=$(".aggregate").val();
				   
				 var aggregate_subtotal_amount =  aggregate_amount * aggregate_quantity;
				  
				   $("#aggregate_subtotal").val(Math.trunc(aggregate_subtotal_amount));
				   
				   
				   
				    var sand_quantity = $("#requestedarea").val() * 2;
			 
				 $("#sand_quantity").val(Math.trunc(sand_quantity));
				 
				  var sand_amount=$(".sand").val();
				   
				 var sand_subtotal_amount =  sand_amount * sand_quantity;
				  
				   $("#sand_subtotal").val(Math.trunc(sand_subtotal_amount));
				   
				    
					  var flooring_quantity = $("#requestedarea").val() * 1;
			 
				 $("#flooring_quantity").val(Math.trunc(flooring_quantity));
				 
				  var flooring_amount=$(".sand").val();
				   
				 var flooring_subtotal_amount =  flooring_amount * flooring_quantity;
				  
				   $("#flooring_subtotal").val(Math.trunc(flooring_subtotal_amount));



					  var windows_quantity = $("#requestedarea").val() * 0.17;
			 
				 $("#windows_quantity").val(Math.trunc(windows_quantity));
				 
				  var windows_amount=$(".windows").val();
				   
				 var windows_subtotal_amount =  windows_amount * windows_quantity;
				  
				   $("#windows_subtotal").val(Math.trunc(windows_subtotal_amount));



				   var doors_quantity = $("#requestedarea").val() * 0.18;
					 
					 $("#doors_quantity").val(Math.trunc(doors_quantity));
					 
					  var doors_amount=$(".doors").val();
					   
					 var doors_subtotal_amount =  doors_amount * doors_quantity;
					  
					   $("#doors_subtotal").val(Math.trunc(doors_subtotal_amount));



						   var electricalfittings_quantity = $("#requestedarea").val() * 0.15;
						 
						 $("#electricalfittings_quantity").val(Math.trunc(electricalfittings_quantity));
						 
						  var electricalfittings_amount=$(".electricalfittings").val();
						   
						 var electricalfittings_subtotal_amount =  electricalfittings_amount * electricalfittings_quantity;
						  
						   $("#electricalfittings_subtotal").val(Math.trunc(electricalfittings_subtotal_amount));
						    
						   var painting_quantity = $("#requestedarea").val() * 6;
							 
							 $("#painting_quantity").val(Math.trunc(painting_quantity));
							 
							  var painting_amount=$(".painting").val();
							   
							 var painting_subtotal_amount =  painting_amount * painting_quantity;
							  
							   $("#painting_subtotal").val(Math.trunc(painting_subtotal_amount));


							   var sanitaryfitting_quantity = $("#requestedarea").val() * 1;
								 
								 $("#sanitaryfitting_quantity").val(Math.trunc(sanitaryfitting_quantity));
								 
								  var sanitaryfitting_amount=$(".sanitaryfitting").val();
								   
								 var sanitaryfitting_subtotal_amount =  sanitaryfitting_amount * sanitaryfitting_quantity;
								  
								   $("#sanitaryfitting_subtotal").val(Math.trunc(sanitaryfitting_subtotal_amount));

									   var kitchenwork_quantity = $("#requestedarea").val() * 0.055;
									 
									 $("#kitchenwork_quantity").val(Math.trunc(kitchenwork_quantity));
									 
									  var kitchenwork_amount=$(".kitchenwork").val();
									   
									 var kitchenwork_subtotal_amount =  kitchenwork_amount * kitchenwork_quantity;
									  
									   $("#kitchenwork_subtotal").val(Math.trunc(kitchenwork_subtotal_amount));
									    			    		    
				   
				    var contractorcharges_quantity = $("#requestedarea").val() ;
			 
				 $("#contractorcharges_quantity").val(Math.trunc(contractorcharges_quantity));
				 
				  var contractorcharges_amount=$(".contractorcharges").val();
				   
				 var contractorcharges_subtotal_amount =  contractorcharges_amount * contractorcharges_quantity;
				  
				   $("#contractorcharges_subtotal").val(Math.trunc(contractorcharges_subtotal_amount));
				   
				   
				   calculateTotal();	

				 }
				 
        
    
			
			//
			function calculateTotal(){
			$("#totalamount").val(0);
			  var totalamt=0;
				  $(".subtotal").each(function () {  

                    //alert($(this).val());  
					totalamt=parseInt(totalamt)+parseInt($(this).val());
					
                }); 

$("#totalamount").val(totalamt);	

 
			}
			
			
			$(".materialquality").on("change", function() {
     // alert($(this).val());

  var resource_amount=$(this).val();
    var data_id = $(this).find(':selected').attr('data-id');


 // alert(data_id);
  
  var resourcename=data_id.substring(0, data_id.indexOf("_"));
 // alert("Resource "+resourcename);
  
 // alert($("#"+resourcename+"_subtotal").val());
 // alert($("#"+resourcename+"_quantity").val());
 // var subtotal=$("#"+resourcename+"_subtotal").val() *  $("#"+resourcename+"_quantity").val();
 
  var subtotal=resource_amount *  $("#"+resourcename+"_quantity").val();
 // alert(subtotal);
$("#"+resourcename+"_subtotal").val(subtotal);



	$("#totalamount").val(0);
	calculateTotal();	

});

 
 	
  
        });  
 </script>  
 