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
		var username = $("#username").val();
			$.ajax( {
                  url:'/moneytransfer/userexists?u='+username,
                  success:function(data) {
					  if(data=='notexists'){
			document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Username does not Exist.";
            document.getElementById("username").focus();
            return false;
					  }
                  }
               });
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
			document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Insufficient Funds.";
            document.getElementById("paid_amount").focus();
            return false;
					
				}
			}else
			{			
				if(parseFloat(paid_amount_percentage) >= parseFloat(wallet_points))
				{				
			document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Insufficient Funds.";
            document.getElementById("paid_amount").focus();
            return false;
						
				}	
			}
			
		if(document.getElementById("transactiontype").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter Transaction Type.";
            document.getElementById("transactiontype").focus();
            return false;
        }
	if(document.getElementById("username").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter Username.";
            document.getElementById("username").focus();
            return false;
        }
	var paid_amount = document.getElementById('paid_amount');
        var filter = /^(?!0\d)\d*(\.\d+)?$/mg;

        if (!filter.test(paid_amount.value)) {
            $("#error_msg").html("Please enter valid Amount");
            $("#paid_amount").focus();  
            return false;
        }
		if(document.getElementById("paid_amount").value==0)
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter valid Amount.";
            document.getElementById("username").focus();
            return false;
        }
	}); 
	$("#addfund").click(function() {
		var username = $("#username").val();
			$.ajax( {
                  url:'/moneytransfer/userexists?u='+username,
                  success:function(data) {
					  if(data=='notexists'){
			document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Username does not Exist.";
            document.getElementById("username").focus();
            return false;
					  }
                  }
               });
						
		if(document.getElementById("transactiontype").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter Transaction Type.";
            document.getElementById("transactiontype").focus();
            return false;
        }
	if(document.getElementById("username").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter Username.";
            document.getElementById("username").focus();
            return false;
        }
	var paid_amount = document.getElementById('paid_amount');
        var filter = /^(?!0\d)\d*(\.\d+)?$/mg;

        if (!filter.test(paid_amount.value)) {
            $("#error_msg").html("Please enter valid Amount");
            $("#paid_amount").focus();  
            return false;
        }
		if(document.getElementById("paid_amount").value==0)
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter valid Amount.";
            document.getElementById("username").focus();
            return false;
        }
	}); 
});