<?php

require_once Yii::app()->basePath.'/components/Mobile_Detect.php';

class BaseClass extends Controller {
	
	public static $count_slug=1;
	public $loggedInUser = null;
	public $selectedNavMenu = 1;
	public $randomCategories = null;
	public $dateArr = null;
	public $isMobile = false;
	
    function init() {
        parent::init();
        $detector = new Mobile_Detect;
        $this->isMobile = $detector->isMobile();
        error_reporting(E_ALL);
		//error_reporting(0);
		
        //Set language		
		/*if(Yii::app()->getController()->layout =='//layouts/articles'){			
			Yii::app()->language = 'en';
        }*/
        
        //Get login info
       /* if(Yii::app()->user->getstate('user_id')){
        	
        	require_once (dirname(Yii::app()->request->scriptFile)."/wordpress/wp-load.php");
        	//Session related checks - session timeout
        	$current_time = time();
        	if(Yii::app()->request->isAjaxRequest==false && isset(Yii::app()->session['login_time']) && ($current_time - Yii::app()->session['login_time']) > Yii::app()->session['sess_timeout'])
        	{
        		Yii::app()->session['login_time'] = null;
        		Yii::app()->session['timed_out'] = 1;
        	}
        	
        	//$this->loggedInUser = $this->getUserInfoByEmailId(Yii::app()->user->Id);
        } else {
        	$this->loggedInUser = null;
        	$this->redirect('/admin');
        }*/
    }
    /*
     * method for getting the list of admins
     * 
     */
    function getAdmins() {

        $records = User::model()->findAll(array('condition' => "`role_id` = 1"));
        $adminArr = array();
        foreach ($records as $record) {
            $adminArr[] = $record->email;
        }
        return $adminArr;
    }

    function getAuthors() {

        $records = User::model()->findAll(array('condition' => "`role_id` = 3"));
        $adminArr = array();
        foreach ($records as $record) {
            $adminArr[] = $record->email;
        }
        return $adminArr;
    }

    /*
     * method for getting the access rules based on the uaer role
     */
    function getAccess($userRoleId) {

        //check user role id
    }
 	/**
	 * General function to generate random string
	 * @return string of random Session id for a user.
	 * @author Vinayak Phal
	 */
	public static function generateSessionId( ) {
		return md5(uniqid(microtime(), true));
	}
	
	// print an array in formated way
	public static function pr($param) {
		echo "<pre>";
		print_r($param);
		echo "</pre>";
	}

	public static function uploadFile($sourceFile, $destinationFolder, $destinationFileName) {
    	if (!is_dir($destinationFolder)) {
    		mkdir($destinationFolder, 0755, true);
    	}
    	try {
    		move_uploaded_file($sourceFile, $destinationFolder.$destinationFileName);
    		return $destinationFileName;
    	} catch (Exception $e) {
    		return null;
    	}
    }
    
	public static function generateNewNameOfImage($image_name) {
    	$extension = substr($image_name, strrpos($image_name, '.')+1);
    	$name = md5(date("Y-m-d") * mt_rand());
    	return $name.".".$extension;
    }
    
    
    public static function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
	{
	//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) 
		{
			return false;
		}
	
		//Construct a proportional size of new image
		$ImageScale      	= min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
		$NewWidth  			= ceil($ImageScale*$CurWidth);
		$NewHeight 			= ceil($ImageScale*$CurHeight);
		$NewCanves 			= imagecreatetruecolor($NewWidth, $NewHeight);
	
		// Resize Image
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
		{
			switch(strtolower($ImageType))
			{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
			}
		//Destroy image, frees memory	
		if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
		return true;
		}

	}

//This function corps image to create exact square images, no matter what its original size!
	public static function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
	{	 
	//Check Image size is not 0
		if($CurWidth <= 0 || $CurHeight <= 0) 
		{
			return false;
		}
	
		//abeautifulsite.net has excellent article about "Cropping an Image to Make Square"
		//http://www.abeautifulsite.net/blog/2009/08/cropping-an-image-to-make-square-thumbnails-in-php/
		if($CurWidth>$CurHeight)
		{
			$y_offset = 0;
			$x_offset = ($CurWidth - $CurHeight) / 2;
			$square_size 	= $CurWidth - ($x_offset * 2);
		}else{
			$x_offset = 0;
			$y_offset = ($CurHeight - $CurWidth) / 2;
			$square_size = $CurHeight - ($y_offset * 2);
		}
	
		$NewCanves 	= imagecreatetruecolor($iSize, $iSize);	
		if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
		{
			switch(strtolower($ImageType))
			{
			case 'image/png':
				imagepng($NewCanves,$DestFolder);
				break;
			case 'image/gif':
				imagegif($NewCanves,$DestFolder);
				break;			
			case 'image/jpeg':
			case 'image/pjpeg':
				imagejpeg($NewCanves,$DestFolder,$Quality);
				break;
			default:
				return false;
			}
	//Destroy image, frees memory	
		if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
		return true;

		}
	  
	}
    
    
    /////////////////////////////////SLUG Functions/////////////////////////////////////////////
    
	private static function my_str_split($string) {
		$slen=strlen($string);
		for($i=0; $i<$slen; $i++) {
			$sArray[$i]=$string{$i};
		}
		return $sArray;
	}
	
	private static function noDiacritics($string) {
		//cyrylic transcription
		$cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$cyrylicTo   = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');
	
	
		$from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
		$to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");
	
		$from = array_merge($from, $cyrylicFrom);
		$to   = array_merge($to, $cyrylicTo);
	
		$newstring=str_replace($from, $to, $string);
		return $newstring;
	}
	
	public static function makeSlugs($string, $maxlen=0) {
		$newStringTab = array();
		$string=trim($string);
		$string = strtolower(BaseClass::noDiacritics($string));
		if(function_exists('str_split')) {
			$stringTab = str_split($string);
		} else {
			$stringTab = BaseClass::my_str_split($string);
		}
	
		//$numbers=array("0","1","2","3","4","5","6","7","8","9","-");
		// Added by Sandeep Sen for greater than 9 duplicate entry 
		// 2nd Jan 2014
		$numbers=array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","-");
		
		//$numbers=array("0","1","2","3","4","5","6","7","8","9");
	
		foreach($stringTab as $letter) {
			if(in_array($letter, range("a", "z")) || in_array($letter, $numbers)) {
				$newStringTab[]=$letter;
				//print($letter);
			} elseif($letter==" ") {
				$newStringTab[]="-";
			}
		}
	
		if(count($newStringTab)) {
			$newString=implode($newStringTab);
			if($maxlen>0) {
				$newString=substr($newString, 0, $maxlen);
			}	 
			$newString = BaseClass::removeDuplicates('--', '-', $newString);
		} else {
			$newString='';
		}
	
		return $newString;
	}
	 
	 
	private static function checkSlug($sSlug) {
		if(ereg ("^[a-zA-Z0-9]+[a-zA-Z0-9\_\-]*$", $sSlug)) {
			return true;
		}	
		return false;
	}
	 
	private static function removeDuplicates($sSearch, $sReplace, $sSubject) {
		$i=0;
		do {
			$sSubject=str_replace($sSearch, $sReplace, $sSubject);
			$pos=strpos($sSubject, $sSearch);	 
			$i++;
			if($i>100) {
				die('removeDuplicates() loop error');
			}
		} while($pos!==false);
		
		return $sSubject;
	}
	
	
	public static function Slugunique($model, $name, $id) {
		$slug = BaseClass::makeSlugs($name);
		$addSql = ($id > 0)? " and id!=".$id : "";
		$flag = $model::model()->find("slug='$slug' $addSql");
		if($flag){
			$id = $flag->id;
			if($flag->id != '') {
				$no = substr($slug, strrpos($slug, strrchr($slug, "-")));
				if(is_numeric($no))
					$slug_data = substr($slug, 0, strrpos($slug, "-"));
				else 
					$slug_data = $slug;
				
				$data = $slug_data."-".BaseClass::$count_slug;
				BaseClass::$count_slug++;
			
				$slug = BaseClass::Slugunique($model, $data, $id);
			}
		}
		
		return $slug;
	}
	
	public static function getDays($year){
		
		$num_of_days = array();
		$total_month = 12;
		
		/* if($year == date('Y'))
			$total_month = date('m');
		else
			$total_month = 12; */
	
		for($m=1; $m<=$total_month; $m++){
			$num_of_days[$m] = cal_days_in_month(CAL_GREGORIAN, $m, $year);
		}

		return $num_of_days;
	}

	
	public static function getSlug($model, $string)
	{	
			#$slug=$this->makeSlugs($string);
			#$model=$model;
			$slug=$this->slugCoursesUnique($model,$data,$theme, $cId);
				return $slug;
	}
	public static function removeApos($data)
    {
    		$array_replace1=array("’");
            $array_replace_by1=array("'");
            $data=str_replace($array_replace1, $array_replace_by1, $data);
            return $data;
    }
	public static function createSlug($model)
	{
			$data=$model::model()->findAll("slug IS NULL");
			foreach($data as $dat)
			{	if($model=='Wiki')
				$string=$dat->title;
				else
				$string=$dat->name;
				#$string=trim($string);
				$slug=$this->makeSlugs($string);
				$model=$model;
				$slug=$this->Slugunique($model,$slug, 0);
				$dat->slug=$slug;
				#echo "<br>";
				$dat->save();
			}
	}
	
	public static function getRestUrl($slug)
	{
		return substr($slug,(strrpos($slug, "-")+1));
		
	}
	public static function setRestUrl($id)
	{
		$model=Restaurant::model()->findbyPk($id);
		return $model->url."-".mb_strtolower($model->cities->name)."-".$model->id;
		
	}
	public static function leadmanager($model, $action)
	{
		if(isset($model) && !empty($model))
		{ 
			$fields_string="";
		$noOfPersons=$model->nb_person;
		$type=($model->occasion<14)?2:1;
		$budget=$model->budget;
		$event_date=$model->reservation_time;
		$phone=$model->telephone;
		$email=$model->email;
		$full_name=utf8_encode($model->name);
		$act=Yii::app()->params['leadMap'][$action];
		$form_id=Yii::app()->params['leadmanager'][$act];
			$category=23;
		if($type==2)
			$category=24;
		$company=utf8_encode($model->company);
		$comments=utf8_encode("null");
		
		$url = 'http://leadmanager.fr/index.php?r=leads/create';
		$fields = array(
				'Leads[form_id]' => $form_id,
				'Leads[pax]' => $noOfPersons,
				'Leads[budget]' => $budget,
				'Leads[description]' => $comments,
				'Leads[title]' => $category,
				'Leads[category]' => $category,
				'Leads[contact_person]' => $full_name,
				'Leads[contact_telephone]' => $phone,
				'Leads[contact_email_id]' => $email,
				'Leads[occasion]' => $model->occasion,
				'Leads[website_id]' => '42',
				'Leads[company_name]'=>$company,
				'Leads[event_date]'=>$event_date,
		
		);
		//url-ify the data for the POST
		foreach($fields as $key=>$value) {
			$fields_string .= $key.'='.$value.'&';
		}
		rtrim($fields_string, '&');
		$ch = curl_init();
		#$fields_string=urldecode($str)
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$result = curl_exec($ch);
		#echo "<pre>";print_r($result);echo "</pre>";
		//close connection
		curl_close($ch);
		}
		
	}
	
	function is_bot_detected() {
		//echo $_SERVER['HTTP_USER_AGENT'];exit;
		if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
			return TRUE;
		}else{
			return FALSE;
		}
	}	
	
    /**
     * Generate Unique integer
     * 
     * @param int $limit
     * @return int
     */
    public static function getUniqInt($limit = 6){
        $randNumber = substr(number_format(time() * rand(),0,'',''),0, $limit);
        return $randNumber;
    }
    
    public static function getHotelLimit($count){
        if($count == 1){
            return 5;
        } elseif($count == 2) {
            return 4;
        } else {
            return 6;
        }
    }
    
    public static function isCustomerFieldDataExisted($field1, $Value1){
        $customreObject = Customer::model()->findByAttributes(array($field1 => $Value1),'is_subscribed=1');
        if($customreObject){
            return TRUE;
        } else {
            return false;
        }
        
    }
    /**
     * formate date
     * 
     * @param date $date
     * @return date
     */
    public static function convertDateFormate($date) {
        $inputDate = new DateTime($date);
        $fromtime1 = $inputDate->format('h:iA');
        $fromtime = $inputDate->format('h:i A');
        $explodeInputDate = explode(":",$fromtime);
         if($explodeInputDate[1] == "00 AM" || $explodeInputDate[1] == "00 PM")
        {
              $explodesecond = explode(" ",$explodeInputDate[1]);
              $fromtime1 = $explodeInputDate[0].$explodesecond[1];
        }
        return $fromtime1;
    }
    public static function breakDateFormate($date) {
        $inputDate = new DateTime($date);
        $fromtime = $inputDate->format('h:i:a');
        
        return $fromtime;
    }
    /**
     * calculate Percentage
     * 
     * @param int $value1
     * @param int $value2
     * @return int
     */
    public static function getPercentage($value1, $value2 , $flag=0){
        if($flag){
            if(($value1!=0 && $value1!='') && ($value2!=0 && $value2!='')) {
               return $percentage = ($value1 * $value2) / 100;
            } else {
                return 0;        
            }
            return $percentage = substr((($value1 / $value2)*100),0,2);
        }else {
            if(($value1!=0 && $value1!='') && ($value2!=0 && $value2!=''))
               return $percentage = substr((($value1 / $value2)*100),0,2);
            else 
                    return 0;        
            return $percentage = substr((($value1 / $value2)*100),0,2);
        }
        
    }
    
    public static function getReCaptcha(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 5; $i++) 
        {
            $randomString .= $chars[rand(0, strlen($chars)-1)];
        }	
        $_SESSION['captcha'] = strtolower( $randomString );
        return $_SESSION['captcha'];
    }
    
    /**
     * Send SMS
     * 
     * @param number $toNumber
     * @param string $message
     * @return response
     */
    public static function sendSMS($toNumber, $message){ 
        //echo $toNumber;
        $api_key = Yii::app()->params['smsConfig']['api_key'];
        $api_secret = Yii::app()->params['smsConfig']['api_secret'];
        $from = Yii::app()->params['smsConfig']['from'];
        $apiUrl = Yii::app()->params['smsConfig']['apiUrl'];
        $message = urlencode($message);
        //constructing url
        $url = $apiUrl."$api_key&api_secret=$api_secret&from=$from&to=$toNumber&text=$message";
        $smsResponse = Yii::app()->curl->run($url);
        return json_decode($smsResponse);
    }
    
    public static function md5Encryption($data){
        return md5($data);
    }

    
    public static function currencyConvert($from, $to, $amo11)
    {
        // process API and convert
        //$currency = json_decode(file_get_contents('http://rate-exchange.appspot.com/currency?from=' . $from . '&to=' . $to));
        //return number_format(($currency->rate * $amount), 2, '.', '');
    }
    
    public static function getmenusections($emailadd)
    { //echo Yii::app()->user->getState('username');exit;
        $result['sections'] = array();
        $result['psections'] = array();
        $result['section_url']=array();
        $result['section_ids']=array();
        $result['section_rurl']=array();
        
        
        if($emailadd== "")
        {
            echo "You have been logged out. <a href='/admin'>242424Click here to login again.</a>";
            $adURL = Yii::app()->params['AdminDir'];
            $this->redirect('/'.$adURL.'/default/logout');
            
        }

        $user = AdminUser::model()->find("email_address='".$emailadd."'");
        if($user->type=='dayuse')
        {
            $cat = AduserCataccess::model()->find("aduser_id=".$user->id);
            if($cat!=NULL)
            {
                $section = SectionAccess::model()->findAll("category_id=".$cat->category_id);
                foreach ($section as $ky=>$sec)
                {
                    $secname = AdminSection::model()->find("id=".$sec->section_id);
                    array_push($result['psections'], $secname->parent_section_id);
                    array_push($result['sections'], $secname->section_name);
                    array_push($result['section_url'], $secname->section_url);

                    if($secname->section_url!=NULL)
                        array_push($result['section_rurl'], $secname->section_url);

                    array_push($result['section_ids'], $secname->id);

                }
                $result['psections'] = array_unique($result['psections']);
            }
        }
        return $result;
    }
    
    public static function getadminImg($emailadd)
    {
        if($emailadd== "")
        {
            echo "You have been logged out. <a href='/admin'>Click here to login again.</a>";
            $adURL = Yii::app()->params['AdminDir'];
            $this->redirect('/'.$adURL.'/default/logout');
            
        }
        $adimg = array();
        
        $user = AdminUser::model()->findAll("login_status=1 and type='dayuse'");
        if($user != NULL)
        {
            foreach($user as $ky=>$us)
            {
                $str = $us->user_icon.":".$us->first_name;
                array_push ($adimg, $str);
            }
        }
        
        return $adimg;
        
    }
  
    public static function manager_redirect($manager_id)
    {
        $return_url = Yii::app()->params['manager_homeUrl'];
        // check the manager has any contract review pending or not
        $hotel_access = HotelAccess::model()->findAll("user_id=".$manager_id);
        if($hotel_access!=NULL)
        {
            foreach ($hotel_access as $ky=>$acc):
                // check any of the hotel contract_status is 0
                $hotel = Hotel::model()->find("id=".$acc->hotel_id);
                               
                if($hotel->contract_status==0)
                {
                    // set the session for the contract id
                    Yii::app()->user->setState('contract_hotel_id',$acc->hotel_id);

                    // Redirect to the contract page
                    $return_url = '/hotel/contract';
                }
            endforeach;
        }
        
        return $return_url;
    }
   
    public static function getCountryCode(){
        return $countryObject =  Country::model()->findAll(array("order" => "iso_code ASC",));
    }
    public static function getCountryDropdown()
    {
        $country_info  = array();
        $dcrit ="";
        $i=0;
        //US should come first and then the other country should come in alphabetical order
        $default_country = YII::app()->params['default']['countryId'];
        $dcountry = Country::model()->findByPk($default_country);
        if($dcountry!=NULL)
        {
            $i++;
            $country_info[$i]['id']=$dcountry->id;
            $country_info[$i]['name']=$dcountry->name;
            $country_info[$i]['slug']=$dcountry->slug;
            $country_info[$i]['iso_code']=$dcountry->iso_code;
            $country_info[$i]['country_code']=$dcountry->country_code;
            $country_info[$i]['flag_name']=$dcountry->flag_name;
            $dcrit = " and id!=".$default_country;
        }
        $criteria = new CDbCriteria();
        $criteria->condition = "status =1".$dcrit;
        $criteria->order ="iso_code ASC";
                
        $country = Country::model()->findAll($criteria);
        if($country!=NULL)
        {
            foreach ($country as $cn):
                $i++;
                $country_info[$i]['id']=$cn->id;
                $country_info[$i]['name']=$cn->name;
                $country_info[$i]['slug']=$cn->slug;
                $country_info[$i]['iso_code']=$cn->iso_code;
                $country_info[$i]['country_code']=$cn->country_code;
                $country_info[$i]['flag_name']=$cn->flag_name;
            endforeach;
        }
        
        return $country_info;
        
    }


    public static function getlastDate($month,$year)
    {
        $last_day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        return $last_date = $year."-".$month."-".$last_day;
    }
    
    public static function downloadFile($outputFilePath) {

        header('Content-Description: File Transfer');

        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // force download dialog
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream', false);
        header('Content-Type: application/download', false);
        header('Content-Type: application/pdf', false);
        // use the Content-Disposition header to supply a recommended filename
        header('Content-Disposition: attachment; filename="' . basename($outputFilePath) . '";');
        header('Content-Transfer-Encoding: binary');
        ob_clean();
        flush();
        readfile($outputFilePath);
    }

    public static function getSelectedArrTime($arrTime){
        $arrTimeArray = explode(":", $arrTime);
        $hotelArrivalTimeArray = Yii::app()->params['hotelArrivalTimeKeyValue'];
        foreach($hotelArrivalTimeArray as $key => $arrTime){
            if($arrTimeArray[0] == $key){
                return $arrTime;
                break;
            }
        }
    }
    
    public static function createArrivalArray($toTime, $fromTime){
        $toTime = date("G", strtotime($toTime));
        $fromTime = date("G", strtotime($fromTime));
        $arrayTime = array();
        $toTime = ($toTime-1);
        $fromTime = ($fromTime-1);
        $j = $toTime;
        for($i = $toTime; $i<$fromTime; $i++){
            $j++;
            $toTimeFormate = date("G:i", strtotime($i));
            $fromTimeFormate = date("G:i", strtotime($j));
            $arrayTime[$i] = date("gA", strtotime($i.":00"))." - ".date("gA", strtotime($j.":00"));
        }
        return $arrayTime;
    }
    
    public static function convertTime($time){
        //return date("G:i A", strtotime($time));
        return date("g:i A", strtotime($time));        
    }
    
    public static function convertStandardDateFormate($originalDate){
        return $newDate = date("d/m/Y", strtotime($originalDate));
    }
    
    public static function getRoomReservation($room_id,$hotel_id,$arrtime1,$bkdate,$adminsection=0)
    {
        $return = array();
        $orf = 0;
        
        $room_status_color = Yii::app()->params->room_status_color;
        $room_status = Yii::app()->params->room_status;
        
        $criteriaroom = new CDbCriteria();
        $criteriaroom->addColumnCondition(array('room_id' => $room_id, 'res_date' =>$bkdate));
        $criteriaroom->addInCondition('reservation_status',array(1,2)); 
        $checkroomreservation = Reservation::model()->count($criteriaroom);
        $availability = RoomAvailability::model()->findByAttributes(array('room_id' => $room_id, 'availability_date' => $bkdate));

        $reservedrooms = $checkroomreservation;
        $allroomavailable = $availability->nb_rooms;
        $roomcount = $allroomavailable - $reservedrooms; //Return value
        
        $return['roomcount'] = $roomcount;
        //Rooms :  $roomcount/$allroomavailable |
        $createurl = FALSE;
        //If Room status is free sale no need to check anything it will be always available
        if($availability->room_status == "free_sale")
        {
            $roomclass = "";
            $roombutton = "book now";
            $orf = 0;
            $createurl = TRUE;
            $admin_roomclass = "green";
            $admin_roombutton = "Book now";
            $room_no_stat = "";
            $rmcolor = $room_status_color[$availability->room_status];
            $rmstatus = $room_status[$availability->room_status];
            
        }
        else
        {
            if($availability->room_status == "closed")
            {
                $roomclass = "notAvailable";
                $roombutton = "closed";
                $admin_roomclass = "notAvailable";
                $admin_roombutton = "Closed";
                $admin_rowColor = $room_status_color['closed'];
                $room_no_stat = "";
                $rmcolor = $room_status_color[$availability->room_status];
                $rmstatus = $room_status[$availability->room_status];
            }
            else
            {
                //Rooms are available for booking
                if($reservedrooms < $allroomavailable)
                {
                   if($availability->room_status == "request")
                   {
                       //Request type room
                       $orf = 1;
                       $roomclass = "onRequest";
                       $roombutton = "on request";
                       $createurl = TRUE;
                       $admin_roomclass = "btn-primary";
                       $admin_roombutton = "On Request";
                       $admin_rowColor = $room_status_color['request'];
                       $rmcolor = $room_status_color[$availability->room_status];
                       $rmstatus = $room_status[$availability->room_status];
                   }
                   else
                   {
                       //Open type room
                       $orf = 0;
                       $roomclass = "";
                       $roombutton = "book now";
                       $createurl = TRUE;
                       $admin_roomclass = "green";
                       $admin_roombutton = "Book now";
                       $admin_rowColor = $room_status_color['open'];
                       $rmcolor = $room_status_color[$availability->room_status];
                       $rmstatus = $room_status[$availability->room_status];

                   }                   
                   $room_no_stat = "Rooms :  ".$roomcount."/".$allroomavailable." |";
                }
                else
                {
                    //Room not available now it depends upon room exhaust status
                    if($room->exhausted_status == "closed")
                    {
                        $roomclass = "notAvailable";
                        $roombutton = "closed";
                        $admin_roomclass = "notAvailable";
                        $admin_roombutton = "Closed";
                        $admin_rowColor = $room_status_color['closed'];
                        $room_no_stat = "Rooms :  Exhausted |";
                        $rmcolor = $room_status_color[$room->exhausted_status];
                        $rmstatus = $room_status[$room->exhausted_status];
                    }
                    else
                    {
                       //Request type room
                       $orf = 1;
                       $roomclass = "onRequest";
                       $roombutton = "on request";
                       $createurl = TRUE;
                       $admin_roomclass = "btn-primary";
                       $admin_roombutton = "On Request";
                       $admin_rowColor = $room_status_color['request'];
                       $room_no_stat = "Rooms :  Exhausted |";
                       $rmcolor = $room_status_color[$room->exhausted_status];
                       $rmstatus = $room_status[$room->exhausted_status];
                    }                    
                }
            }
        }
        
        $url = ($adminsection)? "admin/reservation/create" : "reservation/create";
        
        $href = ($createurl) ? Yii::app()->createUrl($url,array('roomId' => $room_id,'date' => $bkdate,'hotelId' => $hotel_id,'arrtime' => $arrtime1,'orf' => $orf)) : "javascript:void(0)";
        
        $return['roomclass'] = $roomclass;
        $return['roombutton'] = $roombutton;
        $return['admin_roomclass'] = $admin_roomclass;
        $return['admin_roombutton'] = $admin_roombutton;
        $return['admin_rowColor'] = $rmcolor;
        $return['room_status'] = $rmstatus;
        $return['room_no_stat'] = $room_no_stat;
        $return['href'] = $href;
        $return['buttontype'] = $createurl;
        $return['orf'] = $orf;
        
        
        return $return;

    }
    
    public static function getGenoalogyTree($userId){
        $genealogyListObject = Genealogy::model()->findAll(array('condition'=>'sponsor_user_id = '.$userId));
        return $genealogyListObject;
    }
}