<?php
$this->breadcrumbs = array(
    'Account' => array('profile/documentverification'),
    'Verification',
);

?>
<div class="col-md-7 col-sm-7">
    <div class="error" id="error_msg" style="display: none;"></div>
    <?php if($error){?><div class="error" id="error_msg"><?php echo $error;?></div><?php }?>
    <?php if($success){?><div class="success" id="error_msg"><?php echo $success;?></div><?php }?>
    <form action="/profile/documentverification" method="post" class="form-horizontal" onsubmit="return validation();" enctype = "multipart/form-data">
     
        <fieldset>
            <legend>Verification</legend>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="firstname">Upload / Update ID Proof <span class="require">*</span></label>
                <div class="col-lg-8 fileupload fileupload-new">
                     <div data-provides="fileupload" class="fileupload fileupload-new">
                         <span class="btn btn-primary btn-file btn-1"><span class="fileupload-new"><input type="file" id="id_proof" class="form-control11" name="id_proof"></span></div>
                    <span class="example1">(Upload jpg ,png files only)</span> 
                    <?php 
                    if(!empty($userObject) && $userObject->id_proof!=''){?>
                    <span class="example"><a href="/uploads/verification-document/<?php echo $userObject->id_proof;?>"><img src="/uploads/verification-document/<?php echo $userObject->id_proof;?>" width="50" height="50"></a></span>
                    <?php }?>
                </div>
            </div>
         
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Upload / Update Address Proof <span class="require">*</span></label>
                <div class="col-lg-8 fileupload fileupload-new">
                     <div data-provides="fileupload" class="fileupload fileupload-new">
                         <span class="btn btn-primary btn-file btn-1"><input type="file" id="address_proof" class="form-control11" name="address_proof"></span></div>
                         <span class="example1">(Upload jpg ,png files only)</span> 
                             <?php if(!empty($userObject) && $userObject->address_proff!=''){?>
                    <span class="example"><a href="/uploads/verification-document/<?php echo $userObject->address_proff;?>"><img src="/uploads/verification-document/<?php echo $userObject->address_proff;?>" width="50" height="50"></a></span>
                    <?php }?>
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
<script>
     function validation()
    {
        if(document.getElementById("id_proof").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please choose ID proof from your computer.";
            document.getElementById("id_proof").focus();
            return false;
        }
        if(document.getElementById("address_proof").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please choose address proof from your computer.";
            document.getElementById("address_proof").focus();
            return false;
        }
        if(document.getElementById("master_pin").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter master pin.";
            document.getElementById("master_pin").focus();
            return false;
        }
    }
</script>
