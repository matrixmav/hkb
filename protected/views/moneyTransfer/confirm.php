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
                                     <div class="form-group">
                                        <label for="lastname" class="col-lg-4 control-label">Actual Amount <span class="require">*</span></label>
                                        <div class="col-lg-8">
                                           <?php 
												echo $_GET['actualamount'];
											?>
                                        </div>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="master_code" class="col-lg-4 control-label">Master Code<span class="require">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="master_code" name="master_code">
											<input type="hidden" class="form-control" 
											value="<?php echo $_GET['transactioncode']; ?>" name="transactioncode">
											
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
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
</div>