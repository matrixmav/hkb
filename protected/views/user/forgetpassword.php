<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/registration.js?ver=<?php echo strtotime("now");?>"></script>
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-9">
                <?php if(!empty($msg)){ echo $msg;} ?>
                <h1>Forget Password</h1>
                <div class="content-form-page">
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <form class="form-horizontal" role="form" method="post" action="" onsubmit="return validateFrm()">
                                <fieldset> 
                                    <div class="form-group">
                                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="email" name="email">
                                        <span id="email_error" class="clrred"></span> </div>
                                    </div>

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">     
                                        
                                        <button type="submit" class="btn btn-primary">Forget Password</button>
                                       <a href="/user/login" class="btn btn-default">Cancel</a>  
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
    $("#email_error").html("");
    if ($("#email").val() == "") {
      $("#email_error").html("Enter Email");
      $("#email").focus();            
      return false;
    }
       
    var email = document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
        $("#email_error").html("Enter valid email address ");
        $("#email").focus();
        return false;
    } 
    
   
    
 }        
</script>    
