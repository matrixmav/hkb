<div class="main">
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-9">
                <h1>Money Transfer Status</h1>
                <div class="content-form-page">
                    <div class="row">
                        <div class="col-md-7 col-sm-7">
                            
                                <fieldset> 
                                    <legend>Money Transfer Status</legend>
                                     <div class="form-group">
                                      
                                        <div class="col-lg-8">
                                           <?php 
										   if($_GET['status'] == 'S')
										   {
												echo 'Your Transaction is Success';
										   }
										   if($_GET['status'] == 'F')
										   {
												echo 'Your Transaction is Failure, As you entered wrong Master Code';
										   }
										    if($_GET['status'] == 'U')
										   {
												echo 'Your Transaction is Failure, As the User Name you chose is not Existing.';
										   }
									?>
                                        </div>
                                       
                                    </div>
                                   
                                                                      

                                </fieldset>
								<br>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">     
									<a href="/MoneyTransfer/transfer"><button name="success" class="btn btn-primary">Try New Transaction</button></a>                   
                                      
                                    </div>
                                </div>
                          
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
</div>