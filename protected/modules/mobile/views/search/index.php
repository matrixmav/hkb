<?php 
//SearchOptionBox
if(!isset($count)){
   $count = 0;  
}
?>
<section class="searchResultCont">
  <div id="tabs" class="hDetailTabs">
    <ul>
      <li><a href="#tabs-1" id="tabresult" >results</a></li>
      <li class="maptab" ><a href="#tabs-2">map</a></li>
      <li><a href="#tabs-3" id="tabfilter" >filters</a></li>
    </ul>
    <div id="tabs-1">
      <div class="searchFor">
        <p class="heading"><?php echo $model->search_keyword;?><br>
        <span>
        <?php if($model->date!=""){?>
           <span><?php echo date('j F Y',strtotime($model->date));?></span>
           <?php }
           else
           {
               $addS = ($count>1)? 's':'';
               if($count > 0) { echo $count.' Hotel'.$addS; } else{ echo Yii::t('translation','No result found.'); }
           }
           ?>
         </span>
        </p> <input type="hidden" id="srch_datepicker" />
        <a href="javascript:void(0)" class="button mobSearch date">See Rates</a></div>
      <div class="sortBy">
        <p class="normal">Sort by :</p>
        <div class="rightPart">
           <div class="dInlBlock customselect2Wrap" style="width: 100%;">
           <span class="ui-icon ui-icon-triangle-1-s"></span> 
           <span class="box"></span>
           <select class="customselect2 selected">
              <option>Price</option>                
            </select>           
           </div>


        </div>
        <div class="clear"></div>
      </div>
      <!--  every second result requires <div class="eachResult odd"> -->
      <div class="searchResult avecDate">
       <?php if($count > 0) { ?>
       <?php $this->renderPartial('showAllHotels',array('hoteldata'=>$hoteldata)); ?>
        <?php }?>   
          <!--<div id="loadmoreajaxloader" style="display: none;"><center><img src="/images/ajaxloader.gif"></center> </div>-->
      </div>
    </div>
    <div id="tabs-2" class="asdf">
      <?php $this->renderPartial('_map',array('allHotelData' => $allHotelData, 'latitude'=>$latitude, 'longitude'=> $longitude));?>
    </div>
    <div id="tabs-3">
    <?php $this->widget('application.widgets.SearchWidget',array('type'=>5)); ?>      
  </div>
</section>