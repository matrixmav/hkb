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
                <label class="col-lg-4 control-label" for="firstname">Upload / Update ID Proof <span class="require">*</span><br>(Upload jpg ,png files only)</label>
                <div class="col-lg-8">
                    <input type="file" id="id_proof" class="form-control" name="id_proof">
                    <?php 
                    if(!empty($userObject) && $userObject->id_proof!=''){?>
                    <span class="example"><a href="/uploads/verification-document/<?php echo $userObject->id_proof;?>"><img src="/uploads/verification-document/<?php echo $userObject->id_proof;?>" width="50" height="50"></a></span>
                    <?php }?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="lastname">Upload / Update Address Proof <span class="require">*</span><br>(Upload jpg ,png files only)</label>
                <div class="col-lg-8">
                    <input type="file" id="address_proof" class="form-control" name="address_proof">
                    <?php if(!empty($userObject) && $userObject->address_proff!=''){?>
                    <span class="example"><a href="/uploads/verification-document/<?php echo $userObject->address_proff;?>"><img src="/uploads/verification-document/<?php echo $userObject->address_proff;?>" width="50" height="50"></a></span>
                    <?php }?>
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
    }
</script>
