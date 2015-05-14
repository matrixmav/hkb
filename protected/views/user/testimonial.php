<?php
$this->breadcrumbs = array(
    'Account' => array('profile/testimonial'),
    'Testimonial',
);

?>

<div class="col-md-7 col-sm-7">
    <div class="error" id="error_msg" style="display: none;"></div>
    <?php if($error){?><div class="error" id="error_msg"><?php echo $error;?></div><?php }?>
<?php if($success){?><div class="success" id="error_msg"><?php echo $success;?></div><?php }?>
    <form action="/profile/testimonial" method="post" class="form-horizontal" onsubmit="return validation();">
     
        <fieldset>
            <legend>Testimonial</legend>
            <div class="form-group">
                <label class="col-lg-4 control-label" for="firstname">Testimonial <span class="require">*</span></label>
                <div class="col-lg-8">
                    <textarea id="testimonial" name="UserProfile[testimonials]" class="form-control" ><?php echo (!empty($profileObject))?$profileObject->testimonials : "";?></textarea>
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
        if(document.getElementById("testimonial").value=='')
        {
            document.getElementById("error_msg").style.display="block";
            document.getElementById("error_msg").innerHTML = "Please enter your testimonial text.";
            document.getElementById("testimonial").focus();
            return false;
        }
    }
</script>


