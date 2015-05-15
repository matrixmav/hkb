<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/autocomplete.js');
$this->breadcrumbs=array(
	'Funds Transfer',
);
?>
<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-9">
                      <div class="content-form-page">
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            <form class="form-horizontal" role="form" method="post" action="">
                                <fieldset> 
                                    <legend>Select User</legend>
                                    <?php 
									if(!empty($walletObject))
									{	
									$wallet_points=0;
									$rp_points=0;
									$commission_points=0;
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
                                        <label for="transactiontype" class="col-lg-4 control-label">Choose Type of Transaction<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <select id="transactiontype" name="transactiontype">
										   <option value="1">Cash</option>
										   <option value="2">RP Wallet</option>										   
										   </select>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="totalcash" class="col-lg-4 control-label">Total Cash <span class="require">*</span></label>
										<input type="hidden" value="<?php echo $wallet_points; ?>" name="wallet_points" id="wallet_points">
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
										 <input type="text" value="" placeholder="Search" id="username" name="username"><div id="results" required></div>
									         </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_amount" class="col-lg-4 control-label">Amount Value <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="paid_amount" name="paid_amount"  required >
											<input type="hidden" value="<?php echo $rp_points; ?>" name="total_rp" id="total_rp">
											<input type="hidden" value="<?php echo $commission_points; ?>" name="commission_points" id="commission_points">
                                        </div>
                                        <span id="email_error"></span>
                                    </div>
                                                                      

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">  
									<input type="submit"  name="transfer" id="transfer" class="btn btn-primary" value="Transfer Funds" />                     
                                       
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
								<?php 
								
									} else
									{
								?>
								 <div class="form-group">
                                      
                                        <div class="col-lg-8">                                          
										 Funds are empty, Kindly Add. 
                                        </div>
                                       
                                    </div>
									<?php 
								
									}
								?>
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