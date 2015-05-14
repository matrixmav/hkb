<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/registration.js?ver=<?php echo strtotime("now");?>"></script>

    <div class="main">
  <div class="container">
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">        
        <!-- BEGIN CONTENT -->
            <div class="col-md-6 col-sm-6">
                <h1>Create an account</h1>
                <div class="content-form-page">
                    <div class="row">
                       <div class="col-md-12 col-sm-12">
                            <form class="form-horizontal" role="form" method="post" action="/user/registration"  onsubmit="return validateFrm()">
                                <fieldset> 
                                    <legend>Your personal details</legend>
                                    <div class="form-group">
                                        <label for="firstname" class="col-lg-4 control-label">Sponser Id <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" value="<?php echo (isset($spnId))?$spnId:""; ?>" name="sponsor_id" id="sponser_id" readonly="true">
                                            <a href="javascript:void(0)" class="btn btn-default" onclick="getSponId();">Get Sponser Id</a>
                                            <span id="sponser_id_error" class="clrred"></span>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">User Name <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" onchange="isUserExisted()" id="name" name="name">
                                            <span id="name_error" class="clrred"></span>
                                        </div>
                             
                                        <div id="status"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Full Name <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="full_name" name="full_name">
                                        
                                        <span id="full_name_error" class="clrred"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-lg-4 control-label">Email <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="email" name="email">
                                        
                                        <span id="email_error" class="clrred"></span></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email" class="col-lg-4 control-label">Date Of Birth <span class="require">*</span></label>
                                        <div class="col-lg-2 wdt2" >
                                           
                                            <select name="d" id="d" class="form-control">
                                                 <option >Date</option>
                                                <?php for($i=1;$i<=31;$i++): ?>
                                                     <option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"><?=$i?></option>
                                                <?php endfor ?>
                                            </select>
                                        
                                        </div>
                                        <div class="col-sm-3 wdt">
                                            <select name="m" id="m" class="form-control">
                                                <option value="">Month</option>
                                                <?php for($i=1;$i<=12;$i++): ?>
                                                     <option value="<?=str_pad($i,2,'0',STR_PAD_LEFT)?>"><?=$i?></option>
                                                <?php endfor ?>
                                            </select>                         

                                        </div>
                                        
                                        <div class="col-sm-3 wdt">
                                            <select name="y" id="y" class="form-control">
                                                <option value="">Year</option>
                                                <?php
                                                for($i=1950; $i<=date("Y") - 18; $i++){ ?>                                                       
                                                    <option value='<?=$i?>'><?=$i?></option>                                      
                                                <?php } ?>
                                            </select>                         
                                        </div>                                        
                                        <div class="col-lg-8">
                                        <span id="date_error" class="clrred"></span></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="country" class="col-lg-4 control-label">Country <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <select name="country_id" id="country_id" onchange="getCountryCode(this.value)" class="form-control">
                                                <option value="">Please Select Country</option>
                                                <?php foreach ( $countryObject as  $country) { ?>
                                                    <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        
                                        <span id="country_id_error" class="clrred"></span></div>
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
                                        
                                        <span id="phone_error" class="clrred"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-lg-4 control-label">Password <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" id="password" name="password" placeholder="Password" class="form-control" > <br>
                                        
                                        <span id="password_error" class="clrred"></span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="col-lg-4 control-label">Confirm Password<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" id="confirm_password" name="password" placeholder="Confirm Password" class="form-control" > <br>
                                        
                                        <span id="confirm_password_error" class="clrred"></span></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="position" class="col-lg-4 control-label">Position <span class="require">*</span></label>
                                        <div class="col-lg-8">        
                                            <input type="radio" name="position" id="position" value="right" checked/>
                                            <label class="gender">Right</label>
                                            <input type="radio" name="position" id="position" value="left"/>
                                            <label class="gender">Left</label>
                                        
                                        <span id="position_error" class="clrred"></span></div>
                                    </div>

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                                        <button type="submit" class="btn btn-primary">Create an account</button>
                                        <a href="/" type="button" class="btn btn-default">Cancel</a>
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
    return false;
}
</script>
