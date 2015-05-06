<section class="wrapper contentPart contract">
    <div class="container3">
      <div class="contentCont no-paddingBtm">
        <span class="smalllogo"><img src="/images/logo_contract.png"/></span>
        <div>
          <span class="mainheading">HOTEL CONTRACT</span>
        </div>
        <section class="contractSteps">
          <div class="status">
            <ul>
              <a href="<?php echo Yii::app()->createUrl('hotel/contract');?>"><li class="dark">Step1</li></a>
              <li class="dark">Step2</li>
              <li class="last">Step3</li>
            </ul>
          </div>
        </section>
        <span class="Subheading">Amenities : </span>        
         <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'contract-form-id',
        'htmlOptions'=>array(
        'enctype' => 'multipart/form-data',
         ),
         )); ?>
          <ul class="featurelist">
            <?php
            foreach($equipments as $eky=>$equipment):
                $selected = (in_array($equipment->id, $hotelequip))? "checked" : "";
                ?>
                <li><div class="CustomCheckbox"><span><input type="checkbox" value="<?php echo $equipment->id; ?>" name="Hotel[equip][]" class="checkboxItemCustom" label="<?php echo $equipment->name; ?>" <?php echo $selected;?>></span></div></li>
                <?php
            endforeach;
            ?>
          </ul>
          <div class="clear50"></div>
          <span class="Subheading">Category : </span>
          <ul class="featurelist">
            <?php   
            foreach($themes as $thky=>$theme):
                $selected = (in_array($theme->id, $hotelthemes))? "checked" : "";
                ?>
                <li><div class="CustomCheckbox"><span><input type="checkbox" value="<?php echo $theme->id; ?>" name="Hotel[theme][]" class="checkboxItemCustom" label="<?php echo $theme->name; ?>" <?php echo $selected;?>></span></div></li>
            <?php
            endforeach;
            ?>
           </ul>
          <!--<div class="clear25"></div>
          <ul class="featurelist">
            <li><div class="CustomCheckbox"><span><input type="checkbox" value="Independant" name="Category[]" class="checkboxItemCustom" label="Independant"></span></div></li>
            <li class="withinput"><div class="CustomCheckbox"><span><input type="checkbox" value="Chain" name="Category[]" class="checkboxItemCustom" label="Chain"></span></div><span><input class="inputField" id="text" type="text" name="Chain[detail]" value="<?php if(isset(Yii::app()->session['chain']['detail'])){echo Yii::app()->session['chain']['detail'];} ?>" /></span>
            </li>
          </ul>-->
          <div class="clear25"></div>
          <ul class="detailForm" style="width: 100%; display: inline-block;">
            <?php
            foreach($content as $cnky=>$cont):
                $htcontent = HotelContent::model()->find('hotel_id='.$hotel_id.' and type="'.$cnky.'" and portal_id='.Yii::app()->params->default['portalId']);
                $added_content = ($htcontent!=NULL)? $htcontent->content:"";
                if($cnky=='description'){
                ?>
                <li class="floating">
                    <label><b><?php echo $cont;?> :</b><p class="small">(15 lines) </p></label><span><textarea name="Hotel[content][<?php echo $cnky;?>]" ><?php echo strip_tags($added_content);?></textarea></span>
                </li>
                <?php
                }else {
                ?>
                <li class="floating">
                    <label><b><?php echo $cont;?> :</b> </label><span><input id="text" type="text" name="Hotel[content][<?php echo $cnky;?>]" value="<?php echo strip_tags($added_content);?>" /></span>
                </li>
                <?php
                }
            endforeach;
            ?>
            <!--<li class="floating">
              <label><b>Detailed description :</b><p class="small">(15 lines) </p></label><span><textarea name="Detail[desc]" ><?php if(isset(Yii::app()->session['detail']['desc'])){echo Yii::app()->session['detail']['desc'];} ?></textarea></span>
            </li>
            <li class="floating">
              <label><b>Closet parking lot + fee :</b> </label><span><input id="text" type="text" name="Detail[lotfee]" value="<?php if(isset(Yii::app()->session['detail']['lotfee'])){echo Yii::app()->session['detail']['lotfee'];} ?>" /></span>
            </li>-->
            <li class="floating photos">
                <label><b>HD photos of the hotel :</b> </label><span><input id="text" type="file" name="Photo"/></span>
                
            </li>            
          </ul>
            <div>
                <label class="bottomAddress"><strong style="font-size:12px;">Yours photos needs to be added in zip to upload</strong></label>
            </div>
          
        <div class="clear30"></div>
        <div class="bottomAddress">
          LLC with a capital stock of 48.250 &#8364; - headquarters : 5, rue de Rochechouart 75009 Paris FRANCE. - Siret : 524 948 924 00013 - Siren : 524 948 924
        </div>
        <div class="clear20"></div>
      </div>
    </div>
    <section class="nextstepPane"><input type="submit" class="nextStep" value="NEXT STEP >>" /></section>
  </section>
  <?php $this->endWidget(); ?>
  <script>
	$(document).ready(function(){
		setTimeout(function(){
		$('.checkedanem').each(function(){
				var value = $(this).val();
				$('.checkboxItemCustom').each(function(){
					if(value == $(this).val())
					{
						$(this).parent().addClass("active");
						$(this).prop( "checked", true );
					}
				});
		});
		},1000);
	});
  </script>