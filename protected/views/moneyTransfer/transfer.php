<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/autocomplete.js');
$this->breadcrumbs=array(
	'Funds Transfer',
);
?>

                        <div class="col-md-7 col-sm-7">
						<div class="error" id="error_msg" style="display: none;"></div>
                            <form class="form-horizontal" role="form" method="post" action="">
                                <fieldset> 
                                    <legend>Select User</legend>
                                    <?php 
									if(!empty($walletObject))
									{	
									$walletPoints=0;
									$rpPoints=0;
									$commissionPoints=0;
									 foreach ( $walletObject as  $wallet) {
										 
									  if($wallet['type']== 1)
									  {										  
										  $walletPoints = $wallet['fund'];
										  }
									   if($wallet['type']== 2)
									  {
										  $rpPoints = $wallet['fund'];
										  }
									   if($wallet['type']== 3)
									  {
										$commissionPoints = $wallet['fund'];
									  }
								                                                    
                                     }
									 ?>
                                    <div class="form-group">
                                        <label for="transactiontype" class="col-lg-4 control-label">Choose Type of Transaction<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <select id="transactiontype" name="transactiontype">
										    <option value="">Select Option</option>
										   <option value="1">Cash</option>
										   <option value="2">RP Wallet</option>										   
										   </select>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="totalcash" class="col-lg-4 control-label">Total Cash <span class="require">*</span></label>
										<input type="hidden" value="<?php echo $walletPoints; ?>" name="wallet_points" id="wallet_points">
                                        <div class="col-lg-8">
                                           <?php 
										echo $walletPoints;
									?>
                                        </div>
                                       
                                    </div>
													
                                             
                                    
                                    <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">RP Wallet <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php echo $rpPoints; ?>
                                        </div>
                                       
                                    </div>
									<div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Commission Points <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php 
										echo $commissionPoints;
									?>
                                        </div>
                                       
                                    </div>
									
									 
									 <div class="form-group">
                                       <label for="lastname" class="col-lg-4 control-label">Select To User <span class="require">*</span></label>
                                        <div class="col-lg-8">
										 <input type="text" value="" placeholder="Search" id="username" name="username" required >
										 <div id="results" >
										
										 </div>
									         </div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_amount" class="col-lg-4 control-label">Amount Value <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="paid_amount" name="paid_amount"  required >
											<input type="hidden" value="<?php echo $rpPoints; ?>" name="total_rp" id="total_rp">
											<input type="hidden" value="<?php echo $commissionPoints; ?>" name="commission_points" id="commission_points">
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