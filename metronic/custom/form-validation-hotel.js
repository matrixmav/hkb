var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_hotel');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                	'Hotel[status]': {
                        required: true
                    },
                    'Hotel[timezone]': {
                        required: true
                    },
                    'Hotel[portal][]': {
                        required: true
                    },
                    'Hotel[name]': {
                        required: true
                    },
                    'Hotel[country]': {
                        required: true
                    },
                    'Hotel[state_id]': {
                        required: true
                    },
                    'Hotel[star_rating]': {
                        required: true
                    },
                    'Hotel[city_id]': {
                        required: true
                    },
                    'Hotel[currency][]': {
                        required: true
                    },
                    'Hotel[language]': {
                        required: true
                    },
                    'Hotel[address]': {
                        required: true
                    },
                    /*'Hotel[telephone]': {
                        required: true
                    },*/
                    'Hotel[postal_code]': {
                        required: true
                    },
                    /*'Hotel[com_con_info]': {
                        required: true
                    },*/
                    'Hotel[day_commission]': {
                        required: true,
                        max:100,
                        min:1
                    },
                    'Hotel[night_commission]': {
                        required: true,
                        max:100,
                        min:1
                    },
                    'Hotel[addon_commission]': {
                        required: true,
                        max:100,
                        min:1
                    },
                    /*'Hotel[email]': {
                        required: true,
                        email: true
                    },*/
                    'HotelDetail[email_address][0]': {
                        required: true,
                        email: true
                    },
                    'HotelContact[1][name]': {
                        required: true
                    },
                    'HotelContact[1][telephone]': {
                        required: true
                    },
                    'HotelContact[1][email_address]': {
                        required: true,
                        email: true
                    },
                    
                    'Hotel[is_new]': {
                        required: true
                    },
                    'Hotel[is_feature]': {
                        required: true
                    },
                    'Hotel[feature_till_date]': {
                    	feature_till: true
                    },
                },
                
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    //success1.show();
                    error1.hide();
					
					$form=$("#form_sample_3_hotel");
					$.ajax({
						dataType:'json',
						type: "get",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) { 
                                                    if(result.status=="SUCCESS"){
                                                        showSucessMsg("Record saved successfully", "Save Hotel");
                                                        var currentUrl  = (window.location.pathname);
                                                        if(currentUrl.indexOf("update") > -1 || currentUrl.indexOf("create") > -1){
                                                            // redirect to update Job page
                                                            showSucessMsg("Please wait while we redirecting.", "Page redirection");
                                                            if(result.user_type == 'dayuse'){
                                                                window.location.href = "/admin/hotel/update?id="+result.id+"&type=photos";
                                                                return;
                                                            } else {
                                                                window.location.href = "/admin/hotel/update/type/details/id/"+result.id;
                                                                return; 
                                                            }
                                                        }		
                                                    }else {
                                                            showError("Error in saving record");
                                                    }
                                                    App.unblockUI();
						},
						error:function(status, respone, error) {
							showError("Unable to process the request");
							App.unblockUI();
						}
					});
                }
            });

    }


    return {
        //main function to initiate the module
        init: function () {
            handleValidation1();
        }

    };

}();
jQuery(document).ready(function() {   
	   $("#map").hide();
	   if(action=="update"){
		   $("#map").show();
		//initialize($("#Hotel_address").val()+"+"+$("option:selected", this).text()+"+"+$("#state_id option:selected").text()+"+"+$("#country_id option:selected").text()+"+"+$("#Hotel_postal_code").val());
                initialize("onload");
	   }
	   $("#Hotel_address").blur(function() {
		   $("#map").show();
		   initialize($("#Hotel_address").val());
	   });
	   $("#Hotel_postal_code").blur(function() {
		   $("#map").show();
		   initialize($("#Hotel_address").val()+"+"+$("#Hotel_postal_code").val());
	   });
	   
	   $( "#country_id" ).on("change",function() {
			$.ajax({
				type: "GET",
				url: stateUrl,
				data: { country_id: $('#country_id :selected').val(),'selectName':'Hotel[state_id]'},
				success: function(result){
					$('#state_id').html(result);
					$('#state_id').select2({
		                placeholder: "Select",
		                allowClear: true
		            });
					$('#city_id').html("<option value=''>NA</option></select>");
					$('#city_id').select2({
		                placeholder: "Select",
		                allowClear: true
		            });
				}
			});
			$("#map").show();			
			initialize($("#Hotel_address").val()+"+"+$("option:selected", this).text()+"+"+$("#Hotel_postal_code").val());
		});

		$( "#state_id" ).on("change",function() { 
			$.ajax({
				type: "GET",
				url: cityUrl,
				data: { state_id: $('#state_id :selected').val(),'selectName':'Hotel[city_id]'},
				success: function(result){
							$('#city_id').html(result);
							$('#city_id').select2({
				                placeholder: "Select",
				                allowClear: true
				            });
					}
				});
			$("#map").show();			
			initialize($("#Hotel_address").val()+"+"+$("option:selected", this).text()+"+"+$("#country_id option:selected").text()+"+"+$("#Hotel_postal_code").val());
			
		});
		$( "#city_id" ).on("change",function() {
			$("#map").show();
			initialize($("#Hotel_address").val()+"+"+$("option:selected", this).text()+"+"+$("#state_id option:selected").text()+"+"+$("#country_id option:selected").text()+"+"+$("#Hotel_postal_code").val());
		});
		
		 $( "#group_id" ).on("change",function() {
				$.ajax({
					type: "GET",
					url: chainUrl,
					data: { group_id: $('#group_id :selected').val(),'selectName':'Hotel[group_id]'},
					success: function(result){
								$('#chain_id').html(result);
						}
					});
		});
		
		$("#feature_till").hide();
		if($("input:radio[name='Hotel[is_feature]']:checked").val()==1){
			$("#feature_till").show();
			$.validator.addMethod("feature_till", function(value, element) {
				if($("#Hotel_feature_till_date").val()=="")				
					return false;
				else
					return true;
			}, "Select a date!");
		}else{
			$("#feature_till").hide();
			$.validator.addMethod("feature_till", function(value, element) {
				return true;
			}, "Select a date!");
		}
		$("input:radio[name='Hotel[is_feature]']").change(function(){
			if($(this).val()==1){
				$("#feature_till").show();
				$.validator.addMethod("feature_till", function(value, element) {
					if($("#Hotel_feature_till_date").val()=="")				
						return false;
					else
						return true;
				}, "Select a date!");
			}else{
				$("#feature_till").hide();
				$.validator.addMethod("feature_till", function(value, element) {
					return true;
				}, "Select a date!");
			}
				
		});
		$('#addbutton').click(function(e){
		     if($(".addedfields").length < 10){		    
		       $(".addedfields").append(
		    		   "<li style='margin-top:5px;'><input type='text' name='HotelDetail[email_address][]' class='form-control textbox'/>"+
					   "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a></li>"
		       );
		       e.preventDefault();
		     }
		     $(".removeBtn").on("click",function(e){
				   $(this).parent().remove();
				   e.preventDefault();
			   });
		});
	   $(".removeBtn").on("click",function(e){
		   $(this).parent().remove();
		   e.preventDefault();
	   });
		
	});

	function initialize(str) {
		
		  var address = str.split(' ').join('+');
		  console.log(address);
		  geocoder = new google.maps.Geocoder();
		  geocoder.geocode( { 'address': address}, function(results, status) {
                        if(str != "onload") {  
			    if (status == google.maps.GeocoderStatus.OK) {
			       var latitude = results[0].geometry.location.k;
			  	   var longitude=results[0].geometry.location.D;  
                                   $("#Hotel_latitude").val(latitude);
                                    $("#Hotel_longitude").val(longitude);
			    } else {
			    	var latitude = "";
                                var longitude="";
			    }
                        } else { 
                            var latitude = $("#Hotel_latitude").val();
                            var longitude=$("#Hotel_longitude").val();
                        }

                            var mapOptions = {
                                zoom: 14,
                                center: new google.maps.LatLng(latitude, longitude)
                            }
                            var map = new google.maps.Map(document.getElementById('map-canvas'),
                                    mapOptions);
                            var image = 'http://dayuse.dev/upload/hotel/1/64_39/4753558.jpg';
                            var myLatLng = new google.maps.LatLng(latitude, longitude);
                            var beachMarker = new google.maps.Marker({
                                position: myLatLng,
                                map: map,
                                draggable: true
                            });

                        google.maps.event.addListener(beachMarker, 'drag', function() {
                          updateMarkerStatus('Dragging...');
                          updateMarkerPosition(beachMarker.getPosition());
                        });
                        google.maps.event.addListener(beachMarker, 'dragstart', function() {
                              updateMarkerAddress('Dragging...');
                        });
                        google.maps.event.addListener(beachMarker, 'dragend', function() {
                              updateMarkerStatus('Drag ended');
                              geocodePosition(beachMarker.getPosition());
                        });
                    });
		}

function updateMarkerStatus(str) { 
  document.getElementById('markerStatus').innerHTML = str;
}
function updateMarkerPosition(latLng) { 
    $("#Hotel_longitude").val(latLng.lng());
    $("#Hotel_latitude").val(latLng.lat());
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
} 

function geocodePosition(pos) { 
  geocoder.geocode({
    latLng: pos
  }, function(responses) { 
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}
function updateMarkerStatus(str) { 
  document.getElementById('markerStatus').innerHTML = str;
}
function updateMarkerAddress(str) { 
  document.getElementById('address').innerHTML = str;
}