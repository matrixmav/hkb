            <?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Orders List',
);

$this->menu=array(
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>
    <?php //echo "<pre>"; print_r($orderObject);?>
       <div class="main">
      <div class="container">

        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
         <!-- BEGIN SIDEBAR -->
<!--          <div class="sidebar col-md-3 col-sm-3">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix"><a href="page-reg-page.html"><i class="fa fa-angle-right"></i> Login/Register</a></li>
              <li class="list-group-item clearfix"><a href="profile.html"><i class="fa fa-angle-right"></i> Profile</a></li>
              <li class="list-group-item clearfix"><a href="orderdetail.html"><i class="fa fa-angle-right"></i> Order List</a></li>
              <li class="list-group-item clearfix"><a href="address.html"><i class="fa fa-angle-right"></i> Address</a></li>
              <li class="list-group-item clearfix"><a href="varification.html"><i class="fa fa-angle-right"></i> Verification</a></li>
              <li class="list-group-item clearfix"><a href="testimonials.html"><i class="fa fa-angle-right"></i> Testimonials</a></li>
              <li class="list-group-item clearfix"><a href="invoice.html"><i class="fa fa-angle-right"></i> Invoice</a></li>
              
            </ul>
          </div>-->
          <!-- END SIDEBAR -->
          <!-- BEGIN CONTENT -->
          <div class="col-md-9 col-sm-9">
            <!--<h1> Update Order list</h1>-->
            <div class="content-form-page">
              <div class="row">
                <div class="col-md-7 col-sm-7">
                  
                          <div class="form-group">
                       
                                <div class="col-lg-12">        
                      
                    
                    <div class="Table">
                        
                        <div class="Heading">
                            <div class="Cell">
                                <p>Package Taken</p>
                            </div>
                            <div class="Cell">
                                <p>Order Id</p>
                            </div>
                            <div class="Cell">
                                <p>Heading 3</p>
                            </div>
                        </div>
                        <?php foreach($orderObject as $orderObj){
                            $packageArr = $orderObj->package();
                            var_dump($packageArr);
                            ?>
                        <div class="Row">
                            <div class="Cell">
                                <p><?php echo $packageArr->name;?></p>
                            </div>
                            <div class="Cell">
                                <p><?php //echo $orderObj->;?></p>
                            </div>
                            <div class="Cell">
                                <p><?php //echo $orderObj->;?></p>
                            </div>
                        </div>
                        <?php }?>
                      </div>
                   
                    </div></div>
                    
                      
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="row">
                      
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
