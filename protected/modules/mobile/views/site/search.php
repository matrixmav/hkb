<section class="searchBox">
	<!-- <div class="searchCont">
    	<form>
            <input type="text" class="textBox mainText" placeholder="Hôtel, city, district">
            <a href="#" class="mapPin"><img src="//echo Yii::app()->request->baseUrl;/images/mobile/mapPoint.png" alt=""></a>
            <div class="clear"></div>
            <input type="text" class="textBox date" placeholder="date">
            <input type="text" class="textBox arrival" placeholder="arrival Time">
            <div class="clear"></div>
            <input type="submit" class="submitBtn" value="search">
        </form>
    </div>-->
    <div class="searchCont">
			<?php $this->widget('application.widgets.SearchWidget',array('type'=>4)); ?>        
	</div>
</section>