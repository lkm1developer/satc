jQuery( document ).ready(function() {
        $("select#selmonth").change(function(){

            var selectedCountry = $(this).children("option:selected").attr('lkm');

            window.location.href= selectedCountry;

        });
         $("select#exporttype").change(function(){

            var val = $(this).children("option:selected").val();
            if(val){
                var selectedCountry = $("select#selmonth").children("option:selected").attr('export');
                selectedCountry = selectedCountry+'/'+val;
                var win = window.open(selectedCountry, '_blank');
                win.focus();
			}
			else{
				swal('Select Export Format')
			}


        });

	//jQuery('.refresh_bal').on('click', function() {
    jQuery(document).on("click", ".refresh_bal" , function(){
		var url=jQuery('meta[name="base_url"]').attr('content')+'/admin';
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
		var coin = jQuery(this).attr('lkm');
		swal({title:'processing...'});
		swal.showLoading();
		jQuery('.loader').show();
		//jQuery('.modal-footer').hide();
		jQuery.ajax({   
			url: url+'/wallet/refresh',
			type: 'get',
			data: {
				_token:csrf_token,
				coin:coin,
				debug:true,
				
			},
			error: function (xhr, status, error) {
				swal.close()
				jQuery('.loader').hide();
				jQuery('#errordata_div').show();
				jQuery('#errordata').html('Oops!! Something went wrong');
			},
			success: function (response) {
				swal.close();
				console.log('response',response);
				if(!response.status){
				}
				if(response.status){
					jQuery('#bal'+coin).text(response.data)
				}
			}
		});
	});

    jQuery(document).on("click", ".send_bal" , function(){
    // jQuery('.send_bal').on('click', function() {
		var url=jQuery('meta[name="base_url"]').attr('content')+'/admin';
		var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
		var coin = jQuery(this).attr('id');
		var address = jQuery('#address'+coin).val();
		var amount = jQuery('#amount'+coin).val();
		var pass = jQuery('#pass'+coin).val();
		var time = jQuery('#time'+coin).val();
		if(coin.length==0 ||address.length==0||amount.length==0||time.length==0){
			swal('All fields are required');
			return false;
		}
		swal({title:'processing...'});
		swal.showLoading();
		jQuery('.loader').show();
		//jQuery('.modal-footer').hide();
		jQuery.ajax({   
			url: url+'/wallet/send',
			type: 'post',
			data: {
				_token: csrf_token,
				coin: coin,
				amount: amount,
				address: address,
				pass:pass,
				time:time,
				debug: true,
				
			},
			error: function (xhr, status, error) {
				swal.close()
				jQuery('.loader').hide();
				jQuery('#errordata_div').show();
				jQuery('#errordata').html('Oops!! Something went wrong');
			},
			success: function (response) {
				swal.close();
				console.log('response',response);
				if(!response.status){
					jQuery('#errordata_div').show();
					jQuery('#errordata').html(response.data);
				}
				if(response.status){
					swal('Success','Transfer completed hash '+response.data,'success');
				}
			}
		});
	});

	});