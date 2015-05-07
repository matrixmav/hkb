<style>
	.ui-autocomplete {max-height: 200px;overflow-y: auto;overflow-x: hidden;}
	* html .ui-autocomplete {height: 200px;}
</style>
<script>
var filterdata = 1;
</script>
<?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'hotel_search',
                'htmlOptions' => array('name' => 'search-form'),
                'enableAjaxValidation' => false,
                'action' => "/mobile/search/index",
            	'method' => "GET",
            ));
            ?>
            <input type='hidden' name="search_widget_type" value="<?php echo $type ?>"/>
            <?php 
             $srchBoxInptValue = "";
			 if(isset($model->search_keyword) && $model->search_keyword!=''){
				$srchBoxInptValue = $model->search_keyword;
			 }else{
				$srchBoxInptValue = "Hotel, City, District";
			 }			
			 echo $form->textField($model, 'search_keyword', array('id' => 'search_keyword', "class" => "textBox mainText searchBoxcity", "data-noval" => "Entrez un nom de ville, de département, de restaurant ou un point d'intérêt",  'value'=>"$srchBoxInptValue", 'onfocus'=>"this.value='';", 'onblur'=>"if(this.value==''){this.value='$srchBoxInptValue';}")); ?>
            <?php echo $form->hiddenField($model, 'search_id', array('id' => 'search_id')); ?>
	        <?php echo $form->hiddenField($model, 'search_type', array('id' => 'search_type')); ?>
	        <?php echo $form->hiddenField($model, 'date', array('id' => 'date')); ?>
	        <?php echo $form->hiddenField($model, 'arrival_time', array('id' => 'arrival_time')); ?>
	        <?php echo $form->hiddenField($model, 'stay_duration', array('id' => 'stay_duration')); ?>
	        <?php echo $form->hiddenField($model, 'budget', array('id' => 'budget')); ?>
	        <?php echo $form->hiddenField($model, 'rating', array('id' => 'rating')); ?>
	        <?php echo $form->hiddenField($model, 'equipment', array('id' => 'equipment')); ?>
	        <?php echo $form->hiddenField($model, 'theme', array('id' => 'theme')); ?>
	        <?php echo $form->hiddenField($model, 'district', array('id' => 'district')); ?>
	        <?php echo $form->hiddenField($model, 'order', array('id' => 'order')); ?>
	        <?php echo $form->hiddenField($model, 'page', array('id' => 'page')); ?>
                <?php echo $form->hiddenField($model, 'longitude', array('id' => 'longitude')); ?>
	        <?php echo $form->hiddenField($model, 'latitude', array('id' => 'latitude')); ?>
	        
	        <a href="#" class="mapPin"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/mobile/mapPoint.png" alt=""></a>
            <div class="clear"></div>
            
    		<input type="text" name="date_select" id="chk_dt" class="textBox date" value="<?php if(isset($model->date)) { echo $model->date; }  ?>" readonly="readonly" placeholder="DATE">
    			
            <!-- <input type="text" name="date_select" id="chk_dt" class="textBox date" value="" readonly="readonly" placeholder="DATE">-->
			<!-- <input type="text" class="textBox arrival" placeholder="arrival Time"> -->
			<div class="dInlBlock customselect2Wrap fright" style="width: 46.5%;">
			 <span class="ui-icon ui-icon-triangle-1-s"></span> 
			 <span class="box"></span>
			 <select id="arrival_time_select" onchange="setArrTime($(this).val());" class="arrival customselect2 selected"> <option>ARRIVAL TIME</option>
                                <?php
                                $selected="";
			    	$arrivalTimeArray = $model->getArrivalTimeArray();
			        for ($i = $arrivalTimeArray['start']; $i <= $arrivalTimeArray['end']; $i = $i + $arrivalTimeArray['duration'] * 60) {
			        	$selected = "";
			            if(isset($model->arrival_time) && $model->arrival_time == date('G:i', $i)) { $selected = "selected"; }
			            	
			            echo "<option $selected value=" . date('G:i', $i) . ">" . date('g A', $i) . "</option>";
					}
				?>
				</select>
				</div>
            <div class="clear"></div>    		
    		<!--<input type="submit" class="submitBtn" value="search" id="search_button">-->
    		<button type="button" class="submitBtn" id="search_button">Search <img src="<?php echo Yii::app()->request->baseUrl;?>/images/mobile/searchButtonIcon.png"></button>
            <?php $this->endWidget(); ?>
<script>
   $(function(){
       $("#hotel_search").validate();
   }); 
</script>