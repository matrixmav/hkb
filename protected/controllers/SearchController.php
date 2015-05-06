<?php

class SearchController extends Controller {
	
    //set the layout for search module
    public $layout='search';
    public $title, $metadescription;
    public $fbOgTags = array();
    /*
     * type
     * 1= hotel
     * 2= city
     * 3= state
     *
     */
    public function actionIndex() {
	
        $model = new SearchForm("search");        
    	if (isset(Yii::app()->session['search_model']) && !empty(Yii::app()->session['search_model'])) {
    		if (isset(Yii::app()->session['search_model'])) {
    			unset(Yii::app()->session['search_model']);
    		}
    	}
    	
        // Default city ID
        $default_city_id = (isset(Yii::app()->session['cityId'])) ? Yii::app()->session['cityId'] : Yii::app()->params->default['cityId'];

        //Get the country in which we have to search
        $default_country_id = (isset(Yii::app()->session['countryId'])) ? Yii::app()->session['countryId'] : Yii::app()->params->default['countryId'];

        if (isset($_GET['SearchForm'])) {
        	$model->attributes = $_GET['SearchForm'];
        }
        //$page = Yii::app()->getRequest()->getQuery('page',0);
        $offset_page = Yii::app()->getRequest()->getQuery('offset_page',0);
        
        $cityObj = null;
        $stateObj = null;
        $hotelsCount = 0;
        $hoteldata = null;
        $allHotelData = null;
        // Just check if the type and id is there or not.
        Yii::app()->session['search_model'] = $model;
        
        $add_district = FALSE;
        
        $action = $this->getAction()->getId();
        $this->loadMetas($action,$default_country_id);
        if($model->search_id > 0 && !is_null($model->search_type)) {
        	if($model->search_type == 2) {
                    
                    if($model->district!="District" && $model->district!=0)
                    {
                        $array_area = array();
                        $areacity = AreaCity::model()->findAll("area_id=".$model->district);
                        if(!empty($areacity))
                        {
                            foreach ($areacity as $ar):
                                array_push($array_area, $ar->city_id);
                            endforeach;
                            $arimp = implode(",", $array_area);
                            $areacrit = " h.city_id in (".$arimp.")";
                            $add_district = TRUE;
                        }
                    }
        		// find the hotel that belongs to the city.
                        //get the city details
			$cityObj = City::model()->findByPk($model->search_id);
                        //get the latitude and longitude of the city
                        $model->latitude  =  $cityObj->latitude;
                        $model->longitude =  $cityObj->longitude;
        	} else if ($model->search_type == 3) {
        		//State
        		$stateObj = State::model()->findByPk($model->search_id);
        		//get the latitude and longitude of the city
        		$model->latitude  =  $stateObj->latitude;
        		$model->longitude =  $stateObj->longitude;
        	}
            
            
            $criteriahotel = new CDbCriteria();                
            // call the storeprocedure get_distance 
            $exp = new CDbExpression("get_distance($model->latitude,$model->longitude, latitude, longitude) AS distance");
            $criteriahotel->alias = "h";                
            $criteriahotel->select = "h.*, $exp";                
            //$criteriahotel->addColumnCondition(array('h.status'=>1,'h.city_id'=>$model->search_id));     
            $criteriahotel->addColumnCondition(array('h.status'=>1));    
            if($add_district)
                $criteriahotel->addCondition($areacrit);

            
            $criteriahotel = $this->setFiltersCriteria($criteriahotel, $model);
            
            
            // count the distance in mile
            $distanceMiles = Yii::app()->params['search']['distanceMiles'];
            foreach ($distanceMiles as $distanceMile) {
            	$criteriahotel->having = "distance <= ".$distanceMile;
            	$hotelsCount = Hotel::model()->count($criteriahotel);
            	if($hotelsCount >= Yii::app()->params['search']['min_hotel_required']) {
            		break;
            	}
            }
            $criteriahotel->order = "distance ASC";
            $allHotelData = Hotel::model()->findAll($criteriahotel);
            $criteriahotel->limit = Yii::app()->params['search']['per_page'];
            
            $criteriahotel->offset = $offset_page;
            $hoteldata = Hotel::model()->findAll($criteriahotel);
            
            //If ajax request
            if(Yii::app()->request->isAjaxRequest) {
            	$html = $this->renderPartial('showAllHotels', array(
            			'hoteldata' => $hoteldata,
            		), false, true
            	);
            	echo $html;
            	Yii::app()->end();
            }
		}
                
               
                $bcrumbs = true;
                $breadcrumbs = array();
                
		if(!is_null($model->search_type) && $model->search_type != "" && $model->search_type == 2) {
			// get the city name and state namecountry name
			$cityName  = $cityObj->name;
                        $citySlug = $cityObj->slug;
			$stateObj  = State::model()->findByPK($cityObj->state_id);
			$stateName = $stateObj->name;
			$stateSlug  = $stateObj->slug;
			$countryObj = Country::model()->findByPK($cityObj->country_id);
			$countryName = $countryObj->name;
			$countrySlug = $countryObj->slug;
		} elseif (!is_null($model->search_type) && $model->search_type != "" && $model->search_type == 3) {
			// get the and state name country name as it search for state
			$cityName  = "";
			$stateName = $stateObj->name;
			$stateSlug = $stateObj->slug;
			$countryObj = Country::model()->findByPK($stateObj->country_id);
			$countryName = $countryObj->name;
			$countrySlug = $countryObj->slug;
		} 
                elseif (!is_null($model->search_type) && $model->search_type != "" && $model->search_type == 4) {
			// No Action required or not defined yet
                        $bcrumbs = false;
		}
                else {
                        // default case
			$cityObj = City::model()->findByPk($default_city_id);
			$cityName  = $cityObj->name;
                        $citySlug = $cityObj->slug;
                        
                        $stateObj  = State::model()->findByPK($cityObj->state_id);
			$stateName = $stateObj->name;
			$stateSlug  = $stateObj->slug;
                        
                        $countryObj = Country::model()->findByPK($cityObj->country_id);
			$countryName = $countryObj->name;
			$countrySlug = $countryObj->slug;
		}
		
                if($bcrumbs)
                {
		//create the breadcrumb
		$breadcrumbs = array( $countryName => array('country', 'name'=>$countrySlug),
        $stateName => array('/site/state?name='.$stateSlug.'&country='.$countrySlug),$cityName,);
                }
                
                 
		if(!is_null($model->search_type) && $model->search_type != "") {
        	// no of hotel result.                   
                    $this->render('index', array('model' => $model, 'hoteldata'=>$hoteldata, 'allHotelData' => $allHotelData, 'latitude'=>$model->latitude, 'longitude'=>$model->longitude, 'count'=>$hotelsCount, 'type'=>$model->search_type, 'breadcrumbs' => $breadcrumbs));
		} else {  
                        
			// User searched without clicking any of the options
			// Send the user to the intermediate search page
			// There are 3 sections to search, they are city,state and hotel 
                   
           	$hotelLimit = $cityLimit = $stateLimit = 10;
                
           	$hotelsArray = array();
			$i = 0;
			$hoteldata = $this->getAllHotelsWithTerm($model->search_keyword, $hotelLimit);
                        $this->formatAllHotelsData($hoteldata, $i, $hotelsArray);
                        //print_r($hotelsArray);
                        //echo "<br/><br/>";
                        
                        $citiesArray = array();
			$i = 0;
			$citydata = $this->getAllCitiesWithTerm($model->search_keyword, $cityLimit);
                        $this->formatAllCitiesData($citydata, $i, $citiesArray);
                        //print_r($citiesArray);
                        //echo "<br/><br/>";
                        
                        
			$statesArray = array();
			$i = 0;
			$statedata = $this->getAllStatesWithTerm($model->search_keyword, $stateLimit);
                        $this->formatAllStatesData($statedata, $i, $statesArray);
                        //print_r($statesArray);
                        //exit;
                        $allHotelsNearByCriteria = $this->getHotelsCriteriaWithIds($hotelsArray);
                        $allCitiesHotelNearByCriteria = $this->getHotelsCriteriaInCities($citiesArray);      
                        $allStatesHotelNearByCriteria = $this->getHotelsCriteriaInStates($statesArray);
                        $allHotelsNearByCriteria->mergeWith($allCitiesHotelNearByCriteria, "OR");
			$allHotelsNearByCriteria->mergeWith($allStatesHotelNearByCriteria, "OR");
			
			//$allHotelsNearByCriteria = $this->setFiltersCriteria($allHotelsNearByCriteria, $model);
			$totalhotelNo = Hotel::model()->count($allHotelsNearByCriteria);
			$allHotelsNearByCriteria->limit = Yii::app()->params['search']['per_page'];
			$allHotelsNearByCriteria->offset = $offset_page;
			
			$allHotelsNearBy = Hotel::model()->findAll($allHotelsNearByCriteria);
                        
			//If ajax request
			if(Yii::app()->request->isAjaxRequest) {
				$html = $this->renderPartial('showAllHotels', array(
						'hoteldata' => $allHotelsNearBy,
				), false, true
				);
				echo $html;
				Yii::app()->end();
			}
			
// 			$totalCount = sizeof($hoteldata)+sizeof($citydata)+sizeof($statedata);
            $breadcrumbs = array( $countryName => array('country', 'name'=>$countrySlug),);
            $this->render('intermediate',array('model' => $model, 'term' => $model->search_keyword, 'allHotelsNearBy' => $allHotelsNearBy, 'hotels'=>$hotelsArray, 'states'=>$statesArray, 'cities'=>$citiesArray, 'hotelCount'=>count($hotelsArray), 'breadcrumbs' => $breadcrumbs));
		}          
    }
   

    public function setFiltersCriteria($criteria, $model) {
		$roomJoined = false;
		$roomAvailabilityJoined = false;
		$budgetJoined = false;
		
                // Situation for Date, Arrival time and Duration
                /*
                1 - Consider the rooms
                    when you search with arrival time, length, other options, MAKE SURE there is at least one room for the hotel in search results which corresponds to the criteria.

                    For example, if for hotel 1, there are 2 rooms: 
                    
                    Room 1: 11 AM to 4 PM
                    Room 2: 10 AM to 6 PM

                    If arrival time is set to 1 PM, and length is 4 hours: Room 2 is eligible, hotel should be in search results
                    Arrival time is set to 9 AM, and length is not set: no room eligible, hotel is not in search results
                    Arrival time is set to 5 PM, and length is set to 2 hours: no room eligible, hotel is not in search results

                2 - One specific rule is there for today's reservation: You cannot reserve a room 2 hours before room is closed: 

                --> It is now 3:30 PM, and I reserve Room 2: ok, because it is 2:30 hours before Room 2 is closed
                --> It is now 4:00 PM: I cannot reserve any room for that hotel today. 
                */
                
                //Date
                $isToday = 0;
		if(isset($model->date) && !empty($model->date)) {
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
				if(!$roomAvailabilityJoined) {
					$criteria->join.=" JOIN tbl_room_availability ra on rm.id=ra.room_id";
					$roomAvailabilityJoined = true;
				}
			}
			$roomJoined = true;
			$searchDate = date("Y-m-d",strtotime($model->date));
			$criteria->addCondition("ra.availability_date LIKE '".$searchDate."%'");
                        
                        //Check if the date is selected is today's date or not
                        $isToday = ($searchDate == date('Y-m-d'))? 1 : 0;
		}
                
                //Set the timeframe based arrival time and duration
                $setArr = (isset($model->arrival_time) && !empty($model->arrival_time))? 1 : 0;
                $setTill = (isset($model->stay_duration) && !empty($model->stay_duration) && ($model->stay_duration != 'LENGTH')) ? 1 : 0;
                $setNuit = 0;
                if($setTill)
                {
                    $setNuit = ($model->stay_duration == 'nuit')? 1 : 0;
                }
                
                if($setArr && $setTill && !$setNuit)
                {
                    // The room should be avaialable in between the RequiredFrom and RequiredTill
                    if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
			}
                        
                    $reqFrom = date("H:i:s",strtotime($model->arrival_time));                  

                    $totMins = $model->stay_duration * 60 * 60; // Turn the duration in seconds
                    $reqTill = date("H:i:s",(strtotime($model->arrival_time)+$totMins));



                    $criteria->addCondition("rm.available_from <='".$reqFrom."'");
                    $criteria->addCondition("rm.available_till >'".$reqFrom."'");

                    $criteria->addCondition("rm.available_till >='".$reqTill."'");

                    //If today then greater than 2 hours before room is closed
                    if($isToday)
                        $criteria->addCondition("TIMEDIFF(rm.available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
                }
                else
                {
                    //if only if the duration is specified not the arrival
                    if($setArr ==0 && $setTill==1)
                    {
                        // The room should be avaialable in between the duration
                        if(!$roomJoined) {
                                    $criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
                                    $roomJoined = true;
                            }
                        switch ($model->stay_duration) {
				case 'nuit':
					$criteria->addCondition("rm.category = 'moon'");
					break;
				default :
					$criteria->addCondition("rm.category != 'moon'");
                                        //If today then greater than 2 hours before room is closed
                                        if($isToday)
                                            $criteria->addCondition("TIMEDIFF(rm.available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
                                        else
                                            $criteria->addCondition("TIMEDIFF(rm.available_till, rm.available_from) >= $model->stay_duration");
                                        break;
			}
                    }
                    
                    //if only if the arrival is specified not the duration
                    if($setArr ==1 && $setTill==0)
                    {
                        // The room should be avaialable before or on the arrival time
                        if(!$roomJoined) {
                                    $criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
                                    $roomJoined = true;
                            }
                            
                        $reqFrom = date("H:i:s",strtotime($model->arrival_time));
                        $criteria->addCondition("rm.available_from <='".$reqFrom."'");
                        $criteria->addCondition("rm.available_till >'".$reqFrom."'");
                        
                        if($isToday)
                            $criteria->addCondition("TIMEDIFF(rm.available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
                                        
                    }
                }
                
                /*
                //Arrival Time
		if(isset($model->arrival_time) && !empty($model->arrival_time)) {
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
			}
			$arrivalTime = date("H:i:s",strtotime($model->arrival_time));
			//$criteria->addCondition("rm.available_from<='".$arrivalTime."'");
                        //$criteria->addCondition("rm.available_till>'".$arrivalTime."'");
                        $criteria->addCondition("rm.available_from >='".$arrivalTime."'");
                        
		}
		
                
		//Stay Duration
		if(isset($model->stay_duration) && !empty($model->stay_duration) && ($model->stay_duration != 'LENGTH') ) { 
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
				if(!$roomAvailabilityJoined) {
					$criteria->join.=" JOIN tbl_room_availability ra on rm.id=ra.room_id";
					$roomAvailabilityJoined = true;
				}
			}
			switch ($model->stay_duration) {
				case 'nuit':
					$criteria->addCondition("rm.category = 'moon'");
					break;
				default :
					$criteria->addCondition("rm.category != 'moon'");
					//$criteria->addCondition("TIMESTAMPDIFF(HOUR, rm.available_till, rm.available_from) >= $model->stay_duration");
                                        $criteria->addCondition("TIMEDIFF(rm.available_till, rm.available_from) >= $model->stay_duration");
                                        break;
			}
		}
                */
		
		//Budget
		if(isset($model->budget) && !empty($model->budget)) {
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
				if(!$budgetJoined) {
					$criteria->join.=" JOIN tbl_room_tariff rt on rm.id=rt.room_id";
					$budgetJoined = true;
				}
			}
                        else
                        {
                            if(!$budgetJoined) {
					$criteria->join.=" JOIN tbl_room_tariff rt on rm.id=rt.room_id";
					$budgetJoined = true;
				}
                        }
                        
			if(isset($model->date) && !empty($model->date)) {
				$searchDate = date("Y-m-d",strtotime($model->date));
				$criteria->addCondition("rt.tariff_date='".$searchDate."'");
			}
			switch ($model->budget) {
				case '1':
					$criteria->addCondition("rt.price <= 100");
					break;
				case '2':
					$criteria->addCondition("rt.price > 100 AND rt.price <= 150");
					break;
				case '3':
					$criteria->addCondition("rt.price >= 150");
					break;
			}
			
		}
		
                /*
		//Rating
		if(isset($model->rating) && !empty($model->rating)) {
			$criteria->addCondition("h.star_rating >= $model->rating");
		}
                */
                
                //Rating    
		if(isset($model->rating) && !empty($model->rating)) {
			$ratingArr = explode(",", $model->rating);
			$ratingStr = trim(implode(",", $ratingArr),','); 
			$criteria->addCondition("h.star_rating IN ($ratingStr)");
		}
		
                /*
		//Amenities
		if(isset($model->equipment) && !empty($model->equipment)) {
			$criteria->join.=" JOIN tbl_room_options ro on rm.id=ro.room_id";
			$criteria->addCondition("ro.equipment_id = $model->equipment");
		}
                */
                
                //Amenities
		if(isset($model->equipment) && !empty($model->equipment)) {
			$equipArr = explode(",", $model->equipment);
			$equipStr = trim(implode(",", $equipArr),','); 
			$criteria->join.=" JOIN tbl_hotel_equipment he on h.id=he.hotel_id";
			$criteria->addCondition("he.equipment_id IN ($equipStr)");
		}
		
		//Preferances
		if(isset($model->theme) && !empty($model->theme)) {
			$themeArr = explode(",", $model->theme);
			$themeStr = trim(implode(",", $themeArr),','); 
			$criteria->join.=" JOIN tbl_hotel_theme ht on h.id=ht.hotel_id";
			$criteria->addCondition("ht.theme_id IN ($themeStr)");
		}
		
		//District
		//TODO:
		
		//Order
		if(isset($model->order) && !empty($model->order)) {
			switch ($model->order) {
				case 1: //Relevance //TODO:
					$criteria->order = "distance ASC";
					break;
				case 2: //Price
					$criteria->order = "h.room_leastprice ASC";
					break;
				case 3: //Distance
					$criteria->order = "distance ASC";
					break;
				case 4: //Promotion
					$criteria->order = "h.best_deal DESC";
					break;
			}
		} else {
			$criteria->order = "distance ASC";
		}
		
		$criteria->group = 'h.id';
		
		return $criteria;
	}
        
	public function actionmakefavorite(){
    	// function to make favorite a hotel
        $resp = array();
        $userid = isset(Yii::app()->session['userid'])? Yii::app()->session['userid'] : '';
        if((isset($_POST['hid']) && !is_null($_POST['hid']))  &&  (isset($_POST['userId']) && !is_null($_POST['userId']))) {
        	//check the userid is same as login userid
            if($_POST['userId'] == $userid){ 					//
            	$checkduplication = CustomerFav::model()->findByAttributes(array('customer_id'=>$userid, 'hotel_id'=>$_POST['hid']));
                if(empty($checkduplication)){                        
                	$austfev =  new CustomerFav;
                    $austfev->customer_id = (int)$_POST['userId'];
                    $austfev->hotel_id = (int)$_POST['hid'];
                    $austfev->added_at = date("Y-m-d H:i:s",strtotime("now"));
                    //$resData =  $austfev->save();                        
                    $austfev->validate();
                    if(!$austfev->save()){

                    	$res['error'] = TRUE;
                        $res['msg'] = 'Already mark as favorite.'; 
                        echo json_encode($res);
						exit();
					} else {
						$res['error'] = FALSE;
                        $res['msg'] = 'Added as favorite.';
                        echo json_encode($res);
                        exit();
					}
				} else {
							CustomerFav::model()->deleteAll("customer_id='" .$userid. "' and hotel_id='".$_POST['hid']."'");
							 $res['error'] = TRUE;
		                     $res['msg'] = 'removed from favorite';
		                     echo json_encode($res);
		                     
		                     exit();
				}
			} else {
				$res['error'] = TRUE;
                $res['msg'] = 'mismatch user id';
                echo json_encode($res);
                exit();
			}               
		} else {
			$res['error'] = TRUE;
            $res['msg'] = 'missing post data';
            echo json_encode($res);
            exit();
		}
	}

	/*
	 * Category id
	 * 1= Hotel
	 * 2= City
	 * 3= State
	 */
	public function actionlistHotelSearch() { 
		$getTerm = Yii::app()->getRequest()->getQuery('term');
		$hotelLimit = $cityLimit = $stateLimit = 10;
		
		$finaldata = array();
		$i = 0;
		$hoteldata = $this->getAllHotelsWithTerm($getTerm, $hotelLimit);
		$this->formatAllHotelsData($hoteldata, $i, $finaldata);
		
		$citydata = $this->getAllCitiesWithTerm($getTerm, $cityLimit);
		$this->formatAllCitiesData($citydata, $i, $finaldata);
		
		$statedata= $this->getAllStatesWithTerm($getTerm, $stateLimit);
		$this->formatAllStatesData($statedata, $i, $finaldata);
		
                              
        header('Content-type: application/json');
        echo CJavaScript::jsonEncode($finaldata);
        Yii::app()->end();
	} 
	
	private function getAllHotelsWithTerm($getTerm, $limit) {
		$criteriahotel = new CDbCriteria();
		//$criteriahotel->select = 'id, name, slug, city_id';
		$criteriahotel->addColumnCondition(array('status'=>1));
		$criteriahotel->addSearchCondition('name', $getTerm);
		$criteriahotel->limit = $limit;
		
		$hoteldata = Hotel::model()->findAll($criteriahotel);
		return $hoteldata;
	}

	private function formatAllHotelsData($hoteldata, &$i, &$finaldata) {
		//Format hotel data
		foreach ($hoteldata as $htd){
                        $finaldata[$i]['id']= $htd->id;
			$finaldata[$i]['value']= $htd->name;
			$finaldata[$i]['lavel']= $htd->name;
                        $finaldata[$i]['slug']= $htd->slug;
			$finaldata[$i]['category']= 'Hotel';
			$finaldata[$i]['url']= Yii::app()->createUrl('hotel/detail',array('slug'=>$htd->slug, 'name'=>$htd->name));
			$i++;
		}
                return $finaldata;
	}
	
	private function getAllCitiesWithTerm($getTerm, $limit) {
		$criteriacity = new CDbCriteria();
		$criteriacity->select = 'id, name, slug, state_id';
		$criteriacity->addColumnCondition(array('status'=>1));
		$criteriacity->addSearchCondition('name',$getTerm);
		$criteriacity->limit = $limit;
		$citydata = City::model()->findAll($criteriacity);
    
		return $citydata;
	}
	
	private function formatAllCitiesData($citydata, &$i, &$finaldata) {
		//Format city data
		foreach ($citydata as $ctd){
			$stateData = State::model()->findByPk($ctd->state_id);
			$statecode = (isset($stateData->code) && !is_null($stateData->code)) ? ' ('. $stateData->code.')' : '';
			$finaldata[$i]['id']= $ctd->id;
			$finaldata[$i]['value']= $ctd->name.$statecode;
			$finaldata[$i]['lavel']= $ctd->name;
			$finaldata[$i]['category']= 'City';
			$finaldata[$i]['url']= Yii::app()->createUrl('/search/index',array('term'=>$ctd->name,'uniId'=>$ctd->id, 'type'=>2 ));
			$i++;
		}
	}
	
	private function getAllStatesWithTerm($getTerm, $limit) {
		$cuntryId = 2 ; //TODO: get the countryId.
		$criteriasatate = new CDbCriteria();
        $criteriasatate->select = 'id, name, slug';
        $criteriasatate->addColumnCondition(array('status'=>1,'country_id'=>$cuntryId));
        $criteriasatate->addSearchCondition('name',$getTerm);  
        $criteriasatate->limit = $limit;
        $statedata= State::model()->findAll($criteriasatate);
        
        return $statedata;
	}
	
	private function formatAllStatesData($statedata, &$i, &$finaldata) {
		//Format state data
		foreach ($statedata as $std){
			$finaldata[$i]['id']= $std->id;
			$finaldata[$i]['value']= $std->name;
			$finaldata[$i]['lavel']= $std->name;
			$finaldata[$i]['category']= 'State';
			$finaldata[$i]['url']= Yii::app()->createUrl('/search/index',array('term'=>$std->slug,'uniId'=>$std->id, 'type'=>3 ));
			$i++;
		}
	}
	
	private function getHotelsCriteriaWithIds($hotelsArray) {
            $criteria = new CDbCriteria();
            if(count($hotelsArray) > 0){
                //$allIds = array_column($hotelsArray, 'id');
                $allIds = array();
                foreach($hotelsArray as $ky=>$val)
                    array_push ($allIds,$val['id']);
                $criteria->addColumnCondition(array('status'=>1));
                $criteria->addCondition("id IN (".implode(",", $allIds).")");
            }   
            return $criteria;
	}
	
	private function getHotelsCriteriaInCities($citiesArray) {
		
		$criteria = new CDbCriteria();
                if(count($citiesArray) > 0){
                    //$allIds = array_column($citiesArray, 'id');
                    $allIds = array();
                    foreach($citiesArray as $ky=>$val)
                        array_push ($allIds,$val['id']);
                    $criteria->addColumnCondition(array('status'=>1));
                    $criteria->addCondition("city_id IN (".implode(",", $allIds).")");
                }
		return $criteria;
	}
	
	private function getHotelsCriteriaInStates($statesArray) {
		
		$criteria = new CDbCriteria();
                if(count($statesArray) > 0){
                    //$allIds = array_column($statesArray, 'id');
                    $allIds = array();
                    foreach($statesArray as $ky=>$val)
                        array_push ($allIds,$val['id']);
                    $criteria->addColumnCondition(array('status'=>1));
		    $criteria->addCondition("state_id IN (".implode(",", $allIds).")");
                }
		return $criteria;
	}
        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	protected function loadMetas($action,$cid){
	
		$country = Country::model()->findByPk($cid);
		$desc = "";
		$image = "";
		
		$fbOgTags = array();
		$fbOgTags['title'] = $country->name;
		$fbOgTags['description'] = $desc;
		$fbOgTags['image'] = $image;
		$fbOgTags['site_name'] = Yii::app()->params['sitename'];
		$this->fbOgTags = $fbOgTags;
		//echo '<pre>';print_r($this->fbOgTags);exit;
	}
        
        public function actionGetNeighbourhood(){
            $optionList = "";
            if($_POST['id']){
                if($_POST['type']==2)
                {
                    $portalObject = AreaCity::model()->findAll('city_id = '.$_POST['id']);
                    if(count($portalObject) > 0) {
                        foreach($portalObject as $portal){
                            if(!empty($portal->area)){
                                $selected = (isset($_POST['area']) && ($portal->area_id == $_POST['area']))? "selected='selected'" : "";
	                	$optionList .= "<option value='".$portal->area->id."' ".$selected.">".$portal->area->name."</option>";
                            }
                        }
                        
                    } 
                }
            }
            header('Content-type: application/json');
            echo CJavaScript::jsonEncode($optionList);
            Yii::app()->end();
        }
}