 
<div class="main">
      <div class="container">
      <div class="row margin-bottom-40">
 
          <!-- BEGIN SIDEBAR -->
     <?php  
      $this->renderPartial('registration',array('countryObject'=>$countryObject,'spnId'=>$spnId));
     ?>
		
          <!-- END CONTENT -->
         
          <!-- END SIDEBAR -->

          <!-- BEGIN CONTENT -->
         <?php  $this->renderPartial('login');?>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>
 
 



