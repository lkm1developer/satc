		jQuery( document ).ready(function() {
		jQuery('.loader').hide();
		
		
		jQuery('#continue_coin').on('click', function() {
		var step=jQuery('#step_id').val();	
		jQuery('#step_id').val(parseInt(step)+1);	
		masternode(2)
		})
		function AfterResponse(step){
			jQuery('#step_id').val(step);			
			jQuery('.prgrs').show();

		}
		
		
		function move(percent) {		
		jQuery("#prgrsbar").width(percent+'%');
		jQuery('.prcnt').html(percent+'%');

		}
		
		jQuery('#launchmasternodenow').click(function(event){
		event.preventDefault();
		masternode(2)

		});


		function masternode(step){
		jQuery('#errordata_div').hide();
		jQuery('#successdata_div').hide();
		var url=jQuery('meta[name="base_url"]').attr('content')+'/admin';
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
		swal({title:'processing...'});
		swal.showLoading();
		jQuery('.loader').show();
		//jQuery('.modal-footer').hide();
		jQuery.ajax({   
		url: url+'/masternodecreate/'+step,
		type: 'POST',
		
		data: { 

		_token:csrf_token,coinid:jQuery('#coinid').val(),sharednode_id:jQuery('#sharednode_id').val()

		},
		error: function (xhr, status, error) {
			swal.close()
		jQuery('.loader').hide();
		jQuery('#errordata_div').show();
		jQuery('#errordata').html('Oops!! Something went wrong');
		},
		success: function (res) {
			swal.close()
		jQuery('.loader').hide();
		jQuery('.prgrs').show();
		//jQuery('.modal-footer').show();
		var response=jQuery.parseJSON(res);
		console.log('response',response);
		if(!response.status){
		jQuery('#errordata_div').show();
		jQuery('#errordata').html(response.data);
		}
		if(response.status){
		console.log('step'+(response.step)*20);
		if(!(response.step==null )){
		jQuery('#successdata_div').show();
		jQuery('#successdata').html(response.data);
		}
		if(response.step==6){
			jQuery('#successdata_div').show();
		jQuery('#successdata').html(response.data);
		return false;
		}else{
		jQuery('#successdata_div').show();
		jQuery('#successdata').html(response.data);
		masternode(response.step)
		}
		}
		}      
		
		});
		}
		function Startmasternode(){
		jQuery('#errordata_div').hide();
		jQuery('#successdata_div').hide();
		var url=jQuery('meta[name="base_url"]').attr('content');
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');

		jQuery('.loader').show();

		jQuery.ajax({

		url: url+'/masternodestart',
		type: 'POST',
		// dataType: 'json',
		// cache: false,
		data: { 

		_token:csrf_token,coinid:jQuery('#coinid').val()

		},
		error: function (xhr, status, error) {
		jQuery('.loader').hide();
		jQuery('#errordata_div').show();
		jQuery('#errordata').html('Oops!! Something went wrong');
		},
		success: function (res) {
		jQuery('.loader').hide();
		jQuery('.prgrs').show();
		var response=jQuery.parseJSON(res);
		console.log('response',response);
		if(!response.status){
		jQuery('#errordata_div').show();
		jQuery('#errordata').html(response.data);
		}
		if(response.status){
		console.log('step'+(response.step)*20);
		if(!(response.step==null )){
		jQuery('#successdata_div').show();
		jQuery('#successdata').html(response.data);
		move((response.step)*20);}
		//jQuery('#myProgressdiv').html(response.data);
		if(response.step>=4.5){
		jQuery('#step_id').val(5);
		jQuery('.stepcontent').hide();
		jQuery('#step_5').show();

		}
		else{
		jQuery('#successdata_div').show();
		jQuery('#successdata').html(response.data);

		}



		}

		}
		});
		}

		jQuery('.checkstatus').click(function(){
		var url=jQuery('meta[name="base_url"]').attr('content');
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
		swal({title: 'Geting masternode status'});swal.showLoading();
		jQuery.ajax({
		url: url+'/admin/checkstatus/'+jQuery(this).attr('coin'),
		type: 'POST',
		data: { 
		_token:csrf_token,coinid:jQuery('#coinid').val(),
		masternode_id:jQuery(this).attr('id'),
		coinid:jQuery(this).attr('coin')
		},
		error: function (xhr, status, error) {
		swal.close();
		swal({title:'Oops!! Something went wrong'});
		
		},
		success: function (res) {
		swal.close();
		// var response=jQuery.parseJSON(res);
		var response=(res);
		console.log(response.err);
		if(!response.err){
		swal({
		title: 'Masternode is Running',
		html:response.data ,
		type: 'success',
		confirmButtonText: 'Cool'
		})
		}
		if(response.err){
		swal({
		title: 'Error!',
		text: 'Masternode is not running',
		html:response.data ,
		type: 'error',
		confirmButtonText: 'ok'
		})
		}                    
		}
		});
		});
		jQuery('.deletemasternode').click(function(){
		
		var  swalWithBootstrapButtons = swal.mixin({
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
})

var ck=swalWithBootstrapButtons({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
	 var mid=jQuery(this).attr('id');
	 var cid=jQuery(this).attr('coin')
	 deletemasyterniode(mid,cid);
    swalWithBootstrapButtons(
      'Deleteting...',
      '',
      'warning'
    )
  } else if (
    // Read more about handling dismissals
    result.dismiss === swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons(
      'Cancelled',
      'Your Masternode is safe :)',
      'error'
    )
	return false;
  }
});
console.log('ck',ck);
// return false;
		// swal({title: 'Processing...'});swal.showLoading();//swal.close();
	
		 
	});
	
function deletemasyterniode(mid,cid){
	 var url=jQuery('meta[name="base_url"]').attr('content');
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
	 jQuery.ajax({
           
            url: url+'/admin/masternode/delete/'+mid,
            type: 'POST',
          
            data: { 
             
              _token:csrf_token,coinid:cid,
              masternode_id:mid,
              coinid:cid
            },
            error: function (xhr, status, error) {
				swal.close();
				jQuery('#errordata_div').show();
				jQuery('#errordata').html('Oops!! Something went wrong');
            },
            success: function (res) {
			swal.close();
			
				//var response=jQuery.parseJSON(res);
				var response=res;
				
                if(response.status){
				var ck=	swal({
						  title: 'Masternode has been deleted',
						 
						  type: 'success',
						  confirmButtonText: 'ok'
						});
						console.log('ss',ck);
					
                    }
					 window.setTimeout(function(){
							// Move to a new location or you can do something else
							window.location.href =response.redirect;

						}, 2000);

                if(!response.status){
					swal({
						  title: 'Error!',
						  text: 'Masternode is not running',
						  type: 'error',
						  confirmButtonText: 'ok'
						})
                    }                    
            }
        });
}

	
});
$(document).ready(function() {
   $('#dataTableuser').dataTable({
	order: [[0, 'desc']]
}); $('#dataTableTransactions').dataTable({
	order: [[0, 'desc']]
}); $('#dataTable').dataTable();
} );