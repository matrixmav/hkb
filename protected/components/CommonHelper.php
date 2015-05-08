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

    public static function search($value, $model, $columns, $with=array(), $selected="") {
  	$pageSize = Yii::app()->params['defaultPageSize'];
  	if($selected && $selected=="status_active"){
  		$selected="status";$value = 1;
  	}elseif ($selected && $selected=="status_inactive"){
  		$selected="status";$value = 0;
  	}
  	$condition = $selected." like '%".$value."%'";
  	
  	if(!$selected) {
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


	public static function getCategories(){
		return Category::model()->findAll();
	}
	
	public static function usersInfo(){
			
		$Criteria = new CDbCriteria;
		$Criteria->limit = '3';
		$userInfo =  User::Model()->findAll($Criteria);
		return $userInfo ;
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

}
