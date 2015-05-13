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
    <form action="/profile/address" method="post" class="form-horizontal" onsubmit="return validation();">
     
        <fieldset>
            <legend>Address</legend>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="firstname">Address <span class="require">*</span></label>
                <div class="col-lg-8">
                    <textarea id="address" name="UserProfile[address]" class="form-control" ><?php echo $profileObject->address;?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Street<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="street" class="form-control" name="UserProfile[street]" value="<?php echo $profileObject->street;?>">
                </div>
            </div>
            
           <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Zip Code<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="zip_code" class="form-control" name="UserProfile[zip_code]" value="<?php echo $profileObject->zip_code;?>">
                </div>
            </div>
            
        </fieldset>

    <div class="row">
            <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                <input type="submit" name="submit" value="Update">
                 
            </div>
        </div>
    </form>
</div>





<script type="text/javascript">
    function validation()
    {
        if(document.getElementById("address").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your address.";
            document.getElementById("address").focus();
            return false;
        }
        if(document.getElementById("street").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your street.";
            document.getElementById("street").focus();
            return false;
        }
        if(document.getElementById("country_id").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please select country.";
            document.getElementById("country_id").focus();
            return false;
        }
        if(document.getElementById("stateId").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please select state.";
            document.getElementById("stateId").focus();
            return false;
        }
        if(document.getElementById("cityId").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please select city.";
            document.getElementById("cityId").focus();
            return false;
        }
        if(document.getElementById("zip_code").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter zip code.";
            document.getElementById("zip_code").focus();
            return false;
        }
        
    }
     
     