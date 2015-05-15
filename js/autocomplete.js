var MIN_LENGTH = 3;

	jQuery(document).ready(function($){
	$("#username").keyup(function() {
		var username = $("#username").val();
		if (username.length >= MIN_LENGTH) {
			$.get( "/moneytransfer/autocomplete", { username: username } )
			.done(function( data ) {
				$('#results').html('');
				var results = jQuery.parseJSON(data);
				$(results).each(function(key, value) {
					$('#results').append('<div class="item">' + value + '</div>');
				})

			    $('.item').click(function() {
			    	var text = $(this).html();
			    	$('#username').val(text);
			    })

			});
		} else {
			$('#results').html('');
		}
	});

    $("#username").blur(function(){
    		$("#results").fadeOut(500);
    	})
        .focus(function() {		
    	    $("#results").show();
    	});

	
	$("#transfer").click(function() {
			var transactiontype = $("#transactiontype").val();
			var paid_amount = $("#paid_amount").val();
			var wallet_points = $("#wallet_points").val();
			var commission_points = $("#commission_points").val();	
			var total_rp = $("#total_rp").val();
			var paid_amount_percentage = (parseFloat(paid_amount)/100)+parseFloat(paid_amount);
			total_rp = parseFloat(total_rp) + parseFloat(commission_points);
			if(transactiontype == 2)
			{
				if(parseFloat(paid_amount_percentage) >= parseFloat(total_rp))
				{				
						alert("Insufficient Funds");
						return false; 
				}
			}else
			{			
				if(parseFloat(paid_amount_percentage) >= parseFloat(wallet_points))
				{				
						alert("Insufficient Funds");
						return false; 
				}	
			}
	}); 


});