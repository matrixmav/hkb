<?php
require_once Yii::app()->basePath.'/components/Mobile_Detect.php';
class SiteController extends Controller
{
   
	/**
	 * Declares class-based actions.
	 */
	public $title, $metadescription;
	public $fbOgTags = array();
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionInsertcountries() {
		
		$dom = new DOMDocument();
	
		//load the html
		$html = $dom->loadHTMLFile("file:///home/kuldeep/Desktop/ct");
		//discard white space
		$dom->preserveWhiteSpace = false;
		//the table by its tag name
		$tables = $dom->getElementsByTagName('table');
		//get all rows from the table
		$rows = $tables->item(0)->getElementsByTagName('tr');
		// get each column by tag name
		$cols = $rows->item(0)->getElementsByTagName('th');
		$row_headers = NULL;
		foreach ($cols as $node) {
			//print $node->nodeValue."\n";
			$row_headers[] = $node->nodeValue;
		}
	
		$table = array();
		//get all rows from the table
		$rows = $tables->item(0)->getElementsByTagName('tr');
		foreach ($rows as $row) {
			// get each column by tag name
			$cols = $row->getElementsByTagName('td');
			$row = array();
			$i=0;
			foreach ($cols as $node) {
				$nodeValue = "";
				if($i == 2) {
					$nodeValue = $node->nodeValue;
					$nodeValueArr = explode("/",$nodeValue);
					$nodeValue = trim($nodeValueArr[1]);
				} else if ($i == 1) {
					$nodeValue = $node->nodeValue;
					$nodeValueArr = explode(",",$nodeValue);
					$nodeValue = trim($nodeValueArr[0]);
				} else {
					$nodeValue = $node->nodeValue;
				}
				
				$row[] = $nodeValue;
				$i++;
			}
			$countryName = $row[0];
			$countrySlug = strtolower($countryName);
			$countrySlug = str_replace('.', '', $countrySlug);
			$countrySlug = str_replace(' and ', '-', $countrySlug);
			$countrySlug = str_replace(' ', '-', $countrySlug);
			$row[] = $countrySlug;
			
			$table[] = $row;
		}
		$sqlString = "";
		foreach ($table as $countryData) {
			$sqlString .= "INSERT INTO tbl_country (name, slug, iso_code, country_code, added_at, updated_at) VALUES ('".$countryData[0]."', '".$countryData[6]."', '".$countryData[2]."', '".$countryData[1]."', NOW(), NOW());<br>";
		}
		echo $sqlString;
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($action = '')
	{ 
            $detector = new Mobile_Detect;
            if($detector->isMobile() || $detector->isTablet())
                $this->redirect(array('/mobile'));
			
            $myIdAddress =  '208.109.223.173'; //$_SERVER['REMOTE_ADDR']
            
            // geo-localize your visitors
//            $visitorsGeoLocalize = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$myIdAddress));
            
            //$cityName = $visitorsGeoLocalize['geoplugin_city'];
            //$stateName = $visitorsGeoLocalize['geoplugin_city']
            //$countryName = $visitorsGeoLocalize['geoplugin_countryName'];
            
            $hotelModel = Hotel::model();
            $homeBannerModel = HomeBanner::model();
            $cityModel = City::model();
            
           
            $cityName = 'new-york'; //TODO: get from geo location
            $stateName = 'new-york';  
            $countryName = 'USA';
            
            //set localization details in session
            Yii::app()->session['localization'] = array(
                'country'=>$countryName,
                'state'=>$stateName,
                'city'=>$cityName,
            );
            $action = $this->getAction()->getId();
            $this->loadMetas($action);
            $condition = array ("slug" => $cityName);
            //read geo location city
            $cityObject = $cityModel->getCityByName($condition);
            // get top 8 cities with the hotel count
            
            $stateCondition = array("id" => $stateName);
            $stateObject = $stateModel = State::model()->getStateByName($stateCondition);
            $cityId = 0;       
            if ($cityObject) {
                $cityId = $cityObject->id;
            }
            $cityListObject = $cityModel->getTopCityByStateId($cityObject->state_id,$cityId); //TODO: need to remove hard coded value 14
          
            if ($cityObject) {
                $cityId = $cityObject->id;
               $cityCondition = 'city_id = ' . $cityId;
                //read city banner
                $sliderImageObject = $homeBannerModel->getHomeSliderBannerImage($cityCondition);
 
                //get state neighbourhood
                $stateNeighbourhood = array();
                $stateNeighbourhoodCount = count($stateNeighbourhood);
                //If no neighbourhood set default hotel count is 4
                $hotelLimit = 4;
                /*if (!empty($stateNeighbourhoodCount)) {
                    $hotelLimit = $this->getHoteLimit($stateNeighbourhoodCount);
                }
                $addNeighbourhoodHotelIdArray = array(3);
                */
                
                $featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($cityCondition);

                if(empty($featuredHotelIdforState)){
                    $stateCondition = array("slug" => $stateName);
                    $stateObject = $stateModel = State::model()->getStateByName($stateCondition);
                    $stateId = $stateObject->id;
                    $stateHomeSliderCondition = 'state_id = ' . $stateId;
                    $featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($stateHomeSliderCondition);
                }
            
                $hotelObject = $hotelModel->readHotel($featuredHotelIdforState, $hotelLimit);
                $hotelLimit = BaseClass::getHotelLimit(count($hotelObject));
                if(!empty($featuredHotelIdforState)){
                    $otherHotelCondition = "id NOT IN (".implode(',', $featuredHotelIdforState).")  AND status = 1";
                    $otherHotelObject = $hotelModel->findAll(array('condition'=>$otherHotelCondition,'limit'=>$hotelLimit));
                    $hotelObject = array_merge($hotelObject, $otherHotelObject);
                }
                //read hotels
                /*if (!empty($addNeighbourhoodHotelIdArray)) {
                    $stateNeighbourhoodHotelObject = $hotelModel->readHotel($addNeighbourhoodHotelIdArray, $hotelLimit);
                    $hotelObject = array_merge($hotelObject, $stateNeighbourhoodHotelObject);
                }*/
                $cityHotelCondition = "is_new = 1  AND status = 1 AND city_id =". $cityId;
                //read geo location city
                $topHotelObject = $hotelModel->readHotelWithCondition($cityHotelCondition, 6);
                
                $cityHotelFeaturedCondition = "is_feature = 1  AND status = 1 AND city_id =". $cityId;
                //read geo location city
                $topFeaturedHotelObject = $hotelModel->readHotelWithCondition($cityHotelFeaturedCondition, 6);

                $cityHotelCondition = "city_id =". $cityId . ' AND status = 1';
                $bestDealOrder = 'best_deal';
                //read geo location city
                $bestDealHotelObject = $hotelModel->readHotelWithCondition($cityHotelCondition, $bestDealOrder, 6);
  
                $breadcrumbs = array( $countryName => array('country', 'name'=>$countryName),
                $stateName => array('state?name='.$stateName.'&country='.$countryName),$cityName,);
                $this->pageTitle = "1000 hotels for a few hours across the world";
                
                $topAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'top','city_id'=>$cityId);
                $topAdBannerObject = HomeAdBanner::model()->findByAttributes($topAdBannerCondition,array('order'=>'updated_at DESC'));
                $bottomAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'bottom','city_id'=>$cityId);
                $bottomAdBannerObject = HomeAdBanner::model()->findByAttributes($bottomAdBannerCondition,array('order'=>'updated_at DESC'));

                $this->render('index', array( 
                    'featuredHotelPhotoObject'=>$sliderImageObject ,
                    'hotelObject' => $hotelObject,
                    'featuredHotelObject' => $topFeaturedHotelObject,
                    'topHotelObject' => $topHotelObject,
                    'bestDealHotelObject' => $bestDealHotelObject,
                    'cityListObject' => $cityListObject,
                    'topAdBannerObject'=>$topAdBannerObject,
                    'bottomAdBannerObject'=>$bottomAdBannerObject,
                    'breadcrumbs'=>$breadcrumbs));
            } else {
                //read state be geo location
                $stateCondition = array("slug" => $stateName);
                $stateObject = $stateModel = State::model()->getStateByName($stateCondition);
               
                 
                 if ($stateObject) {
                    $this->actionState($countryName, $stateName);
                } else {
                    $this->actionCountry($countryName);
                }
            }

           
	}
	
        /**
         * get neighbourhood limit
         * 
         * @param type $neighbourhoodCount
         * @return limit
         */
        public function getHoteLimit($neighbourhoodCount){
            
            if($neighbourhoodCount == 1){
                return $hotelLimit = 5;
            } elseif ($neighbourhoodCount == 2) {
                return $hotelLimit = 4;
            } elseif ($neighbourhoodCount == 3) {
                return $hotelLimit = 3;
            } else{
                return $hotelLimit = 2;
            }
        }
        
        public function actionCity()
        {
        	$myIdAddress =  '208.109.223.173'; //$_SERVER['REMOTE_ADDR']
        	
        	// geo-localize your visitors
        	//            $visitorsGeoLocalize = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$myIdAddress));
        	
        	//$cityName = $visitorsGeoLocalize['geoplugin_city'];
        	//$stateName = $visitorsGeoLocalize['geoplugin_city']
        	//$countryName = $visitorsGeoLocalize['geoplugin_countryName'];
        	
        	$hotelModel = Hotel::model();
        	$homeBannerModel = HomeBanner::model();
        	$cityModel = City::model();
        	
        	 
        	$cityName = 'new-york'; //TODO: get from geo location
        	$stateName = 'california';
        	$countryName = 'USA';
        	
        	//set localization details in session
        	Yii::app()->session['localization'] = array(
        	'country'=>$countryName,
        	'state'=>$stateName,
        	'city'=>$cityName,
        	);
        	$condition = array ("slug" => $cityName);
        	//read geo location city
        	$cityObject = $cityModel->getCityByName($condition);
        	// get top 8 cities with the hotel count
       	
        	$stateCondition = array("id" => $stateName);
        	$stateObject = $stateModel = State::model()->getStateByName($stateCondition);
        	$cityId = 0;
        	if ($cityObject) {
        		$cityId = $cityObject->id;
        	}
        	$cityListObject = $cityModel->getTopCityByStateId($cityObject->state_id,$cityId); //TODO: need to remove hard coded value 14
        	
        	if ($cityObject) {
        		$cityId = $cityObject->id;

                        $cityCondition = 'city_id = ' . $cityId;
        		//read city banner
        		$sliderImageObject = $homeBannerModel->getHomeSliderBannerImage($cityCondition);
        	
        		//get state neighbourhood
        		$stateNeighbourhood = array();
        		$stateNeighbourhoodCount = count($stateNeighbourhood);
        		//If no neighbourhood set default hotel count is 4
        		$hotelLimit = 4;
        		/*if (!empty($stateNeighbourhoodCount)) {
        		 $hotelLimit = $this->getHoteLimit($stateNeighbourhoodCount);
        		 }
        		 $addNeighbourhoodHotelIdArray = array(3);
        		 */
        		$featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($cityCondition);
        	
        		if(empty($featuredHotelIdforState)){
        			$stateCondition = array("slug" => $stateName);
        			$stateObject = $stateModel = State::model()->getStateByName($stateCondition);
        			$stateId = $stateObject->id;
        			$stateHomeSliderCondition = 'state_id = ' . $stateId;
        			$featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($stateHomeSliderCondition);
        		}
        	
        		$hotelObject = $hotelModel->readHotel($featuredHotelIdforState, $hotelLimit);
        		$hotelLimit = BaseClass::getHotelLimit(count($hotelObject));
                        if($featuredHotelIdforState){
                            $otherHotelCondition = "id NOT IN (".implode(',', $featuredHotelIdforState).")  AND status = 1";
                            $otherHotelObject = $hotelModel->findAll(array('condition'=>$otherHotelCondition,'limit'=>$hotelLimit));
                            $hotelObject = array_merge($hotelObject, $otherHotelObject);
                        }
        		//read hotels
        		/*if (!empty($addNeighbourhoodHotelIdArray)) {
        		$stateNeighbourhoodHotelObject = $hotelModel->readHotel($addNeighbourhoodHotelIdArray, $hotelLimit);
        		$hotelObject = array_merge($hotelObject, $stateNeighbourhoodHotelObject);
        		}*/
                        
        		$cityHotelCondition = "is_new = 1  AND status = 1 AND city_id =". $cityId;
        		//read geo location city
                        $topHotelObject = $hotelModel->readHotelWithCondition($cityHotelCondition, 6);
        	
        		$cityHotelFeaturedCondition = "is_feature = 1  AND status = 1 AND city_id =". $cityId;
        		//read geo location city
        		$topFeaturedHotelObject = $hotelModel->readHotelWithCondition($cityHotelFeaturedCondition, 6);
        	
        		$cityHotelCondition = "city_id =". $cityId . ' AND status = 1';
        		$bestDealOrder = 'best_deal';
        		//read geo location city
        		$bestDealHotelObject = $hotelModel->readHotelWithCondition($cityHotelCondition, $bestDealOrder, 6);
        	
        		$breadcrumbs = array( $countryName => array('country', 'name'=>$countryName),
        		$stateName => array('state?name='.$stateName.'&country='.$countryName),$cityName,);
                        
                        $topAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'top', 'city_id' =>$cityId);
                        $topAdBannerObject = HomeAdBanner::model()->findByAttributes($topAdBannerCondition,array('order'=>'updated_at DESC'));
                        $bottomAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'bottom', 'city_id' =>$cityId);
                        $bottomAdBannerObject = HomeAdBanner::model()->findByAttributes($bottomAdBannerCondition,array('order'=>'updated_at DESC'));
                
        		$this->render('index', array(
        		'featuredHotelPhotoObject'=>$sliderImageObject ,
        		'hotelObject' => $hotelObject, 
                        'featuredHotelObject' => $topFeaturedHotelObject,
                        'topHotelObject' => $topHotelObject,
                        'bestDealHotelObject' => $bestDealHotelObject,
                        'cityListObject' => $cityListObject,
                        'topAdBannerObject'=>$topAdBannerObject,
                        'bottomAdBannerObject'=>$bottomAdBannerObject,
                        'breadcrumbs'=>$breadcrumbs));
        	} else {
        		 
        		//read state be geo location
        		$stateCondition = array("slug" => $stateName);
        				$stateObject = $stateModel = State::model()->getStateByName($stateCondition);
        				 
        				 
        				if ($stateObject) {
        				$this->actionState($countryName, $stateName);
        	} else {
        	$this->actionCountry($countryName);
        	}
        	}
        }
        
        /**
         * get State home page
         * 
         * @param type $countryName
         * @param type $stateName
         */
        public function actionState($countryName = '', $stateName = ''){
            
            if(!$stateName){
                $countryName = $_GET['country'];
                $stateName = $_GET['name'];
            }
            
            $hotelModel = Hotel::model();
            $homeBannerModel = HomeBanner::model();
            $cityModel = City::model();
            // get top 8 cities with the hotel count
            $cityListObject = $cityModel->getCity();
            
            $stateCondition = array("slug" => $stateName);
            $stateObject = $stateModel = State::model()->getStateByName($stateCondition);
            
            $stateId = $stateObject->id;
                $stateHomeSliderCondition = 'state_id = ' . $stateId;
            //read state banners
            $sliderImageObject = $homeBannerModel->getHomeSliderBannerImage($stateHomeSliderCondition);

            //get state neighbourhood
            $stateNeighbourhood = array();
            $stateNeighbourhoodCount = count($stateNeighbourhood);
            //If no neighbourhood set default hotel count is 4
            $hotelLimit = 4;
            /*
            if (!empty($stateNeighbourhoodCount)) {
                $hotelLimit = $this->getHoteLimit($stateNeighbourhoodCount);
            }
            $addNeighbourhoodHotelIdArray = array(2, 4, 5);
            */
            $featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($stateHomeSliderCondition);
            $hotelObject = $hotelModel->readHotel($featuredHotelIdforState, $hotelLimit);
            $hotelLimit = BaseClass::getHotelLimit(count($hotelObject));
            $stateHotelCondition = "is_new = 1 AND status = 1 AND state_id =". $stateId;
            //read geo location city
            $topHotelObject = $hotelModel->readHotelWithCondition($stateHotelCondition, 6);

            $stateHotelCondition = "city_id =". $stateId . ' AND status = 1';
            $bestDealOrder = 'best_deal';
            //read geo location city
            $bestDealHotelObject = $hotelModel->readHotelWithCondition($bestDealOrder, $bestDealOrder, 6);
            if($featuredHotelIdforState){
                $otherHotelCondition = "id NOT IN (".implode(',', $featuredHotelIdforState).")  AND status = 1";
                $otherHotelObject = $hotelModel->findAll(array('condition'=>$otherHotelCondition,'limit'=>$hotelLimit));
                $hotelObject = array_merge($hotelObject, $otherHotelObject);
            }
            //read hotels
            /*if (!empty($addNeighbourhoodHotelIdArray)) {
                $stateNeighbourhoodHotelObject = $hotelModel->readHotel($addNeighbourhoodHotelIdArray, $hotelLimit);
                $hotelObject = array_merge($hotelObject, $stateNeighbourhoodHotelObject);
            }*/
             $stateHotelFeaturedCondition = "is_feature = 1  AND status = 1 AND state_id =". $stateId;
                //read geo location city
            $topFeaturedHotelObject = $hotelModel->readHotelWithCondition($stateHotelFeaturedCondition, 6);
            $breadcrumbs = array( $countryName => array('country', 'name'=>$countryName),
                $stateName,
            );
            $topAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'top', 'state_id' =>$stateId);
            $topAdBannerObject = HomeAdBanner::model()->findByAttributes($topAdBannerCondition,array('order'=>'updated_at DESC'));
            $bottomAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'bottom', 'state_id' =>$stateId);
            $bottomAdBannerObject = HomeAdBanner::model()->findByAttributes($bottomAdBannerCondition,array('order'=>'updated_at DESC'));
                        
            $this->render('index', array( 
                'featuredHotelPhotoObject'=>$sliderImageObject ,
                'hotelObject' => $hotelObject,
                'featuredHotelObject' => $topFeaturedHotelObject,
                'topHotelObject' => $topHotelObject,
                'bestDealHotelObject' => $bestDealHotelObject,
                'cityListObject' => $cityListObject,
                'topAdBannerObject'=>$topAdBannerObject,
                'bottomAdBannerObject'=>$bottomAdBannerObject,
                'breadcrumbs'=>$breadcrumbs));
        }
        
        /**
         * get country home page
         * 
         * @param type $countryName
         */
        public function actionCountry($countryName = ''){
            if(!$countryName){
                $countryName = $_GET['name'];
            }
            $hotelModel = Hotel::model();
            $homeBannerModel = HomeBanner::model();
            $cityModel = City::model();
            
            // get top 8 cities with the hotel count
            $cityListObject = $cityModel->getCity();
            
            $countryCondition = array("slug" => $countryName);

            $countryObject = $stateModel = Country::model()->getCountryByName($countryCondition);

            $countryId = $countryObject->id;
            $countryHomeSliderCondition = 'country_id = ' . $countryId;
            $sliderImageObject = $homeBannerModel->getHomeSliderBannerImage($countryHomeSliderCondition);


            $countryNeighbourhood = array();
            $countryNeighbourhoodCount = count($countryNeighbourhood);
            //If no neighbourhood set default hotel count is 4
            $hotelLimit = 4;
            /*if (!empty($countryNeighbourhoodCount)) {
                $hotelLimit = $this->getHoteLimit($countryNeighbourhoodCount);
            }*/
            //$addCountryNeighbourhoodHotelIdArray = array(2, 1, 5,6);

            $featuredHotelIdforCountry = FeaturedHotel::model()->getFeaturedHotelListId($countryHomeSliderCondition);
            
            $hotelObject = $hotelModel->readHotel($featuredHotelIdforCountry, $hotelLimit);
            $hotelLimit = BaseClass::getHotelLimit(count($hotelObject));
            $countryHotelCondition = "is_new = 1 AND status = 1 AND country_id =". $countryId;
            //read geo location city
            $topHotelObject = $hotelModel->readHotelWithCondition($countryHotelCondition, 6);

            $countryHotelCondition = "country_id =". $countryId . ' AND status = 1';
            $bestDealOrder = 'best_deal';
            //read geo location city
            $bestDealHotelObject = $hotelModel->readHotelWithCondition($countryHotelCondition, $bestDealOrder, 6);
            if($featuredHotelIdforCountry){
                $otherHotelCondition = "id NOT IN (".implode(',', $featuredHotelIdforCountry).") AND status = 1";
                $otherHotelObject = $hotelModel->findAll(array('condition'=>$otherHotelCondition,'limit'=>$hotelLimit));
                $hotelObject = array_merge($hotelObject, $otherHotelObject);
            }
            
            $countryHotelFeaturedCondition = "is_feature = 1  AND status = 1 AND country_id =". $countryId;
                //read geo location city
            $topFeaturedHotelObject = $hotelModel->readHotelWithCondition($countryHotelFeaturedCondition, 6);
            
            //read hotels
            /*if (!empty($addCountryNeighbourhoodHotelIdArray)) {
                $countryNeighbourhoodHotelObject = $hotelModel->readHotel($addCountryNeighbourhoodHotelIdArray, $hotelLimit);
                $hotelObject = array_merge($hotelObject, $countryNeighbourhoodHotelObject);
            }*/
         
            $topAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'top', 'country_id' =>$countryId);
            $topAdBannerObject = HomeAdBanner::model()->findByAttributes($topAdBannerCondition,array('order'=>'updated_at DESC'));
            $bottomAdBannerCondition = array('ad_page'=>'home', 'ad_pos' => 'bottom', 'country_id' =>$countryId);
            $bottomAdBannerObject = HomeAdBanner::model()->findByAttributes($bottomAdBannerCondition,array('order'=>'updated_at DESC'));
            
            $breadcrumbs = array( $countryName);
            $this->render('index', array( 
                'featuredHotelPhotoObject'=>$sliderImageObject ,
                'hotelObject' => $hotelObject,
                'featuredHotelObject' => $topFeaturedHotelObject,
                'topHotelObject' => $topHotelObject,
                'bestDealHotelObject' => $bestDealHotelObject,
                'cityListObject' => $cityListObject,
                'topAdBannerObject'=>$topAdBannerObject,
                'bottomAdBannerObject'=>$bottomAdBannerObject,
                'breadcrumbs'=>$breadcrumbs));
        }

        /**
	 *This is action label
	 */
	public function actionLabel()
	{
		$this->render('label');
	}
	
	/**
	 *This is action furniture
	 */
	public function actionFurniture()
	{
		$this->render('furniture');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		if(isset($_GET['mobile']))
		{
			$url = Yii::app()->getBaseUrl(true)."/mobile";
		}else {
			$url = Yii::app()->homeUrl;
		}
		$this->redirect($url);
	}
        
        public function getVisitorLocation($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
//            function ip_info() {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        
        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->geoplugin_city,
                            "state" => @$ipdat->geoplugin_regionName,
                            "country" => @$ipdat->geoplugin_countryName,
                            "country_code" => @$ipdat->geoplugin_countryCode,
                            "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }

        return $output;
    }
    protected function loadMetas($action = 'index'){
    
    	if(!empty(Yii::app()->session['localization']['city']))
    	{
    		$title = Yii::app()->session['localization']['city'];
    		$desc = "";
    		$image = "";
    		
    	}elseif (!empty(Yii::app()->session['localization']['state']))
    	{
    		$title = Yii::app()->session['localization']['state'];
    		$desc = "";
    		$image = "";
    	}elseif (!empty(Yii::app()->session['localization']['country']))
    	{
    		$title = Yii::app()->session['localization']['country'];
    		$desc = "";
    		$image = "";
    	}else {
    		$title = Yii::app()->params['sitename'];
    		$desc = "";
    		$image = "";
    	}
    	$fbOgTags = array();
    	$fbOgTags['title'] = $title;
    	$fbOgTags['description'] = $desc;
    	$fbOgTags['image'] = $image;
    	$fbOgTags['site_name'] = Yii::app()->params['sitename'];
    	$this->fbOgTags = $fbOgTags;
    	//echo '<pre>';print_r($this->fbOgTags);exit;
    }
}