<section class="wrapper contentPart contract">
    <div class="container3">
      <div class="contentCont">
        <span class="smalllogo"><img src="/images/logo_contract.png"/></span>
        <div>
          <span class="mainheading">HOTEL CONTRACT</span>
        </div>
        <section class="contractSteps">
          <div class="status">
            <ul>
              <a href="<?php echo Yii::app()->createUrl('hotel/contract');?>"><li class="dark">Step1</li></a>
              <a href="<?php echo Yii::app()->createUrl('hotel/contractpagetwo');?>"><li class="dark">Step2</li></a>
              <li class="last dark">Step3</li>
            </ul>
          </div>
        </section>               
        <div class="thankPane">
          <p class="title">Thank you ! </p>
          <p class="text">The hotel extranet will be active as soon as we receive the signed contract.</p>
          <div class="clear25"></div>
         <a href="<?php echo Yii::app()->createUrl('hotel/downloadpdf');?>" target="blank">
          <input type="button" class="print" value="PRINT" ></a>
          <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contract-form-id',
        'htmlOptions'=>array(
        'enctype' => 'multipart/form-data',
         ),
         )); ?>
          <div class="clear50"></div>
          <div class="UploadFile">
            <!--<input id="txt" class="inputField" type = "text" name="contract" value = "" onclick ="javascript:document.getElementById('file').click();">
            <input id = "file" type="file" style='visibility: hidden;' name="img" onchange="ChangeText(this, 'txt');"/>-->
            <input id="text" type="file" name="contract"/>
            <input id="button" class="fileInputButton" type="submit" value="SEND FILE"/> </div>        
          <div class="clear15"></div>
          <?php $this->endWidget(); ?>
          <p class="bottomtext">You can also send us the signed contract by fax (+33972319988) or by Email (contract@dayuse.com)</p>
        </div>        
      </div>
    </div>
  </section>