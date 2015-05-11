<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/registration.js?ver=<?php echo strtotime("now");?>"></script>
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-9">
                <h1>Create an account</h1>
                <div class="content-form-page">
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <form class="form-horizontal" role="form" method="post" action=""  onsubmit="return validateFrm()">
                                <fieldset> 
                                    <legend>Your personal details</legend>
                                    <div class="form-group">
                                        <label for="firstname" class="col-lg-4 control-label">Sponser Id <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="<?php echo (isset($spnId))?$spnId:""; ?>" name="sponsor_id" id="sponser_id" readonly="true">
                                            <button class="btn btn-default" onclick="getSponId();">Get Sponser Id</button>
                                        </div>
                                        <span id="sponser_id_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">User Name <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" onchange="isUserExisted()" id="name" name="name">
                                        </div>
                                        <div class="col-lg-8">
                                            <span id="name_error" style="color: red;"></span>
                                        </div>
                                        <div id="status"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Full Name <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="full_name" name="full_name">
                                        </div>
                                        <span id="full_name_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="email" name="email">
                                        </div>
                                        <span id="email_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="country" class="col-lg-4 control-label">Country <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <select name="country_id" id="country_id" onchange="getCountryCode(this.value)">
                                                <option value=""></option>
                                                <?php foreach ( $countryObject as  $country) { ?>
                                                    <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span id="country_id_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-lg-4 control-label">Country Code<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input  name="country_code" id="country_code" placeholder="Country Code" class="form-control" readonly="true"> <br>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-lg-4 control-label">Mobile phone <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input  name="phone" id="phone" placeholder="phone number" class="form-control" > <br>
                                        </div>
                                        <span id="phone_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control" > <br>
                                        </div>
                                        <span id="password_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="col-lg-4 control-label">Confirm Password<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" id="confirm_password" name="password" placeholder="Confirm Password" class="form-control" > <br>
                                        </div>
                                        <span id="confirm_password_error"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="position" class="col-lg-4 control-label">Position <span class="require">*</span></label>
                                        <div class="col-lg-8">        
                                            <input type="radio" name="position" id="position" value="right" checked/>
                                            <label class="gender">Right</label>
                                            <input type="radio" name="position" id="position" value="left"/>
                                            <label class="gender">Left</label>
                                        </div>
                                        <span id="position_error"></span>
                                    </div>

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                                        <button type="submit" class="btn btn-primary">Create an account</button>
                                        <button type="button" class="btn btn-default">Cancel</button>
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
<script type="text/javascript">
 function getSponId(){ 
    $("#sponser_id").val("<?php echo Yii::app()->params['adminSpnId']; ?>");
}
</script>
