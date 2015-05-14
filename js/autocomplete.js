var MIN_LENGTH = 3;

	jQuery(document).ready(function($){
	$("#username").keyup(function() {
		var username = $("#username").val();
		if (username.length >= MIN_LENGTH) {
			$.get( "/MoneyTransfer/autocomplete", { username: username } )
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

});