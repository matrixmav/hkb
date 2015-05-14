<?php
$this->breadcrumbs = array(
    'Account' => array('profile/updateprofile'),
    'Update Profile',
);
?>
<div class="col-md-7 col-sm-7">
    <div class="error" id="error_msg" style="display: none;"></div>
    <?php if($error){?><div class="error" id="error_msg"><?php echo $error;?></div><?php }?>
    <?php if($success){?><div class="success" id="error_msg"><?php echo $success;?></div><?php }?>
    <form action="/profile/updateprofile" method="post" class="form-horizontal" onsubmit="return validation();">
     
        <fieldset>
            <legend>Update Profile</legend>
             <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Sponsor ID</label>
                <div class="col-lg-8">
                    <input type="text" id="name" class="form-control" name="UserProfile[sponsor_id]" value="<?php echo $userObject->sponsor_id;?>" readonly="readonly">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Name</label>
                <div class="col-lg-8">
                    <input type="text" id="name" class="form-control" name="UserProfile[name]" value="<?php echo $userObject->name;?>" readonly="readonly">
                </div>
            </div>
            
           <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Position</label>
                <div class="col-lg-8">
                    <input type="text" id="position" class="form-control" name="UserProfile[position]" value="<?php echo (!empty($userObject))?$userObject->position:"";?>" readonly="readonly">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Full Name<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="full_name" class="form-control" name="UserProfile[full_name]" value="<?php echo (!empty($userObject))?$userObject->full_name:"";?>" <?php if($edit=='no'){ ?>readonly="readonly" <?php }?>>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Email<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="email" class="form-control" name="UserProfile[email]" value="<?php echo $userObject->email;?>" <?php if($edit=='no'){ ?>readonly="readonly" <?php }?>>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Phone<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="phone" class="form-control" name="UserProfile[phone]" value="<?php echo (!empty($userObject))?$userObject->phone:"";?>" <?php if($edit=='no'){ ?>readonly="readonly" <?php }?>>
                </div>
            </div>
             <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Date of Birth<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="date_of_birth" class="form-control" name="UserProfile[date_of_birth]" value="<?php echo (!empty($userObject))?$userObject->date_of_birth:"";?>" <?php if($edit=='no'){ ?>readonly="readonly" <?php }?>>
                </div>
            </div>
             <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Skype ID</label>
                <div class="col-lg-8">
                    <input type="text" id="skype_id" class="form-control" name="UserProfile[skype_id]" value="<?php echo (!empty($userObject))?$userObject->skype_id:"";?>">
                    <span class="example">Ex: example12</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Facebook ID</label>
                <div class="col-lg-8">
                    <input type="text" id="facebook_id" class="form-control" name="UserProfile[facebook_id]" value="<?php echo (!empty($userObject))?$userObject->facebook_id:"";?>">
                    <span class="example">Ex: http://facebook.com</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Twitter ID</label>
                <div class="col-lg-8">
                    <input type="text" id="twitter_id" class="form-control" name="UserProfile[twitter_id]" value="<?php echo (!empty($userObject))?$userObject->twitter_id:"";?>">
                    <span class="example">Ex: http://twitter.com</span>
                </div>
            </div>
             <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Master Pin<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="password" id="master_pin" class="form-control" name="UserProfile[master_pin]">
                </div>
            </div>
            
        </fieldset>

    <div class="row">
            <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                <input type="submit" name="submit" value="Update" class="btn">
                 
            </div>
        </div>
    </form>
</div>





<script type="text/javascript">
    function validation()
    {
        if(document.getElementById("full_name").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your full name.";
            document.getElementById("full_name").focus();
            return false;
        }
        if(document.getElementById("email").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your email.";
            document.getElementById("email").focus();
            return false;
        }
        var email = document.getElementById('email');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            document.getElementById("error_msg").style.display="block";
            $("#error_msg").html("Enter valid email address ");
            $("#email").focus();
            return false;
        }
        if(document.getElementById("phone").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter phone number.";
            document.getElementById("phone").focus();
            return false;
        }
        var phone = document.getElementById('phone');
        var filter = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

        if (!filter.test(phone.value)) {
            $("#error_msg").html("Enter valid phone number ");
            $("#phone").focus();  
            return false;
        }
        if(document.getElementById("master_pin").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your master pin.";
            document.getElementById("master_pin").focus();
            return false;
        }
         
        
    }
    </script>
     
     