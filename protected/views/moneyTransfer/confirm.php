<?php
$this->breadcrumbs=array(
	'Confirm',
);
?>
                        <div class="col-md-7 col-sm-7">
                            <form class="form-horizontal" role="form" method="post" action="" >
                                <fieldset> 
                                    <legend>Select User</legend>
                                     <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Actual Amount <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php 
												echo base64_decode($_GET['a']);
											?>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="master_code" class="col-lg-4 control-label">Master Code<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="password" class="form-control" id="master_code" name="master_code" required >
											<input type="hidden" class="form-control" 
											value="<?php echo base64_decode($_GET['tu']); ?>" name="tu">
											<input type="hidden" class="form-control" 
											value="<?php echo base64_decode($_GET['ta']); ?>" name="ta">
											
                                        </div>
                                        <span id="email_error"></span>
                                    </div>
                                                                      

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                                        <button type="submit"  name="confirm" class="btn btn-primary">Confirm</button>
                                        <button type="button" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
 