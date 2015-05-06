<?php

/**
 * Class contains of some common helper functions which are used across the site.
 */
class CommonHelper {

	/**
	 * Global function to send an email from the application.
	 * @param  array $config Accepts an details of the mail like to, from body...
	 * @return boolean       Mail sending status.
	 */
	public static function sendMail($config) {
		if(!empty($config) && !empty($config['to']) && !empty($config['subject']) && !empty($config['body'])) {
			Yii::import('application.extensions.yii-mail.YiiMailMessage');
			$message = new YiiMailMessage();
			$message->setTo($config['to']);
			if(empty($config['from'])){
				$message->setFrom(array(Yii::app()->params['adminEmail'] => Yii::app()->params['adminName']));
			} else {
				$message->setFrom($config['from']);
			}
			$message->setSubject($config['subject']);
			$message->setBody($config['body'], 'text/html');
                        
                        if(isset($config['file_path']))
                        {
                            $swiftAttachment = Swift_Attachment::fromPath($config['file_path']); 
                            $message->attach($swiftAttachment);
                        }
                        if (Yii::app()->mail->send($message) > 0) {
				return true;
			}
		}
		return false;
	}

        /**
         * 
         * @param type $length
         * @return \lengthGenerate unique id
         * @param int limit
         * 
         * @return length
         */
	public static function generateUniqueId($length = 10) {
            return substr(md5(uniqid(mt_rand(), true)), 0, $length);
	}

	/**
	 * Returns the array differece, if both the array are differs in any way
	 * @param  Array $arr1 Array1 to compare
	 * @param  Array $arr2 Array2 to compare
	 * @return Boolean Status weather both array are different at any point.
	 */
	public static function arrayDifference($arr1, $arr2){
		if(!count(array_diff($arr1, $arr2)) && !count(array_diff($arr2, $arr1))) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Generates unique name for the images
	 * @param  String $image_name actual name of the Image
	 * @return String New name of the image.
	 */
	public static function generateNewNameOfImage($image_name) {
		$extension = pathinfo($image_name, PATHINFO_EXTENSION);
		$name = md5(uniqid(microtime(), true));
		return $name.".".strtolower($extension);
	}

	/**
	 * Function to generate resize the images based on passed resolutions
	 * @param  string $inputFilePath  abs input file path
	 * @param  string $inputFileName  file name
	 * @param  string $outputFilePath abs output file path
	 * @param  string $outputFileName file name
	 * @param  array  $options        array of dimenstions
	 */
 	public static function generateResizeImage($inputFilePath, $inputFileName, $outputFilePath, $outputFileName, $options) {
		Yii::import('application.extensions.EWideImage.EWideImage');
		$inputImage = $inputFilePath."/".$inputFileName;
		$outputImage = $outputFilePath."/".$outputFileName;
		$extension = pathinfo($inputImage, PATHINFO_EXTENSION);
		$quality = (strtolower($extension)=='png') ? 9 : 90;
		list($imageWidth, $imageHeight) = getimagesize($inputImage);
		if(is_array($options) && !empty($options)) {
			foreach($options as $key => $value) {
				$imageSize = array();
				$imageSize = explode('_', $value);
				$imageSizeNew = $imageSize;
				if(!is_dir($outputFilePath."/".$value)) {
					mkdir($outputFilePath."/".$value, 0777,true);
				}
				if( ($imageWidth==$imageSize[0])  && ($imageHeight==$imageSize[1])){	
					$cpSrc = $_SERVER['DOCUMENT_ROOT'].'/'.$inputFilePath.$inputFileName;
					$cpDes = $_SERVER['DOCUMENT_ROOT'].'/'.$outputFilePath."/".$value."/".$inputFileName;
					copy($cpSrc,$cpDes);
				}else{
					EWideImage::load($inputImage)->resize($imageSizeNew[0], $imageSizeNew[1], 'inside', 'down')->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
				}	
			}
		}
	}

	public static function generateCropImage($inputFilePath, $inputFileName, $outputFilePath, $outputFileName, $options) {
		try{
			Yii::import('application.extensions.EWideImage.EWideImage');
			$inputImage = $inputFilePath."/".$inputFileName;
			$outputImage = $outputFilePath."/".$outputFileName;
			$extension = pathinfo($inputImage, PATHINFO_EXTENSION);
                        
			$quality = (strtolower($extension)=='png') ? 9 : 90;
			list($imageWidth, $imageHeight) = @getimagesize($inputImage);
                        
			if($imageWidth && $imageHeight){
				if(is_array($options) && !empty($options)) {
					foreach($options as $key => $value) {
						$imageSize = array();
						if(!is_dir($outputFilePath."/".$value)) {
							mkdir($outputFilePath."/".$value, 0777,true);
                                                        chmod($outputFilePath."/".$value, 0777);
						}
						$imageSize = explode('_', $value);
						
						if( ($imageWidth==$imageSize[0])  && ($imageHeight==$imageSize[1])){	
							$cpSrc = $_SERVER['DOCUMENT_ROOT'].'/'.$inputFilePath.$inputFileName;
							$cpDes = $_SERVER['DOCUMENT_ROOT'].'/'.$outputFilePath."/".$value."/".$outputFileName;
							copy($cpSrc,$cpDes);
						}else{
							//EWideImage::load($inputImage)->crop('center', 'center', $imageSize[0], $imageSize[1])->saveToFile($outputFilePath."/".$value."/".$inputFileName, $quality);
							EWideImage::load($inputImage)->resize($imageSize[0], $imageSize[1], 'outside')->crop("center", "center", $imageSize[0], $imageSize[1])->saveToFile($outputFilePath."/".$value."/".$outputFileName , $quality);
						}
                                                chmod($outputFilePath."/".$value."/".$outputFileName, 0777);
					}
				}
			}
		}catch(Exception $e) {
		  error_log(print_r($e->getMessage(), true));
		}	
	}
	 
	public static function logMessage($message, $logLevel, $category) {
		$micro_date = microtime(true);
		$date_array = explode(".", $micro_date);
		$date = date("Y-m-d H:i:s", $date_array[0]) . "." . isset($date_array[1])  && !empty($date_array[1]) ? $date_array[1] : "";
		Yii::log("[$date] ".$message, $logLevel, $category);
	}
	
 	public static function generateResizeImageHomeSlider($inputFilePath, $inputFileName, $outputFilePath, $outputFileName, $options) {
		Yii::import('application.extensions.EWideImage.EWideImage');
		$inputImage = $inputFilePath."/".$inputFileName;
		$outputImage = $outputFilePath."/".$outputFileName;
		$extension = pathinfo($inputImage, PATHINFO_EXTENSION);
		list($imageWidth, $imageHeight) = getimagesize($inputImage);
		$quality = (strtolower($extension)=='png') ? 9 : 90;
		if(is_array($options) && !empty($options)) {
			foreach($options as $key => $value) {
				$imageSize = array();
				if(!is_dir($outputFilePath."/".$value)) {
					mkdir($outputFilePath."/".$value, 0777,true);
				}
				$imageSize = explode('_', $value);
				//error_log("REQUIRED SIZE: $value");
				$newWidth = $imageSize[0];
				$newHeight = $imageSize[1];
				
				if($imageHeight > $newHeight){	
					//error_log('RESIZING respect to height');			
					EWideImage::load($inputImage)->resize(99999, $newHeight, 'inside', 'down')->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
					$tempInputImage = $outputFilePath."/".$value."/".$inputFileName;
					list($resizedImageWidth, $resizedImageHeight) = getimagesize($tempInputImage);
					//error_log("new image width: $resizedImageWidth  , height: $resizedImageHeight");	
					if($resizedImageWidth >= $newWidth){
						//error_log("crop newly resize image");	
						EWideImage::load($tempInputImage)->crop('center', 'center', $newWidth, $newHeight)->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
					}else{
						//error_log('RESIZING respect to width');			
						EWideImage::load($inputImage)->resize($newWidth,99999, 'inside', 'down')->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
						$tempInputImage = $outputFilePath."/".$value."/".$inputFileName;
						list($resizedImageWidth, $resizedImageHeight) = getimagesize($tempInputImage);
						//error_log("new image width: $resizedImageWidth  , height: $resizedImageHeight");	
						if($resizedImageHeight >= $newHeight){
							//error_log("crop newly resize image");	
							EWideImage::load($tempInputImage)->crop('center', 'center', $newWidth, $newHeight)->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
						}else{
							//error_log("crop original image");	
							EWideImage::load($inputImage)->crop('center', 'center', $newWidth, $newHeight)->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
						}
					}					
				}else{
					if($imageWidth > $newWidth){ // width is more. Crop out the excessive width
						EWideImage::load($inputImage)->crop('center', 'center', $newWidth, $newHeight)->saveToFile($outputFilePath."/".$value."/".$inputFileName , $quality);
					}else{ // width is less then or equal to required image. Dont do anything, just copy the image
						$cpSrc = $_SERVER['DOCUMENT_ROOT'].'/'.$inputFilePath.$inputFileName;
						$cpDes = $_SERVER['DOCUMENT_ROOT'].'/'.$outputFilePath."/".$value."/".$inputFileName;
						copy($cpSrc,$cpDes);
					}
				}
			}
		}
	}

	
	/**
	 * Function to generate random password for the account.
	 * @param  integer $length Password Length.
	 * @return string          Returns generated password.
	 */
	function generatePassword($length=8) {
		$chars='0123456789@#$!()*^{}[]abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$char_length = strlen($chars);
		srand((double)microtime()*1000000);
		for ($i = 0; $i < $length; $i++) {
			$num = rand() % $char_length;
			$password .= $chars[$num];
		}
		return $password;
	}
	/**
	 * Function to generate the count of restaurants and avis (reviews)
	 */
	public static function restoAndAvisCount(){
			
		$array = array();
		$array['restocount'] = Restaurant::Model()->count(array("condition"=>"etat=1"));
		$array['aviscount'] =  RestaurantReviews::Model()->count(array("condition"=>"status!=4"));
		return $array;
	}

	/**
	 * Function to get the Recent Search items
	 */
	public static function getRecentSearchItems(){
		$array = array();	

		$recentSearchDept= RecentSearch::model()->find(array("condition"=>"type=1", "order"=>"datetime DESC", "limit"=>"1"));
		$recentSearchPoi = RecentSearch::model()->find(array("condition"=>"type=3", "order"=>"datetime DESC", "limit"=>"1"));
		$recentSearchCity = RecentSearch::model()->find(array("condition"=>"type=2", "order"=>"datetime DESC", "limit"=>"1"));
		$recentSearchResto= RecentSearch::model()->find(array("condition"=>"type=4", "order"=>"datetime DESC", "limit"=>"1"));
		
		$counter = 0;
		if($recentSearchPoi) {
			$object = Poi::model()->find("id='$recentSearchPoi->object_id'");
			if(!empty($object)){
				$dateDiff = CommonHelper::getDateDifference(date("Y-m-d H:i:s"), $recentSearchPoi->datetime);
				$timeText = CommonHelper::getInterval($dateDiff);
			
				$array[$counter]['keyword'] = $object->name;
				$array[$counter]['url'] = $object->getSearchUrl();
				$array[$counter]['timeText'] = $timeText;
				$counter++;
			}
		}
		if($recentSearchCity) {
			$object = City::model()->find("id='$recentSearchCity->object_id'");
			if(!empty($object)){
				$dateDiff = CommonHelper::getDateDifference(date("Y-m-d H:i:s"), $recentSearchCity->datetime);
				$timeText = CommonHelper::getInterval($dateDiff);
					
				$array[$counter]['keyword'] = $object->name;
				$array[$counter]['url'] = $object->getSearchUrl();
				$array[$counter]['timeText'] = $timeText;
				$counter++;
			}
		}
		if($recentSearchDept) {
			$object = Department::model()->find("id='$recentSearchDept->object_id'");
			if(!empty($object)){
				$dateDiff = CommonHelper::getDateDifference(date("Y-m-d H:i:s"), $recentSearchDept->datetime);
				$timeText = CommonHelper::getInterval($dateDiff);
					
				$array[$counter]['keyword'] = $object->name;
				$array[$counter]['url'] = $object->getSearchUrl();
				$array[$counter]['timeText'] = $timeText;
				$counter++;
			}
		}
		if($recentSearchResto) {
			$object = Restaurant::model()->find("id='$recentSearchResto->object_id'");
			if(!empty($object)){
				$dateDiff = CommonHelper::getDateDifference(date("Y-m-d H:i:s"), $recentSearchResto->datetime);
				$timeText = CommonHelper::getInterval($dateDiff);
					
				$array[$counter]['keyword'] = $object->restaurant_name;
				$array[$counter]['url'] = $object->setRestUrl();
				$array[$counter]['timeText'] = $timeText;
				$counter++;
			}
		}
		
		return $array;
	}

	/**
	 * Function to get the Recent Search items
	 */
	public static function getDateDifference($date1, $date2){
		$array = array();	
		$date1 = new DateTime($date1);
   		$date2 = new DateTime($date2); 
		$interval = $date1->diff($date2); 
		$array['y'] =  $interval->y;
		$array['m'] =  $interval->m;
		$array['d'] =  $interval->d;
		$array['h'] =  $interval->h;
		$array['i'] =  $interval->i;
		$array['s'] =  $interval->s;
		$array['type']= ( $interval->invert ? ' n' : 'p' );
		return $array;
	}
	
	public static function getInterval( $interval )
	{
		if ( $interval['y'] >= 1 ){ return ($interval['y']==1) ? $interval['y'].' year' : $interval['y'].' years';}
		if ( $interval['m'] >= 1 ){ return ($interval['m']==1) ? $interval['m'].' mois' : $interval['m'].' mois';}
		if ( $interval['d'] >= 1 ){ return ($interval['d']==1) ? $interval['d'].' jour' : $interval['d'].' jours';}
		if ( $interval['h'] >= 1 ){ return ($interval['h']==1) ? $interval['h'].' hour' : $interval['h'].' hours';}
		if ( $interval['i'] >= 1 ){ return ($interval['i']==1) ?  $interval['i'].' minute' :  $interval['i'].' minutes';}
		return ($interval['s']==1) ?  $interval['s'].' second' :  $interval['s'].' seconds';
		
		
	}


	/**
	 * Function to generate the count of menus, photos, vid�os, promotions, critiques, articles
	 */
	public static function menuPhotoAndOtherCount(){
			
		$array = array();
		//$array['menucount'] = Restaurant::model()->count(array("condition"=> "etat=1 AND srv_menu_description IS NOT NULL AND srv_menu_description!=''"));
		$array['menucount'] = RestaurantMenu::model()->count("id");
		$array['photocount'] = RestaurantPhoto::model()->count("id");
		$array['videocount'] = RestaurantVideos::model()->count("id");
		$array['promotioncount'] =  RestaurantPromotion::model()->count("id");
		$array['articlecount'] = Article::model()->count(array("condition"=>"status=1"));	
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.status=1");
		$criteria->join = ' LEFT JOIN article_categories AC ON AC.article_id  = t.id ';
		$criteria->addCondition(" AC.category_id = '6'");
		$array['critiquecount'] =  Article::model()->count($criteria);
		return $array;
	}

	/**
	 * Function to generate the regionsAndRestros
	 */
	public static function regionsAndRestros(){
			
		//$array = array();
		//$array= Region::Model()->FindAll();
		$Criteria = new CDbCriteria;
		$Criteria->join .= 'INNER JOIN cities b ON b.id = t.city_id ';
		$Criteria->join .= 'INNER JOIN departments c ON c.code = b.dept_code ';
		$Criteria->join .= 'INNER JOIN regions d ON d.id = c.region_id  ';
		$Criteria->group = 'd.id';
		$Criteria->select = 'd.slug as regionSlug ,d.id ,d.name as regionName, COUNT( t.restaurant_name ) AS NBResPerRegion ';
		$result = Restaurant::model()->findAll($Criteria);
		return $result;
	}
	
	public static function getActiveArticleRegions(){
		$returnArray = array();
		
		$Criteria = new CDbCriteria;
		$Criteria->addCondition('t.id != -1');
		$Criteria->select = 't.id, t.name, t.slug ';
		$results = Region::model()->findAll($Criteria);
		foreach($results as $result){
			$temp =array();
			$temp['region_id'] = $result->id;
			$temp['region_name'] = $result->name;
			$temp['region_slug'] = $result->slug;
			$temp['region_url'] =  $result->getUrlForArticle();
			$temp['articles'] = array();
			$Criteria = new CDbCriteria;
			$Criteria->join .= 'INNER JOIN article_regions ar ON ar.article_id = t.id ';
			$Criteria->condition = " t.status=1 AND (ar.region_id=$result->id)";
			$Criteria->select = 't.id, t.title, t.slug';
			$temp['article_count'] =  Article::model()->count($Criteria);
			$Criteria->order = ' t.date_of_creation DESC';
			$Criteria->limit = 10;
			$articles = Article::model()->findAll($Criteria);
			foreach($articles as $article){
				$articleArray = array();
				$articleArray['id']  = $article->id;
				$articleArray['title']  = $article->title;
				$articleArray['slug']  = $article->slug;
				$articleArray['url']  = $article->getArticleUrl($article->id);
				$temp['articles'][] = $articleArray;
			}
			$returnArray[] = $temp;
		}
		
		return $returnArray;
	}
	
	public static function departmentsAndRestros(){
			
		//$array = array();
		//$array= Region::Model()->FindAll();
		$Criteria = new CDbCriteria;
		$Criteria->join .= 'INNER JOIN cities b ON b.id = t.city_id ';
		$Criteria->join .= 'INNER JOIN departments d ON d.code = b.dept_code ';
		//$Criteria->join .= 'INNER JOIN regions d ON d.id = c.region_id  ';
		$Criteria->addCondition("d.id!=-1");
		$Criteria->group = 'd.id';
		$Criteria->select = 'd.slug as regionSlug ,d.id ,d.name as regionName, COUNT( t.restaurant_name ) AS NBResPerRegion ';
		$result = Restaurant::model()->findAll($Criteria);
		return $result;
	}
	
	public static function getPopularCitiesWithRestoCount($limit=20){
		$sql="SELECT C.id,C.name,C.slug,COUNT(R.id) as restoCount FROM cities C,restaurants R WHERE C.id=R.city_id AND C.status=1 GROUP BY C.id ORDER BY restoCount DESC limit $limit";
		$cities=Yii::app()->db->createCommand($sql)->queryAll(); 	
		return $cities;
	}

	public static function getPOIWithRestoCount($limit=10){
		$sql="SELECT P.id,P.name,P.slug,P.image, P.lat, P.lon, P.dpt FROM poi P ORDER BY property DESC limit $limit"; 
		$pois=Yii::app()->db->createCommand($sql)->queryAll(); 	
		return $pois;
	}

	public static function popularCity($limit = 12){
			
		$criteria = new CDbCriteria;
		$criteria->condition = '(`property` = 1 OR `property` =  3) AND status = 1';
		$criteria->limit = "$limit";
		$city = City::model()->findAll($criteria);
		return $city;
			
	}
	public static function popularPoi($limit = 10) {
		$criteria = new CDbCriteria;
		$criteria->condition = '(`property` = 1 OR `property` =  3)';
		$criteria->limit =  "$limit";
		//$criteria->order = ' RAND()';
		$poi = Poi::model()->findAll($criteria);
		return $poi;
			
	}
	
	public static function getPopularPoiInDepartment($poi, $limit) {
		$criteria = new CDbCriteria;
		$criteria->condition = '(`property` = 1 OR `property` =  3) AND (`dpt` = '.$poi->dpt.') AND (`id` != '.$poi->id.')';
		$criteria->order = ' RAND()';
		$criteria->limit =  "$limit";
		$pois = Poi::model()->findAll($criteria);
		return $pois;
	}
	
	public static function getClosestPoi($poi, $limit) {
		$colsestPois = Poi::model()->findAll(array("select"=>"*,get_distance($poi->lat,$poi->lon, lat,lon) as distance", "condition" => "id!=".$poi->id." && dpt!='all'", "limit"=>"$limit", "order"=>"distance ASC"));
		return $colsestPois;
	}

	public static function getFeaturedCategories(){		
		$Criteria = new CDbCriteria;
		$Criteria->addCondition("is_featured=1");
		$Criteria->limit = 6;
		//$results=Category::model()->with(array("articleCategories.article"=>array("condition"=>"article.status=1 AND article.popular=1","order"=>"article.date_of_creation DESC","limit"=>4)))->findAll($Criteria);
		$results=Category::model()->findAll($Criteria);
		return $results ;			
	}
	
	public static function getTotalRestaurantCountForTag($searchForm, $tagIds, $type) {
		if($searchForm) {
			if($type == "CUISINE") {
				CommonHelper::resetOtherCriteria($searchForm);
				$searchForm->cuisine = $tagIds;
			} else if($type == "AMBIANCE") {
				CommonHelper::resetOtherCriteria($searchForm);
				$searchForm->ambiance = $tagIds;
			} else if ($type == "BOTH") {
				CommonHelper::resetOtherCriteria($searchForm);
				$tags = explode("," ,$tagIds);
				$searchForm->cuisine = $tags[0];
				$searchForm->ambiance = $tags[1];
			}
			return $searchForm->getRestaurantData(0,0,true);
		}
		return 0;
	}
	
	public static function resetOtherCriteria($searchForm) {
		if($searchForm->search_name == "USER_GEO_LOC") { //Proximity. 
			//Do not clear user lat long
			//Clear the search Types
			$searchForm->search_id = "";
			$searchForm->search_name = "";
			$searchForm->search_type = "";
			$searchForm->hasresults = "";
		} else {
			//Clear lat long
			$searchForm->latitude = "";
			$searchForm->longitude = "";
		}
		
		$searchForm->search_by_map = "";
		$searchForm->cuisine = "";
		$searchForm->ambiance = "";
		$searchForm->distance = "";
		$searchForm->min_price = "";
		$searchForm->max_price = "";
		$searchForm->openinghours = "";
		$searchForm->district = "";
		$searchForm->openinghours_date = "";
		$searchForm->openinghours_time = "";
		$searchForm->options = "";
		$searchForm->budget = "";
		$searchForm->rating = "";
		$searchForm->order = "";
		
		return $searchForm;
	}

	public static function getCategories(){
		return Category::model()->findAll();
	}
	
	public static function usersInfo(){
			
		$Criteria = new CDbCriteria;
		$Criteria->limit = '3';
		$userInfo =  User::Model()->findAll($Criteria);
		return $userInfo ;
	}

	public static function getArticlesByCategoryId($category_id=1, $limit=10){
		$articles=array();
		if($category_id){
			$Criteria = new CDbCriteria;
			$Criteria->together = true; 
			$Criteria->addCondition("t.status = 1");
			$Criteria->addCondition("t.popular = 1");
			$Criteria->with = array('articleCategories');
			$Criteria->addCondition("articleCategories.category_id = ".$category_id);
			$Criteria->order = 't.date_of_creation DESC';
			$Criteria->limit=$limit;
			$articles = Article::model()->findAll($Criteria);
		}
		return $articles;
	}
	
	public static function getLatestArticles($limit)
	{
		$articles = Article::model()->findAll("t.status=1 order by date_of_creation DESC limit $limit");
		return $articles;
	}
	public static function getLatestNews($limit=11)
	{
		$articles = Article::model()->findAll("t.status=1 AND t.news=1 order by date_of_creation DESC limit $limit");
		return $articles;
	}

	public static function getNewsCategoryLink()
	{
		$newCatLink = ''; 
		$newsCategory  = Category::model()->find("t.name like '%news%'");
		if(!empty($newsCategory)){
			$newCatLink = $newsCategory->getUrlForArticle();
		}
		return $newCatLink;
	}
	
	public static function getNewsCategory()
	{
		$newsCategory  = Category::model()->find("t.name like '%news%'");
		return $newsCategory;
	}

		
	public static function promoSource(){
		$result=PromotionSource::model()->findAll("status=1 AND id!=1 order by id limit 12");
		return $result ;
	}
		
	public static function restroReviews(){
		$result = array();
		
		//version 1
		//$rev5=RestaurantReviews::model()->count(array("condition"=>"status!=4 AND global_rating>=4", "group"=>"restaurant_id"));		
		//$result['rate_high'] = ($avisCount>0)?$rev5/$avisCount *100:0;
		//$result['rate_low'] = ($avisCount>0)?RestaurantReviews::model()->count(array("condition"=>"status!=4 AND global_rating<4", "group"=>"restaurant_id"))/$avisCount *100:0;		
		
		/* version 2 */
		/*$Criteria = new CDbCriteria;
		$Criteria->addCondition("status!=4");
		$Criteria->select = 'round(AVG(global_rating),1) AS rating_average';
		$result['restro_ratings'] = RestaurantReviews::model()->findAll($Criteria);
		$avisCount=RestaurantReviews::model()->count(array("condition"=>"status!=4"));
		$result['avis_count'] = $avisCount;
		
		$sql = "SELECT count(distinct(restaurant_id)) FROM `restaurant_reviews` where status!=4";
		$uniqueRestoCount=Yii::app()->db->createCommand($sql )->queryScalar();
		
		$sql = "SELECT count(*) from (SELECT restaurant_id FROM `restaurant_reviews` where status!=4 group by restaurant_id having round(AVG(global_rating),1)>=4) as T";
		$rev5=Yii::app()->db->createCommand($sql )->queryScalar();
		$result['rate_high'] = ($uniqueRestoCount>0)?$rev5/$uniqueRestoCount *100:0;
		
		$sql = "SELECT count(*) from (SELECT restaurant_id FROM `restaurant_reviews` where status!=4 group by restaurant_id having round(AVG(global_rating),1)<4) as T";
		$rev3=Yii::app()->db->createCommand($sql )->queryScalar();
		$result['rate_low'] = ($uniqueRestoCount>0)?$rev3/$uniqueRestoCount *100:0;*/		
		
		//version 3
		$sql = "SELECT ROUND(AVG(R.average_rating),1) FROM restaurants R where R.average_rating>0";
		$result['restro_ratings'][0]['rating_average'] = Yii::app()->db->createCommand($sql)->queryScalar();
		
		//$avisCount=RestaurantReviews::model()->count(array("condition"=>"status!=4"));
		//$result['avis_count'] = $avisCount;
		
		$sql = "SELECT SUM(R.nb_avis) FROM restaurants R where R.average_rating>0";
		$avisCount = Yii::app()->db->createCommand($sql)->queryScalar();
		$result['avis_count'] = $avisCount;
		
		$sql = "SELECT COUNT(R.id) FROM restaurants R WHERE R.average_rating>0";
		$uniqueRestoCount = Yii::app()->db->createCommand($sql)->queryScalar();
		
		$sql = "SELECT COUNT(R.id) FROM restaurants R WHERE R.average_rating>4";
		$rev5=Yii::app()->db->createCommand($sql )->queryScalar();
		$result['rate_high'] = ($uniqueRestoCount>0) ? round($rev5/$uniqueRestoCount*100) : 0;
		
		$sql = "SELECT COUNT(R.id) FROM restaurants R WHERE  R.average_rating>0 AND R.average_rating<3";
		$rev3=Yii::app()->db->createCommand($sql )->queryScalar();
		$result['rate_low'] = ($uniqueRestoCount>0) ? round($rev3/$uniqueRestoCount *100) : 0;		
		
		return $result ;
	}
	
	public static function formatRating($rating){
		$rating = number_format($rating, 1, ',', ' ');
		$parts = explode(",", $rating);
		if(!(isset($parts[1]) && $parts[1]>0)){
			$rating = $parts[0]; 
		}
		return $rating;
	}

	public static function getRatingCssBackground($params){
		$result = '';
		$rating = isset($params['rating']) ? $params['rating'] : 0 ;
		$type = isset($params['type']) ? $params['type'] : 'css' ;  // type = css or image
		$parts = explode(".", $rating);
		if(isset($parts[1]) && $parts[1]>=5){$parts[0] = $parts[0]+1;}
		
		// if rating is less then 1, set it to default 1
		if($parts[0]<1){
			$parts[0]=1;
		}		
		
		if( $parts[0]>5){$parts[0]=5;}
		
		if($type=='number'){
			$result = $parts[0];
		} elseif($type=='image') {
			$result =  '/images/retina/pinmap'.$parts[0].'.png';
		} elseif($type=='bgcolor') {
			$result = 'avis'.$parts[0];
		} else {
			$result = 'ratingBig'.$parts[0];
		}
		return $result;
	}

	public static function getFormatedRatingHtml($params){
		$result = '';
		$rating = isset($params['rating']) ? $params['rating'] : 0 ;
		$includeMicrodata = isset($params['includeMicrodata']) ? $params['includeMicrodata'] : false ;
		if($rating>0){
			$parts = explode(".", $rating);
			$result = '<p class="ratingBlockWrapper">';
			$result .= ($includeMicrodata==true) ? '<span class="ratingBlock" itemprop="ratingValue" >' : '<span class="ratingBlock">';
			$result .= $parts[0];
			if(isset($parts[1])){
				$result .= '<span class="pointTxt">'. Yii::t("restaurant","key_seperator") . $parts[1]. '</span>';
			}
			$result .= '</span><span>/';
			$result .= ($includeMicrodata==true) ? '<span itemprop="bestRating">5</span>' : '5';
			$result .= '</span></p>';
		}
		return $result;
	}

	
	public static function getRandDepartments($id, $RestoCount)
	{
		$depart=Department::model()->findAll("region_id='$id'");
		$html='<ul>';
		foreach($depart as $data){
			$deptUrl = $data->getDeptUrl();			
			$count = isset($RestoCount[$data->id]) ? $RestoCount[$data->id] : 0;
			
			$html.='<li><a href="'.$deptUrl.'">'.$data->name.'</a> <span class="total_counter">('.$count.')</span></li>';
		}			
		return $html.='</ul>'; 
	}
	public static function getDepartments()
	{
		$codes=array("FR-E"=>"6","FR-P"=>"4","FR-Q"=>"11","FR-S"=>"19","FR-O"=>"17","FR-G"=>"8","FR-M"=>"15","FR-A"=>"1","FR-J"=>"12","FR-I"=>"10","FR-D"=>"5","FR-F"=>"7",
		"FR-R"=>"18","FR-T"=>"20","FR-L"=>"14","FR-C"=>"3","FR-V"=>"22","FR-U"=>"21","FR-K"=>"13","FR-N"=>"16","FR-B"=>"2","FR-H"=>"9");
		
		$sql = "SELECT D.id, COUNT(R.id) as restoCount FROM  restaurants R, cities C, departments D where R.etat=1 AND R.city_id = C.id AND C.dept_code=D.code GROUP BY D.id";
		$RestoCount = Yii::app()->db->createCommand($sql)->queryAll();
		$RestoCount= CHtml::listData($RestoCount, 'id', 'restoCount');
		
		foreach($codes as $key=>$value)
		{
			$region=Region::model()->find("id=$value");
			$regionPhoto = $region->getSmallImageUrl();
			$regionRestoCount = $region->getRestaurantCount($region->id);
			$regionReviewCount = $region->getReviewCount($region->id);
			$regionAvgReview = $region->getAvgReviews($region->id);
			$regionRestoCount = number_format($regionRestoCount, 0, ',', ' ');
			$regionReviewCount = number_format($regionReviewCount, 0, ',', ' ');
			$regionAvgReview = CommonHelper::formatRating($regionAvgReview);
			//echo $value;exit;

			$departments[$key]= '<div id="'.$key.'" class="map-tip"><span class="uptip"></span>' . '<div class="vectormapPopupTitle">'.$region->name.'</div><ul class="sub_details"><li><b>'.$regionRestoCount.' </b>restaurants </li><li><b>'.$regionReviewCount .' </b>avis. Moyenne : <span class="counter">'.$regionAvgReview.'/5</span></li></ul><img src="'.$regionPhoto.'" width="250px" height="100px"></img>'.CommonHelper::getRandDepartments($value, $RestoCount).'<span class="arrow"></span></div>';
		}
		$departments['FR-GF']= '<div id="FR-GF" class="map-tip"><span class="uptip"></span>' . '<div class="vectormapPopupTitle">Guiana</div><img src="/images/landmark.png"></img><br/><br/><span class="arrow"></span></div>';
		return $departments;
	}

	public static function promoDeptList(){
		$results = array();
		
		$sql = "SELECT D.id, COUNT(RP.id) as promoCount FROM  restaurants R, cities C, departments D, restaurant_promotions RP where R.city_id = C.id AND C.dept_code=D.code AND RP.restaurant_id=R.id AND R.etat=1 AND RP.promo_end_date >= NOW()  GROUP BY D.id";
		$promoCountResult = Yii::app()->db->createCommand($sql)->queryAll();
		$promoCountArray= CHtml::listData($promoCountResult, 'id', 'promoCount');
		
		$departments = Department::model()->findAll("id != '-1'");
		foreach($departments as $department){
			$temp = array();
			$temp['id'] = $department['id'];
			$temp['code'] = $department['code'];
			$temp['name'] = $department['name'];
			$temp['url'] = $department->getSearchPromoUrl();
			$temp['promoCount'] = isset($promoCountArray[$department->id]) ? $promoCountArray[$department->id] : 0;
			$results[] = $temp;
		}
		
		foreach ($results as $key => $row){
			$arrayCount[$key] = $row['promoCount'];
		}
		array_multisort($arrayCount, SORT_DESC, $results);
		
		return $results;
	}	
	
	public static function districtOptionsFor() {
		//Lyon, Marseille, Paris
		return array(30133,4814,27855);
	}
	 
	public static function districtOptionName($cityId, $districtKey) {
		$district = CommonHelper::districtOptions($cityId);
		if(isset($district[$districtKey])) {
			return $district[$districtKey];
		} else {
			return null;
		}
	}
	
	public static function districtOptions($cityId) {
		if($cityId == 27855) { //Paris
			return array(
					'75001' => '1er',
					'75002' => '2è',
					'75003' => '3è',
					'75004' => '4è',
					'75005' => '5è',
					'75006' => '6è',
					'75007' => '7è',
					'75008' => '8è',
					'75009' => '9è',
					'75010' => '10è',
					'75011' => '11è',
					'75012' => '12è',
					'75013' => '13è',
					'75014' => '14è',
					'75015' => '15è',
					'75016' => '16è',
					'75017' => '17è',
					'75018' => '18è',
					'75019' => '19è',
					'75020' => '20è',
			);
		} else if($cityId == 30133) { //Lyon
			return array(
					'69001' => '1er',
					'69002' => '2è',
					'69003' => '3è',
					'69004' => '4è',
					'69005' => '5è',
					'69006' => '6è',
					'69007' => '7è',
					'69008' => '8è',
					'69009' => '9è',
			);
		} else if($cityId == 4814) { //Marseille
			return array(
					'13001' => '1er',
					'13002' => '2è',
					'13003' => '3è',
					'13004' => '4è',
					'13005' => '5è',
					'13006' => '6è',
					'13007' => '7è',
					'13008' => '8è',
					'13009' => '9è',
					'13010' => '10è',
					'13011' => '11è',
					'13012' => '12è',
					'13013' => '13è',
					'13014' => '14è',
					'13015' => '15è',
					'13016' => '16è',
			);
		} else {
			return null;
		}
	}
	
	public static function avgRatingbyTag(){
		$result = array();
		$Criteria = new CDbCriteria;
		$Criteria->select = 'round(AVG(score),2) AS category_average';
		$result['restro_ratings'] = RestaurantReviews::model()->findAll($Criteria);
		return $result ;
	}

	public static function getHomeSliderData(){
		$images = array();
		$Criteria = new CDbCriteria;
		$Criteria->select = 'id, name, image_alt, link_title, link_url, display_index' ;
		$Criteria->order = 'display_index DESC';
		//$Criteria->addCondition("t.status=1");
		$results = HomepageSliders::model()->findAll($Criteria);
		
		foreach($results as $key => $result){
			$images[$key] = $result->attributes;
			$images[$key]['imgDirPath'] =  '/' . Yii::app()->params['homepageSliderImgUploadDirPath'];
			$images[$key]['photoUrl'] = $result->getHomeSliderPhotoUrl("nd_nd");	
		}
		
		if(empty($images)){
			$temp['id'] = 0;
			$temp['name'] = 'Banner.jpg';
			$temp['imgDirPath'] = '/images/home/'; 
			$temp['photoUrl'] =  '/images/home/0/Banner.jpg';
			$temp['link_url'] = '';
			$temp['link_title'] = '';
			$images[]= $temp;	
		}
		
		return $images;
	}

	public static function getArticleHomeSliderData(){
		$images = array();
		$Criteria = new CDbCriteria;
		$Criteria->addCondition("t.status=1");
		$Criteria->order = "t.position ASC";
		$homeArticles =  ArticleHomeslider::model()->findAll($Criteria);
		if(!empty($homeArticles)) {
			$key = 0;
			foreach($homeArticles as $homeArticle) {
				$images[$key] = $homeArticle->article->attributes;
				$images[$key]['photoUrl'] = $homeArticle->article->getArticlePhotoUrl($homeArticle->article->id, '630_340', null, 0, 1);
				$images[$key]['url'] = $homeArticle->article->getArticleUrl($homeArticle->article->id);
				$key++;
			}
		}
		return $images;
	}
	
	public function loadModelByName($id, $name)
	{
		$model=$name::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public static function formatContactNo($contactNo = null) {
		if(Yii::app()->language == 'en'){
			
			$tempArry  = explode("/", $contactNo);
			if(!isset($tempArry[1])){
				$tempArry  = explode(",", $contactNo);
			}
			
			foreach($tempArry as $key=>$value){
				//if(isset($tempArry[0])){
					$value = preg_replace( '/[^0-9]/', '', $value );
					$value = preg_replace( '/^91/', '0',  $value );
					if($value && !preg_match('/^[0]{1}/', $value)){
						if(strlen($value)>8){
							$value = '0'.$value;
						}
					}
					$tempArry[$key]  = $value;
				//}
			}
			$contactNo =  implode('/ ',$tempArry);
		}
		return $contactNo;
	}
	
	public static function ellipsisText($text, $offset, $byCharLength = false){
		$length = 0;
		/*** explode the string ***/
		$arr = explode(' ', $text);
		/*** check the search is not out of bounds ***/
		if($byCharLength){
			if(strlen($text) > $offset){
				$length = $offset;
			}
		}else{
			switch( $offset )
			{
				case $offset == 0:
					//don't do anything
					break;
			
				case $offset > max(array_keys($arr)):
					//don't do anything
					break;
			
				default:
					$length = strlen(implode(' ', array_slice($arr, 0, $offset)));
			}
		}
		if($length && strlen($text) > $length){
			$text = substr($text, 0, $length);
			$text = substr($text, 0, strrpos($text, ' '))."...";
		}
		return $text;
	}
	
	public static function formatDate($date){
		$dt = strtotime($date);
		return date("d", $dt)." ".Yii::app()->params['months'.Yii::app()->language][date("m", $dt)]." ".date("Y", $dt);
	}
	
	public static function formatTime($time){
		$formattedTime = "";
		$expl = explode(':', $time);
		
		if(isset($expl[0])){
			if($expl[0]<10){
				$expl[0] = substr($expl[0], 1);
			}
			$formattedTime.="$expl[0]h";
		}
		if(isset($expl[1]) && $expl[1]!="00"){
			$formattedTime.="$expl[0]";
		}
		
		return $formattedTime;
	}

	public static function filterLinkUrl($url=''){
		if($url!=''){	
			if ( strpos($url, '.') !== false) {
				if ( strpos($url, 'http://') === false  && strpos($url, 'https://') === false) {
					$url = 'http://'.$url ;
				}
			}
		}
		return $url;
	}
	
	public static function getNewDBConnection($dbOptions){
		$dsn = "mysql:host=$dbOptions[DBHOST];dbname=$dbOptions[DBNAME]";
		return new CDbConnection($dsn, $dbOptions['DBUSER'], $dbOptions['DBPASS']);
	}
	
	public static function getBaseSearchUrlForModel($basePageType, $baseModelId) {
		$searchUrl = "#";
		switch ($basePageType) {
			case SearchUrls::$BASE_PAGE_DEPARTMENT :
				$object = Department::model()->findByPk($baseModelId);
				if($object) {
					$searchUrl = $object->getSearchUrl();
				}
				break;
			case SearchUrls::$BASE_PAGE_CITY :
				$object = City::model()->findByPk($baseModelId);
		
				if($object) {
					$searchUrl = $object->getSearchUrl();
				}
				break;
			case SearchUrls::$BASE_PAGE_POI :
				$object = Poi::model()->findByPk($baseModelId);
				if($object) {
					$searchUrl = $object->getSearchUrl();
				}
				break;
			case SearchUrls::$BASE_PAGE_PROXIMITY :
				$searchUrl = "/recherche-proximite";
				break;
		}
		return $searchUrl;
	}
	
	public static function getDynamicUrlForTag($searchModel, $basePageType, $tagValue) {
		$baseModelId = isset($searchModel->search_id) ? $searchModel->search_id : -1;
		$searchUrl = CommonHelper::getBaseSearchUrlForModel($basePageType, $baseModelId);
		if($searchUrl == "#") {
			return $searchUrl;
		}
		$baseSearchUrl = $searchUrl;
		switch ($basePageType) {
			case SearchUrls::$BASE_PAGE_DEPARTMENT :
				if($tagValue) {
					$searchUrl = $searchUrl."-".$tagValue."-recherche";
				}
				break;
			case SearchUrls::$BASE_PAGE_CITY :
			case SearchUrls::$BASE_PAGE_POI :
			case SearchUrls::$BASE_PAGE_PROXIMITY :
				if($tagValue) {
					$searchUrl = $searchUrl."/".$tagValue;
				}
				break;
		}
		
		return $baseSearchUrl == $searchUrl ? "#" : $searchUrl;
	}
	
	public static function getDynamicUrlWithPromotion($searchModel, $basePageType, $tagId, $caflag = false, $tagValue = null) {
		$searchUrl = "#";
		$baseModelId = isset($searchModel->search_id) ? $searchModel->search_id : -1;
		$searchUrl = CommonHelper::getBaseSearchUrlForModel($basePageType, $baseModelId);
	
		if($searchUrl == "#") {
			return $searchUrl;
		}
		//For Temp
		$searchUrl = str_replace("/restaurant-","RESTO_HIFEN",$searchUrl);
		
		$searchUrl = str_replace("/restaurant","",$searchUrl);
		
		//Revert temp
		$searchUrl = str_replace("RESTO_HIFEN", "/restaurant-",$searchUrl);
		
		return $searchUrl."/reduction-promo-restaurant";
	}
	
	public static function getDynamicUrlWithTags($searchModel, $basePageType, $tagId, $caflag = false, $tagValue = null) {
		$searchUrl = "#";
		$baseModelId = isset($searchModel->search_id) ? $searchModel->search_id : -1;
		$searchUrl = CommonHelper::getBaseSearchUrlForModel($basePageType, $baseModelId);
		
		if($searchUrl == "#") {
			return $searchUrl;
		}
		$baseSearchUrl = $searchUrl;
		//Found Base URL
		$paramString = CommonHelper::getParamString($searchModel, $tagId, $tagValue, $caflag);
		switch ($basePageType) {
			case SearchUrls::$BASE_PAGE_DEPARTMENT :
				if($paramString) {
					$searchUrl = $searchUrl."-".$paramString."-recherche";
				}
				break;
			case SearchUrls::$BASE_PAGE_CITY :
			case SearchUrls::$BASE_PAGE_POI :
			case SearchUrls::$BASE_PAGE_PROXIMITY :
				if($paramString) {
					$searchUrl = $searchUrl."/".$paramString;
				}
				break;
		}
		
		return $baseSearchUrl == $searchUrl ? "#" : $searchUrl;
	}
	
	public static function getParamString($searchModel, $tagId, $tagValue, $caFlag) {
		//Avis
		$paramStringArr = array();
		if($tagId == SearchUrls::$TAG_AVIS) {
			$paramStringArr[] = "avis";
		}
		//Reservation
		if($tagId == SearchUrls::$TAG_RESERVATION) {
			$paramStringArr[] = "reservation";
		}
		//Promotion
		if($tagId == SearchUrls::$TAG_PROMOTION) {
			$paramStringArr[] = "promotion";
		}
		
		//Cuisine
		$addCusine = false;
		if(isset($searchModel->cuisine) && !empty($searchModel->cuisine)) {
			$cuisineArray = explode(",", $searchModel->cuisine);
			if(sizeof($cuisineArray) > 1) {
				//Do Nothing
			} elseif(sizeof($cuisineArray) == 1) {
				if(isset($searchModel->ambiance) && !empty($searchModel->ambiance)) {
					$ambianceArray = explode(",", $searchModel->ambiance);
					if(sizeof($ambianceArray) >= 1 && $caFlag) {
						//Do Nothing
					} else {
						if($tagId == SearchUrls::$TAG_AMBIANCE) {
							$paramStringArr[] = Cuisine::model()->findByPk($cuisineArray[0])->slugs;
						}
						$addCusine = true;
					}
				} else {
					if($tagId == SearchUrls::$TAG_AMBIANCE) {
						$paramStringArr[] = Cuisine::model()->findByPk($cuisineArray[0])->slugs;
					}
					$addCusine = true;
				}
			} else {
				$addCusine = true;
			}
		} else { //No Cusine In thr URL So far
			$addCusine = true;
		}
		if($addCusine && $tagId == SearchUrls::$TAG_CUISINE) {
			$paramStringArr[] = $tagValue;
		}
		
		//Ambiance
		$addAmbiance = false;
		if(isset($searchModel->ambiance) && !empty($searchModel->ambiance)) {
			$ambianceArray = explode(",", $searchModel->ambiance);
			if(sizeof($ambianceArray) > 1) {
				//Do Nothing
			} elseif(sizeof($ambianceArray) == 1) {
				if(isset($searchModel->cuisine) && !empty($searchModel->cuisine)) {
					$cuisineArray = explode(",", $searchModel->cuisine);
					if(sizeof($cuisineArray) >= 1 && $caFlag) {
						//Do Nothing
					} else {
						if($tagId == SearchUrls::$TAG_CUISINE) {
							$paramStringArr[] = Ambiance::model()->findByPk($ambianceArray[0])->slugs;
						}
						$addAmbiance = true;
					}
				} else {
					if($tagId == SearchUrls::$TAG_CUISINE) {
						$paramStringArr[] = Ambiance::model()->findByPk($ambianceArray[0])->slugs;
					}
					$addAmbiance = true;
				}
			} else {
				$addAmbiance = true;
			}
		} else { //No Cusine In thr URL So far
			$addAmbiance = true;
		}
		if($addAmbiance && $tagId == SearchUrls::$TAG_AMBIANCE) {
			$paramStringArr[] = $tagValue;
		}
		
		//Budget
		if($tagId == SearchUrls::$TAG_BUDGET) {
			$paramStringArr[] = "pas-cher";
		}
		//Open
		if($tagId == SearchUrls::$TAG_OPEN) {
			$paramStringArr[] = $tagValue;
		}
		//Photo
		if($tagId == SearchUrls::$TAG_PHOTO) {
			$paramStringArr[] = "photo";
		}
		//Video
		if($tagId == SearchUrls::$TAG_VIDEO) {
			$paramStringArr[] = "video";
		}
		
		//Bon. Avis > 3/5
		if($tagId == SearchUrls::$TAG_BON) {
			$paramStringArr[] = "bon";
		}
		
		//Meilleur. Avis > 4/5
		if($tagId == SearchUrls::$TAG_MEILLEUR) {
			$paramStringArr[] = "meilleur";
		}
		
		$returnParamString = "";
		if(!empty($paramStringArr)) {
			$returnParamString = implode("+", $paramStringArr);
		}
		return $returnParamString;
	}
        
        public static function encryptAndDecrypt($action, $string) {
            $output = false;

            $key = 'My strong random secret key';

            // initialization vector 
            $iv = md5(md5($key));

            if( $action == 'encrypt' ) { 
                
                $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
                 echo $output;exit;
                $output = base64_encode($output);
            }
            else if( $action == 'decrypt' ){
                $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
                $output = rtrim($output, "");
            }
           
            return $output;
         }
  public static function search($value, $model, $columns, $with=array(), $selected="") {
  	$pageSize = Yii::app()->params['defaultPageSize'];
  	if($selected && $selected=="status_active"){
  		$selected="status";$value = 1;
  	}elseif ($selected && $selected=="status_inactive"){
  		$selected="status";$value = 0;
  	}
  	$condition = $selected." like '%".$value."%'";
  	
  	if(!$selected){
  		$condition = "";
  		foreach ($columns as $column){
  			$condition .= " OR ".$column." like '%".$value."%' ";
  		}
  		$condition = substr($condition, 3);
  	}
	  	$criteria=new CDbCriteria(array(
	  			'condition'=>$condition,
	  			'with'=>$with,
	  	));
	  	$dataProvider=new CActiveDataProvider($model, array(
	  			'criteria'=>$criteria,
                                'pagination' => array('pageSize' => $pageSize),
	  	));
	  	return $dataProvider;
  }
  
    /**
     * Get the reservation status
     * 
     * @param type $statusId
     */
    public static function getReservationStatus($statusId) {
        switch ($statusId) {
            case 0:
                echo "In Progress";
                break;
            case 1:
                echo "Confirmed";
                break;
            case 2:
                echo "Waiting For Confirmation";
                break;
            case 3:
                echo "Cancelled By User";
                break;
            case 4:
                echo "Cancelled By Admin";
                break;
            case 5:
                echo "No Show";
                break;
            case 6:
                echo "Cancelled By Hotel";
                break;
            case 7:
                echo "Refused";
        }
    }
    
    /**
     * Get the hotel ids
     * 
     * @param int $userId
     * 
     * @return int
     */
    public static function getHotelByUserId($userId) {
       $hotelObjectList =  HotelAccess::model()->findAll(array('condition' =>'user_id ='. $userId));
       $hotelIdList = '';
       foreach($hotelObjectList as $hotelObject){
          $hotelIdList[] = $hotelObject->hotel_id;
       }
       return $hotelIdList;
    }

}
