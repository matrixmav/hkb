//required field
function requiredField(id, errorId, message) {
    var fieldValue = document.getElementById(id).value;
    if (fieldValue == null || fieldValue == "") {
        if (message == null || message == "") {
            document.getElementById(errorId).textContent = "required";
        } else {
            document.getElementById(errorId).textContent = message;
        }
        return false;
    } else {
        document.getElementById(errorId).textContent = "";
        return true;
    }
}
//email validator
function validateEmail(id ,id_1, errorId, message) {
			var fieldValue = document.getElementById(id).value;
			var fieldValue_1 = document.getElementById(id_1).value;
			var atpos = fieldValue.indexOf("@");
			var dotpos = fieldValue.lastIndexOf(".");
			
			if(fieldValue == "" || fieldValue == null){
				document.getElementById(errorId).textContent = "required";
				return false;
				}
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=fieldValue.length) {
				if(message =="" || message == null){
					document.getElementById(errorId).textContent = "not valid";
					}else{
					document.getElementById(errorId).textContent = message;
					}
				return false;
			}
			if(fieldValue != fieldValue_1){
					document.getElementById(errorId).textContent = "Email Mismatch";
					return false;
					}else{
				document.getElementById(errorId).textContent = "";
				return true;
				}
			}
//password validator
function validatePasswsord(id_1, id_2, errorId, message) {
			var fieldValue = document.getElementById(id_1).value;
			var str = fieldValue.length;
			var upperCaseTest = (/[A-Z]/.test(fieldValue));
			if(fieldValue == null || fieldValue == ""){
				return true;
				}
			if(!upperCaseTest){
				document.getElementById(errorId).textContent = "Password should contain atleast one upper case";
				return false;
				}
			if(fieldValue.indexOf(' ') >= 0){
				document.getElementById(errorId).textContent = "Password cant have white spaces";
				return false;
				}
			if(str < 3 || str > 10 ){
				document.getElementById(errorId).textContent = "Password should be minimum 3 and maximum 10 characters";
				return false;
				}
			var fieldValueTwo = document.getElementById(id_2).value;
			if(fieldValue == fieldValueTwo){
				document.getElementById(errorId).textContent = "";
				return true;
				}else{
					if(message == null || message == ""){
						document.getElementById(errorId).textContent = "Password Mismatch";
						}else{
					document.getElementById(errorId).textContent = message;
						}
					return false;
					}
		}
                
//required field
function numaricField(id, errorId, message) {
    var fieldValue = document.getElementById(id).value;
    if (isNaN(fieldValue)) {
        if (message == null || message == "") {
            document.getElementById(errorId).textContent = "required";
        } else {
            document.getElementById(errorId).textContent = message;
        }
        return false;
    } else {
        document.getElementById(errorId).textContent = "";
        return true;
    }
}
//required field
function isValidEmail(id, errorId, message) {
    
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    var fieldData = $("#"+id).val();
    if (filter.test(fieldData)) { 
        document.getElementById(errorId).textContent = "";
        return true;
    } else {
        if (message == null || message == "") {
            document.getElementById(errorId).textContent = "required";
            return false;
        } else {
            document.getElementById(errorId).textContent = message;
            return false;
        }
        
    }
}
function validateEmail1(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) {
        return true;
    }
}
