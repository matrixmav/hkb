
<div class="main">
  <div class="container">
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
      <!-- BEGIN CONTENT -->
      <div class="col-md-9 col-sm-9">
        <?php //print_r($msg);  ?>
        <h1>Change Password</h1>
        <div class="content-form-page">
          <div class="row">
            <div class="col-md-7 col-sm-7">
                <form class="form-horizontal form-without-legend" method="post" name="LoginForm" id=LoginForm" role="form" onsubmit="return validateFrm()">
                
                <div class="form-group">
                    <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                    <div class="col-lg-8">
                        <input type="password" id="password" name="password" placeholder="Password" class="form-control"> <br>
                    
                    <span id="password_error" class="clrred"></span></div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="col-lg-4 control-label">Confirm Password<span class="require">*</span></label>
                    <div class="col-lg-8">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control"> <br>
                    <span id="confirm_password_error" class="clrred"></span></div>
                </div> 

               
                <div class="row">
                  <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                    <input type="hidden" name="userId" value="<?php echo $userId ?>">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-10 padding-right-30">
                    <hr>
                    <div class="login-socio">
                        <!--<p class="text-muted">or login using:</p>-->
                        <ul class="social-icons">
                            <li><a href="javascript:;" data-original-title="facebook" class="facebook" title="facebook"></a></li>
                            <li><a href="javascript:;" data-original-title="Twitter" class="twitter" title="Twitter"></a></li>
                            <li><a href="javascript:;" data-original-title="Google Plus" class="googleplus" title="Google Plus"></a></li>
                            <li><a href="javascript:;" data-original-title="Linkedin" class="linkedin" title="LinkedIn"></a></li>
                        </ul>
                    </div>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
      <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->
  </div>
</div>
<script>
 function validateFrm() {
    $("#password_error").html("");
    if ($("#password").val() == "") {
        $("#password_error").html("Enter Password");
        $("#password").focus();
        return false;
    }

     if ($("#password").val().length < 5) {
        $("#password_error").html("Enter atleast 5 chars in the input box");
        $("#password_name").focus();   
        return false;
    }


    if ($("#confirm_password").val() == "") {
        $("#confirm_password_error").html("Enter Confirm Password");
        $("#confirm_password").focus();
        return false;
    }

    if ($("#confirm_password").val().length < 5) {
        $("#confirm_password_error").html("Enter atleast 5 chars in the input box");
        $("#confirm_password").focus();
        return false;
    }

    if ($("#password").val() != $("#confirm_password").val()) {
        $("#confirm_password_error").html("Please check that you've entered and confirmed your password");
        $("#confirm_password").focus();
        return false;
    }
 
    
 }        
</script>