<script type="text/javascript">
//<!--
 var filterdata = 1;
 var searchfilter = 1;
//-->
</script>
<section id="head_opt" class="SearchOptionBox wrapper" style="display: none;">
	<div class="container">
		<input type='hidden' name="search_widget_type" value="<?php echo $type ?>"/>
		
		<span class="inner_Search_datepicker">  
			<input type="text" name="date_select" id="chk_dt" class="date" value="<?php if(isset($model->date)) { echo $model->date; }  ?>" readonly="readonly" placeholder="DATE">
    		<div class="datepicker" id="datepicker"></div>
                <div class="dateRequired" style="display:none;">Please Select Date</div>
		</span>
		
		<div class="arivaltime">
			<select id="arrival_time_select"> 
				<option>ARRIVAL TIME</option>
			    <?php
                             $selected="";
			    	$arrivalTimeArray = $model->getArrivalTimeArray();
			        for ($i = $arrivalTimeArray['start']; $i <= $arrivalTimeArray['end']; $i = $i + $arrivalTimeArray['duration'] * 60) {
			        	$selected = "";
			            if(isset($model->arrival_time) && $model->arrival_time == date('G:i', $i)) { $selected = "selected"; }
			            	
			            echo "<option $selected value=" . date('G:i', $i) . ">" . date('g A', $i) . "</option>";
					}
                                /*foreach($arrivalTimeArray as $atky=>$atval):
                                    $selected = "";
			            if(isset($model->arrival_time) && $model->arrival_time == $atky) { $selected = "selected"; }
			            echo "<option $selected value=" . $atky . ">" . $atval . "</option>";
                                endforeach;*/
				?>
			</select>
		</div>
    	<div class="length">
			<select name="stay_duration_select" id="stay_duration_select">
		    	<option>LENGTH</option>
		        	<?php 
                                 $selected="";
		            $timeLengthArray = $model->getDurationLength();
		            foreach ($timeLengthArray as $key=>$value) {?>
		            	<?php $selected = "";
			            if(isset($model->stay_duration) && $model->stay_duration == $key) { $selected = "selected"; } ?>
		                <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>;
					<?php } ?>
			</select>
		</div>
	    <div class="devider"><img src="/images/devider.png" alt=""></div>
	    <div class="budget">
	    	<select name="budget_select" id="budget_select">
	        	<option>Budget</option>
		        	<?php 
                                 $selected="";
		            $budgetArray = $model->getBudgetArray();
		            foreach ($budgetArray as $key=>$value) {?>
		            	<?php $selected = "";
			            if(isset($model->budget) && $model->budget == $key) { $selected = "selected"; } ?>
		                <option <?php echo $selected; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>;
					<?php } ?>      
			</select>
		</div>
            
	     <ul name="ratings_select" id="ratings_select" class="multiselect chk_rating"> 
	    	<li>
	        	<a href="javascript:void(0)" class="chk_ratingTrigger">star rating</a>
	        	<ul style="display:none;">
	            	<?php 
                         $selected="";
	            		$starRatingArray = $model->getStarRatings();
                                foreach ($starRatingArray as $key=>$star):
		                	if (isset($model->rating) && !empty($model->rating)) {
                                            $selected = (in_array($key, explode(',',$model->rating)))? " checked" : "";
			                }	                	
	                        echo "<li class='chk_rating_item'><div class='CustomCheckbox'><span><input type='checkbox' value='".$key."'  name='chk_rating[]'".$selected." class='checkboxItemCustom' label='".$star."'></span></div></li>";
						endforeach;
					?>                    	 
				</ul>
			</li>
		</ul>
            <ul name="amenities_select" id="amenities_select" class="multiselect chk_amen"> 
	    	<li>
	        	<a href="javascript:void(0)" class="chk_amenTrigger">amenities</a>
	        	<ul style="display:none;">
	            	<?php 
                        $selected="";
	            		$allEquipments = $model->getEquipmentOptions();
	                	foreach ($allEquipments as $th):
		                	if (isset($model->equipment) && !empty($model->equipment)) {
                                            $selected = (in_array($th->id, explode(',',$model->equipment)))? " checked" : "";
			                }	                	
	                        echo "<li class='chk_amen_item'><div class='CustomCheckbox'><span><input type='checkbox' value='".$th->id."'  name='chk_amen[]'".$selected." class='checkboxItemCustom' label='".$th->name."'></span></div></li>";
						endforeach;
					?>                    	 
				</ul>
			</li>
		</ul>
	    <ul name="preferences_select" id="preferences_select" class="multiselect chk_pref">
	    	<li>
	        	<a href="javascript:void(0)" class="chk_prefTrigger">preferences</a>
	        	<ul style="display:none;">
	            	<?php 
                         $selected="";
	            		$allThemes = $model->getThemeOptions();
	                	foreach ($allThemes as $th):
		                	if (isset($model->theme) && !empty($model->theme)) {
								$selected = (in_array($th->id, explode(',',$model->theme)))? " checked" : "";
			                }	                	
	                        echo "<li class='chk_pref_item'><div class='CustomCheckbox'><span><input type='checkbox' value='".$th->id."'  name='chk_pref[]'".$selected." class='checkboxItemCustom' label='".$th->name."'></span></div></li>";
						endforeach;
					?>                    	 
				</ul>
			</li>
		</ul>
	    <div class="area">
	    	<select id="district_select" name="district_select">
	        	<option value="0">District</option> 
                        <?php 
                        $selected="";
	            	$districts = $model->getDistrictOptions($model->search_id,$model->search_type,$model->district);
	            	foreach ($districts as $des):
	                	$selected = (isset($model->district) && ($des->id == $model->district))? "selected='true'" : "";
	                	echo "<option value='".$des->id."'".$selected.">".$des->name."</option>";
					endforeach;
			?>      
			</select>
		</div>
	    <input type="button" class="searchBtn" id="search_button" value="OK">
	    <div class="clear5"></div>
	</div>
	<a href="javascript:void(0);" class="showHideBtn"></a>
</section>
<script>
$(document).ready(function () {
    
    $.ajax({
        type: "POST",
        url: "/search/getneighbourhood",
        data: {'id': <?php echo $model->search_id;?>,'type':<?php echo $model->search_type;?>,'area':<?php echo $model->district;?>},
        dataType: "json",
        success: function (result) { 
            if(result){
                $("#district_select").append(result);
                $("#district_select").selectmenu("refresh");
            }
        }
    });
});
</script>