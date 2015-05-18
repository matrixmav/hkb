<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/autocomplete.js');
$this->breadcrumbs=array(
	'Add Fund',
);
?>                        <div class="col-md-7 col-sm-7">
						<div class="error" id="error_msg" style="display: none;"></div>
                            <form class="form-horizontal" role="form" method="post" action="">
                                <fieldset> 
                                    <legend>Add Fund</legend>
                                    
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
                                       <label for="lastname" class="col-lg-4 control-label">Select User <span class="require">*</span></label>
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
											
                                        </div>
                                        <span id="email_error"></span>
                                    </div>
                                                                      

                                </fieldset>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">  
									<input type="submit"  name="addfund" id="addfund" class="btn btn-primary" value="Transfer Funds" />                     
                                       
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </div>
								
                            </form>
                        </div>
                 