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
										echo 'Your Transaction is '.$_GET['status'];
									?>
                                        </div>
                                       
                                    </div>
                                   
                                                                      

                                </fieldset>
								<br>
                                <div class="row">
                                    <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">     
									<a href="/moneytransfer/transfer"><button name="success" class="btn btn-primary">Try New Transaction</button></a>                   
                                      
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