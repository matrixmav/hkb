<?php
	/*
	 * Search Widget Type
	 * 1 : Home Main Search Box. e.g Site home page
	 * 2 : Search result page. Only Filters
	 * 3 : Only header with geo loc
	 * 4 : Search section for mobile main search
	 * 5 : Search filters for mobile search result
	 */
	if($type == 1) {
		$this->render('main_search_box', array("model" => $model, "type" => $type));
	} else if($type == 2) {
		//Only filter
	} else if($type == 3){
      	$this->render('header_main_search_box', array("model" => $model, "type"=>$type));
    }
    else if($type == 4){
    	$this->render('mobile_main_search_box', array("model" => $model, "type"=>$type));
    }
    else if($type == 5){
    	$this->render('mobile_search_filters', array("model" => $model, "type"=>$type));
    }
?>
<!-- Search Options -->
<?php $type == 2 ? $this->render('search_filters', array("model" => $model, "type" => $type)) : ""; ?>
<!-- Search Options -->
