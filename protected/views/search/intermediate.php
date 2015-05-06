<div class="fullpgloader" style="display:block"></div>
<section class="searchReasult wrapper" style="visibility: hidden;">
    <div class="resultCont intermediate">
        <div class="result">
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
                <p class="heading">Search results :</p>
                <div class="clear"></div>
            </div>
            <input type="hidden" id="resCont" name="resCont" value="<?php echo $hotelCount; ?>">
            <input type="hidden" id="userSession" name="userSession" value="<?php echo $ustatus = isset(Yii::app()->session['userid']) ? Yii::app()->session['userid'] : false; ?>">
            <input type="hidden" id="urldayUse" name="urldayUse" value="<?php Yii::app()->request->baseUrl; ?>">
            <input type="hidden" id="per_page" name="per_page" value="<?php echo Yii::app()->params['search']['per_page']; ?>">
            <input type="hidden" id="offset_page" name="offset_page" value="0">
            <input type="hidden" id="noresult" name="noresult" value="0">
            <input type="hidden" id="processCont" name="processCont" value="0">
            <div class="detailsCont">
        		<p class="heading">CITY</p>
        		<?php if(sizeof($cities) > 0) {?>
        			<p class="normal">
	        		<?php foreach ($cities as $k => $city) { ?>
	        			<?php if ($k > 0) { ?><br><?php }
                                        // construct the url
                                        $city_url = Yii::app()->createUrl('/search/index', array("search_widget_type"=>1,"SearchForm[search_keyword]"=>  urlencode($city['lavel']),"SearchForm[search_id]"=>$city['id'],"SearchForm[search_type]"=>2));
                                        ?>
                                        <a href="<?php echo $city_url;?>"><?php echo trim($city['value']); ?></a>
	        		<?php }?>
	        		</p>
        		<?php }?>
                <p class="heading">HOTEL AREA</p>
                <?php if(sizeof($states) > 0) {?>
                	<p class="normal">
	        		<?php foreach ($states as $k => $state) { ?>
        				<?php if ($k > 0) { ?><br><?php }
                                        // construct the url
                                        $state_url = Yii::app()->createUrl('/search/index', array("search_widget_type"=>3,"SearchForm[search_keyword]"=>  urlencode($state['lavel']),"SearchForm[search_id]"=>$state['id'],"SearchForm[search_type]"=>3));
                                        ?>
                                        <a href="<?php echo $state_url;?>"><?php echo $state['value']; ?></a>
        			<?php }?>
        			</p>
        		<?php }?>
                <p class="heading">HOTELS IN NEARBY CITIES</p>
	            <?php if(sizeof($hotels) > 0) {?>
	            	<p class="normal">
	        		    <?php foreach ($hotels as $k => $hotel) { ?>
		        			<?php if ($k > 0) { ?><br><?php }
                                                $hotel_url = Yii::app()->createUrl('/hotel/detail',array("slug"=>$hotel['slug']));
                                                ?>
                                                <a href="<?php echo $hotel_url;?>"><?php echo $hotel['value']; ?></a>
		        		<?php }?>
	        		</p>
	        	<?php }?>
        	</div>            
            	<div id="infinite_scroll" class="step2 resultPart">
                     <ul class="ajaxloaddata">
                     	<?php $this->renderPartial('showAllHotels',array('hoteldata'=>$allHotelsNearBy)); ?>
                   	</ul>
                  <div id="loadmoreajaxloader" style="display: none;"><center><img src="/images/ajaxloader.gif"></center> </div>  
                </div> 
        </div>
    </div>
    <div class="clear"></div>
</section>

<script type="text/javascript">
    $('body').css('overflow','hidden'); 
</script>