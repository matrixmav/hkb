<?php 
 $form = $this->beginWidget('CActiveForm', array(
                'id' => 'hotel_search',
                'htmlOptions' => array('name' => 'search-form'),
                'enableAjaxValidation' => false,
                'action' => "/mobile/search/index",
            	'method' => "GET",
            ));
 $srchBoxInptValue = "";
 if(isset($model->search_keyword) && $model->search_keyword!=''){
 	$srchBoxInptValue = $model->search_keyword;
 }else{
 	$srchBoxInptValue = "Hotel, City, District";
 }
?>
<?php echo $form->hiddenField($model, 'search_keyword', array('search_keyword' => $srchBoxInptValue)); ?>
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
<?php $this->endWidget(); ?>

<div class="actionButtons">
    <ul>
        <li><a href="#" onclick="unsetSearchForm();">CLEAR</a></li>
        <li><a class="active" href="#" onclick="$('form#hotel_search').submit();">APPLY</a></li>
    </ul>
</div>			
<div id="accordion">
        <h3>duration</h3>
        <div>
          <ul class="CustomRadioButton">
	           <?php 
	            $timeLengthArray = $model->getDurationLength();
	            foreach ($timeLengthArray as $key=>$value) {?>
	            <?php 
	            	$selected = (isset($model->stay_duration) && ($key == $model->stay_duration))? "checked" : "";
		        //if(isset($model->stay_duration) && $model->stay_duration == $key) { $selected = "selected"; } ?>	               	                
	                <li>
		              <div class="radioWrap"><span onclick="setSearchVal('custom_stay_duration_select_',<?php echo $key; ?>,<?php echo $key; ?>,'stay_duration');">
		                <input type="radio" <?php echo $selected;?> value="<?php echo $key; ?>" name="custom_stay_duration_select" id="custom_stay_duration_select_<?php echo $key; ?>" class="radioItemCustom" label="<?php echo $value; ?>">
		                </span></div>
		            </li>
				<?php } ?>
          </ul>
        </div>
        <h3>Budget</h3>
        <div>
          <ul class="CustomRadioButton">
            <?php 
            $budgetArray = $model->getBudgetArray();
            foreach ($budgetArray as $key=>$value) {?>
            	<?php 
                $selected = (isset($model->budget) && ($key == $model->budget))? "checked" : "";
            	//$selected = "";
	            //if(isset($model->budget) && $model->budget == $key) { $selected = "selected"; } ?>
                <li>
	              <div class="radioWrap"><span onclick="setSearchVal('custom_budget_select_',<?php echo $key; ?>,<?php echo $key; ?>,'budget');">
	              	<input type="radio" <?php echo $selected;?> value="<?php echo $key; ?>" name="custom_budget_select" id="custom_budget_select_<?php echo $key; ?>" class="radioItemCustom" label="<?php echo $value; ?>">
	                </span></div>
	            </li>
			<?php } ?>      
          </ul>
        </div>
        <h3>star rating</h3>
        <div>
          <ul class="checkbox">
            <?php 
            $starRatingArray = $model->getStarRatings();
            $cnt_rating = count($starRatingArray);
            $rtno = 0;
            foreach ($starRatingArray as $key=>$star):
            $rtno++;
            if (isset($model->rating) && !empty($model->rating)) {
                $selected = (in_array($star, explode(',', $model->rating))) ? " checked" : "";
            }
            //$selected = (isset($model->rating) && ($star == $model->rating))? "checked" : "";
            //echo "<option value='".$key."'".$selected.">".$star."</option>";
            ?>
            <li>
                  <div class="CustomCheckbox"><span onclick="setRatingVal(<?php echo $cnt_rating; ?>,'chk_rating_');">
                          <input type="checkbox" <?php echo $selected; ?> value="<?php echo $star; ?>" name="chk_rating[]" id="chk_rating_<?php echo $rtno; ?>" class="checkboxItemCustom" label="<?php echo $star; ?>">
                      </span></div>
            </li>

            <!--<li>
                                          <div class="radioWrap"><span onclick="setSearchVal('custom_rating_select_',<?php echo $key; ?>,<?php echo $key; ?>,'rating');">
                                            <input type="radio"  <?php echo $selected;?> value="<?php echo $key; ?>" name="custom_rating_select" id="custom_rating_select_<?php echo $key; ?>" class="radioItemCustom" label="<?php echo $star; ?>">
                                            </span></div>
                                        </li>-->
                                    <?php 
                                            endforeach;                	
                                    ?>
          </ul>
        </div>
        <h3>amenities</h3>
        <div>
          <ul class="checkbox">
            <?php 
            $allEquipments = $model->getEquipmentOptions();
            $cnt_equip = count($allEquipments);
            $eqno = 0;
            foreach ($allEquipments as $eq):
            $eqno++;
            if (isset($model->equipment) && !empty($model->equipment)) {
                $selected = (in_array($eq->id, explode(',', $model->equipment))) ? " checked" : "";
            }
            //$selected = (isset($model->equipment) && ($eq->id == $model->equipment))? "checked" : "";
            ?>
            <li>
                    <div class="CustomCheckbox"><span onclick="setEquipVal(<?php echo $cnt_equip; ?>,'chk_equip_');">
                        <input type="checkbox" <?php echo $selected; ?> value="<?php echo $eq->id; ?>" name="chk_equip[]" id="chk_equip_<?php echo $eqno; ?>" class="checkboxItemCustom" label="<?php echo $eq->name; ?>">
                      </span></div>
            </li>

                    <!--<li>
                          <div class="radioWrap"><span onclick="setSearchVal('custom_amenities_select_',<?php echo $eq->id; ?>,<?php echo $eq->id; ?>,'equipment');">
                            <input type="radio" <?php echo $selected;?> value="<?php echo $eq->id; ?>" name="custom_amenities_select" id="custom_amenities_select_<?php echo $eq->id; ?>" class="radioItemCustom" label="<?php echo $eq->name; ?>">
                            </span></div>
                        </li>-->
                    <?php 

                            endforeach;
                    ?>   
            </ul>
        </div>
        <h3>preferences</h3>
        <div>
          <ul class="checkbox">
            <?php 
            $allThemes = $model->getThemeOptions();
            $cnt_theme = count($allThemes);
            $thno = 0;
            foreach ($allThemes as $th):
                $thno++;
                if (isset($model->theme) && !empty($model->theme)) {
                    $selected = (in_array($th->id, explode(',', $model->theme))) ? " checked" : "";
                }
                //echo "<li class='chk_pref_item'><div class='CustomCheckbox'><span><input type='checkbox' value='".$th->id."'  name='chk_pref[]'".$selected." class='checkboxItemCustom' label='".$th->name."'></span></div></li>";
                ?>
                <li>
                      <div class="CustomCheckbox"><span onclick="setThemeVal(<?php echo $cnt_theme; ?>,'chk_pref_');">
                              <input type="checkbox" <?php echo $selected; ?> value="<?php echo $th->id; ?>" name="chk_pref[]" id="chk_pref_<?php echo $thno; ?>" class="checkboxItemCustom" label="<?php echo $th->name; ?>">
                          </span></div>
                </li>
                <?php
            endforeach;
            ?>            
          </ul>
        </div>
        <h3>area</h3>
        <div>
          <ul class="checkbox">
    
          </ul>
        </div>
      </div>
      <div class="resetSearch"><a href="#" onclick="resetSearchForm();"><span>reset search</span></a></div>