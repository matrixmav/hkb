<?php
$this->breadcrumbs = array(
    'Account' => array('profile/address'),
    'Address',
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
                    <textarea id="address" name="UserProfile[address]" class="form-control" ><?php echo (!empty($profileObject)) ? $profileObject->address : "";?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Street<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="street" class="form-control" name="UserProfile[street]" value="<?php echo (!empty($profileObject)) ? $profileObject->street: "";?>">
                </div>
            </div>
            
             
            <div class="form-group">
                    <label for="country" class="col-lg-4 control-label">Country <span class="require">*</span></label>
                    <div class="col-lg-8">
                        <select name="UserProfile[country_id]" id="country_id" onchange="getStateList(this.value)" class="form-control">
                            <option value="">Select Country</option>
                            <?php foreach ( $countryObject as  $country) { ?>
                            <option value="<?php echo $country->id; ?>" <?php if( $country->id== (!empty($profileObject)) ? $profileObject->country_id :  ""){?>selected="selected<?php }?>"><?php echo $country->name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <span id="country_id_error"></span>
                </div>

            <div class="form-group" id="stateList"  style="display: <?php if(!empty($profileObject) && count($stateObject) > 0){ echo "block";}else{ echo "none";}?>">
                <label class="col-lg-4 control-label" for="email">State <span class="require">*</span></label>
                <div class="col-lg-8">

                    <select id="stateId" name="UserProfile[state_id]" onchange="showCity(this.value);" class="form-control">
                       <option value="">Select State</option>
                       <?php if(count($stateObject)>0){?>
                       <?php foreach ( $stateObject as  $state) { ?>
                            <option value="<?php echo $state->id; ?>" <?php if( $state->id== (!empty($profileObject)) ? $profileObject->state_id :  ""){?>selected="selected"<?php }?>><?php echo $state->name; ?></option>
                            <?php } ?>
                       <?php }?>
                    </select>
                </div></div>
            
            <div class="form-group" id="cityList" style="display: <?php if(!empty($profileObject) && count($cityObject) > 0){ echo "block";}else{ echo "none";}?>"">
                <label class="col-lg-4 control-label" for="email">City <span class="require">*</span></label>
                <div class="col-lg-8">

                    <select id="cityId" name="UserProfile[city_id] " class="form-control">
                       <option value="">Select State</option>
                       <?php if(count($cityObject)>0){?>
                       <?php foreach ( $cityObject as  $city) { ?>
                            <option value="<?php echo $city->id; ?>" <?php if( $city->id == (!empty($profileObject)) ? $profileObject->city_id :  ""){?>selected="selected"<?php }?>><?php echo $city->name; ?></option>
                            <?php } ?>
                       <?php }?>
                    </select>
                </div></div>
            
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Zip Code<span class="require">*</span></label>
                <div class="col-lg-8">
                    <input type="text" id="zip_code" class="form-control" name="UserProfile[zip_code]" value="<?php echo (!empty($profileObject)) ?  $profileObject->zip_code : ""; ?>">
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
    function getStateList(country_id)
    {
        var country_id = country_id;
        
        var dataString = 'country_id='+country_id;
        $.ajax({
            type: "GET",
            url: "/profile/fetchstate",
            data: dataString,
            cache: false,
            success: function (html) {  
                if (html != '') {
                    document.getElementById("stateList").style.display = "block";
                    $('#stateId').html(html);
                }
            }
        });
    }
    function showCity(state_id)
    {
        var state_id = state_id;
        var dataString = 'state_id='+state_id;
        $.ajax({
            type: "GET",
            url: "/profile/fetchcity",
            data: dataString,
            cache: false,
            success: function (html) {
                if (html != '')
                {
                    document.getElementById("cityList").style.display = "block";
                    document.getElementById("cityId").innerHTML = html;

                }
            }
        });
    }
</script>    