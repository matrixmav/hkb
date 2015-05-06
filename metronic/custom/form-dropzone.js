var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzone = {
				acceptedFiles: 'image/*',
				 parallelUploads: 25,
				//params : true,
				//uploadMultiple: true,
  				//parallelUploads: 1,
                init: function() {
                    this.on("addedfile", function(file) {
						//console.log('add called');
                        // Create the remove button
						var code = parseInt(new Date().getTime());
                        //$("#customImageCode").val(code);
						//console.log($("#customImageCode").val());
						var hiddenFileInput = Dropzone.createElement('<input type="hidden" name="RestaurantPhoto[name][]" value="'+code+'_'+file.name+'" />');
						file.previewElement.appendChild(hiddenFileInput);
						var hiddenFileInput = Dropzone.createElement('<input type="hidden" name="'+file.name+'" value="'+code+'" />');
						file.previewElement.appendChild(hiddenFileInput);
						
						var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block removePhotoBtn'>Remove file</button>");
						//console.log(file);
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
									
                    });
					
					
					 this.on("sending", function(file, xhr, formData) {
						//console.log('sending called');
						//console.log($("#customImageCode").val());
						//$("#customImageCode").val(parseInt(new Date().getTime())); 
						//formData.append('customImageCode2', $("."+file).val());
					});
                }            
            }
        }
    };
}();