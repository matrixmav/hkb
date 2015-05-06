<div class="fullpgloader" style="display:block"></div>
<section class="searchReasult wrapper" style="visibility: hidden;">
<?php 
//SearchOptionBox
if(!isset($count)){
   $count = 0;  
}
?>
    <div class="mapCont"><?php $this->renderPartial('_map',array('allHotelData' => $allHotelData, 'latitude'=>$latitude, 'longitude'=> $longitude));?></div>
    <!--<div class="step1 resultCont listview">-->
        <div class="step1 resultCont gridviewResult">
    	<div class="showHideBtn"></div>
        <div class="actclass result">
        	<div class="topPart">
                <?php $this->renderPartial('//site/breadcrumbs',array('breadcrumbs' => $breadcrumbs));?>
                <div class="fright shortBox">
                	Sort by :
                    <div class="fright shortby">
                    	<select>
                            <option>relevance</option>
                            <option>relevance</option>
                            <option>relevance</option>
                        </select>
                    </div>
                </div>
                <a href="javascript:void(0)" class="gridviewBtn"><img src="/images/gridView.png" alt=""></a>
                <a href="javascript:void(0)" class="listviewBtn"><img src="/images/listview.png" alt=""></a>
                
                <input type="hidden" id="resCont" name="resCont" value="<?php echo $count; ?>">
                <input type="hidden" id="userSession" name="userSession" value="<?php echo $ustatus = isset(Yii::app()->session['userid'])? Yii::app()->session['userid'] : false; ?>">
                <input type="hidden" id="urldayUse" name="urldayUse" value="<?php Yii::app()->request->baseUrl;?>">
                <input type="hidden" id="per_page" name="per_page" value="<?php echo Yii::app()->params['search']['per_page'];?>">
                <input type="hidden" id="offset_page" name="offset_page" value="0">
                <input type="hidden" id="noresult" name="noresult" value="0">
                <input type="hidden" id="processCont" name="processCont" value="0">
                <p class="heading">Search results : <?php if($count > 0) { echo $count.' Hotels in '.$model->search_keyword; } else{ echo Yii::t('translation','No result found.'); }  ?></p>
                <?php 
                $src_criteria = array();
                foreach($model as $ky=>$val):
                    if($ky=="arrival_time" && $val!="")
                        array_push ($src_criteria, "<i>On ".date('g a',  strtotime($val))."</i>");
                    
                    if($ky=="stay_duration" && $val!="")
                    {
                        $str = ($val=='nuit')? "<i>For night</i>" : "<i>For ".$val." H</i>";                          
                        array_push ($src_criteria, $str);
                    }
                    
                    if($ky=="budget" && $val!="")
                    {
                        $budget = array();
                        $srform = new SearchForm;
                        $budget = $srform->setBudgetArray();
                        array_push ($src_criteria, "<i>".$budget[$val]."</i>");
                    }
                    if($ky=="rating" && $val!="")
                    {
                        $eqarr = $eq = array();
                        $eq = explode(", ",$val);
                        foreach($eq as $v):
                            if($v!="")
                                array_push($eqarr,$v);
                        endforeach;
                        $val = implode(",", $eqarr);
                        array_push ($src_criteria, "<i>star rating in ".$val."</i>");                        
                    }
                    if($ky=="equipment" && $val!="")
                    {
                        $eqarr = $eq = array();
                        $eq = explode(",",$val);
                        foreach($eq as $eqid):
                            if($eqid!="")
                            {
                                $equip = Equipment::model()->findByPk($eqid);
                                array_push($eqarr,$equip->name);
                            }
                        endforeach;
                        $val = implode(", ", $eqarr);
                        array_push ($src_criteria, "<i>with Amenities like ".$val."</i>");
                    }
                    if($ky=="theme" && $val!="")
                    {
                        $eqarr = $eq = array();
                        $eq = explode(",",$val);
                        foreach($eq as $eqid):
                            if($eqid!="")
                            {
                                $equip = Theme::model()->findByPk($eqid);
                                array_push($eqarr,$equip->name);
                            }
                        endforeach;
                        $val = implode(", ", $eqarr);
                        array_push ($src_criteria, "<i>with themes like ".$val."</i>");
                    }     
                    if($ky=="district" && $val!="" && $val!=0)
                    {
                        $area = Area::model()->findByPk($val);
                        array_push ($src_criteria, "<i>in ".$area->name." area</i>");
                    }
                endforeach;
                
                //Criteria
                if(count($src_criteria))
                {
                    echo "<p class='selectresult'>";
                    $val = implode(" and ", $src_criteria);
                    echo $val.".";
                    echo "</p>";
                }
                ?>
                <div class="clear"></div>
            </div>
                <?php if($count > 0) { ?>
                <!--<div id="infinite_scroll" class="step2 resultPart2">-->
                <div id="infinite_scroll" class="step2 resultPart">
                     <ul class="ajaxloaddata">
                     	<?php $this->renderPartial('showAllHotels',array('hoteldata'=>$hoteldata)); ?>
                   	</ul>
                  <div id="loadmoreajaxloader" style="display: none;"><center><img src="/images/ajaxloader.gif"></center> </div>  
                </div>
            
                <?php } ?>
        </div>
        
    </div>
    <div class="clear"></div>
</section>