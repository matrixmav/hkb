<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/autocomplete.js');
?>
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-9">
                <h1>Money Transfer</h1>
                <div class="content-form-page">
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <form class="form-horizontal" role="form" method="post" action="" >
                                <fieldset> 
                                    <legend>Select User</legend>
                                    <?php 
																	
									 foreach ( $walletObject as  $wallet) {
										 
									  if($wallet['type']== 1)
									  {										  
										  $wallet_points = $wallet['fund'];
										  }
									   if($wallet['type']== 2)
									  {
										  $rp_points = $wallet['fund'];
										  }
									   if($wallet['type']== 3)
									  {
										$commission_points = $wallet['fund'];
									  }
								                                                    
                                     }
									 ?>
                                    
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Cash Amount <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php 
										echo $wallet_points;
									?>
                                        </div>
                                       
                                    </div>
													
                                             
                                    
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">RP Wallet <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php echo $rp_points; ?>
                                        </div>
                                       
                                    </div>
									<div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Commission Points <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php 
										echo $commission_points;
									?>
                                        </div>
                                       
                                    </div>
									
									 
									 <div class="form-group">
                                       <label for="lastname" class="col-lg-4 control-label">Select To User <span class="require">*</span></label>
                                        <div class="col-lg-8">
										 <input type="text" value="" placeholder="Search" id="username" name="username"><div id="results"></div>
									         </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_amount" class="col-lg-4 control-label">Amount Value <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="paid_amount" name="paid_amount">
											<input type="hidden" class="form-control" value="<?php echo $wallet_points; ?>" name="actual_amount">
											<input type="hidden" class="form-control" value="<?php echo $rp_points; ?>" name="total_rp">
                                        </div>
                                        <span id="email_error"></span>
                                    </div>
                                                                      

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">                        
                                        <button type="submit"  name="transfer" class="btn btn-primary">Transfer Funds</button>
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