

<!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Location Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Change location will remove the items in the cart and items will reset to selected location.
      </div>
      <div class="modal-footer">
	  
	    <button type="button" id="changeLocationNow" class="btn btn-secondary">Yes, Change Location</button>
		
        <button type="button" id="cancel" class="btn btn-primary" data-dismiss="modal">Don't Change Location</button>
      
      </div>
    </div>
  </div>
</div>
 
<script>

$("#changeMobileLocation").change(function () {                            
   var location_id= $('select[name=changeMobileLocation]').val() // Here we can get the value of selected item
   changeNow(location_id);
});


 $('.changeLocation').on('click', function(e) {

	
	 //get the selected item. data id and pass to the  change_location
 			 var location_id = $(this).attr('data-id');
			   
    changeNow(location_id);
    });

 
 function changeNow(location_id){
	   $('#locationModal').modal({
          backdrop: 'static',
          keyboard: false
      })
      .on('click', '#changeLocationNow', function(e) {
  jQuery.ajax({
    		    beforeSend: function (xhr) { // Add this line
    		            xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
    		     },
    		    url: '{{ URL::to("/change_location")}}',
    		    type: "POST",
    		    data: {"location_id":location_id,"_token": "{{ csrf_token() }}"},
    		    success: function (res) {
    		      window.location.reload();
    		    },
    		  });
        });
		
      $("#cancel").on('click',function(e){
       e.preventDefault();
       $('#locationModal').modal.model('hide');
      });
	   	  
 }

 
 
</script>
