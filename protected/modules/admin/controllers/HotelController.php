<?php

class HotelController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		//	'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','dropzoneupload',
					'changestate','changecity','changearea','changegroupchain','hotellist','hotelPhotosDelete',
					'editphoto','download','cropphotolist','sendhotelbutton','simplename'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function saveData($data,$request=array(),$con_stat=0){
		
		$result['status']="ERROR";
		$model = $data['model'];
		$params = $data['params'];
		$modelParams = $params['Hotel'];
		$model->attributes=$modelParams;
		
		if($model->validate()){
			if($model->save()){	
				$result['status'] = "SUCCESS";
                                $result['id'] = $model->id;
				$result['user_type'] = Yii::app()->user->getState('type');
                                
                                if($con_stat)
                                {
                                    $hstat = Hotel::model()->findByPk($model->id);
                                    $hstat->contract_status = $con_stat;
                                    $hstat->save(FALSE);
                                }
                                
				if(isset($request['type']) && $request['type']=="create"){
					$tblCity = City::model()->findByPk($model->city_id);
					$tblCity->setScenario('addhotelcount');
					$tblCity->hotel_count++;
					$tblCity->save();
				}elseif(isset($request['type']) && $request['type']=="update"){
					if($modelParams['city_before']!=$model->city_id){
						$tblCityBefore = City::model()->findByPk($modelParams['city_before']);
						$tblCityBefore->setScenario('addhotelcount');
						if($tblCityBefore->hotel_count > 0){
							$tblCityBefore->hotel_count--;
							$tblCityBefore->save();
						}
						$tblCity = City::model()->findByPk($model->city_id);
						$tblCity->setScenario('addhotelcount');
						$tblCity->hotel_count++;
						$tblCity->save();
					}
					
				}
					
				if(isset($modelParams['equipment'])){
					HotelEquipment::model()->deleteAll('hotel_id='.$model->id);
					foreach($modelParams['equipment'] as $equipId){	
						$hotelEquipment = HotelEquipment::model()->find('hotel_id=:p1 and equipment_id=:p2',array(':p1'=>$model->id,':p2'=>$equipId));	
						if(!$hotelEquipment)
							$hotelEquipment = new HotelEquipment;
						$hotelEquipment->hotel_id = $model->id;
						$hotelEquipment->equipment_id = $equipId;
						$hotelEquipment->save();
					}
				}
				if(isset($modelParams['theme'])){
					HotelTheme::model()->deleteAll('hotel_id='.$model->id);
					foreach($modelParams['theme'] as $themeId){
						$hotelTheme = HotelTheme::model()->find('hotel_id=:p1 and theme_id=:p2',array(':p1'=>$model->id,':p2'=>$themeId));
						if(!$hotelTheme)
							$hotelTheme = new HotelTheme;
						$hotelTheme->hotel_id = $model->id;
						$hotelTheme->theme_id = $themeId;
						$hotelTheme->save();
					}
				}
				if(isset($modelParams['portal'])){
				
				foreach($modelParams['portal'] as $portalId){
					HotelPortal::model()->deleteAll('hotel_id='.$model->id);
					$hotelPortal = HotelPortal::model()->find('hotel_id=:p1 and portal_id=:p2',array(':p1'=>$model->id,':p2'=>$portalId));
					if(!$hotelPortal)
						$hotelPortal = new HotelPortal;
					$hotelPortal->hotel_id = $model->id;
					$hotelPortal->portal_id = $portalId;
					$hotelPortal->status = 1;
					$hotelPortal->save();
				}
				}
				if(isset($modelParams['currency'])){
				HotelCurrency::model()->deleteAll('hotel_id='.$model->id);
				foreach($modelParams['currency'] as $currencyId){	
					$hotelCurrency = HotelCurrency::model()->find('hotel_id=:p1 and currency_id=:p2',array(':p1'=>$model->id,':p2'=>$currencyId));
					if(!$hotelCurrency)
						$hotelCurrency = new HotelCurrency;
					$hotelCurrency->hotel_id = $model->id;
					$hotelCurrency->currency_id = $currencyId;
					$hotelCurrency->save();
				}
				}
				
				/*if(isset($modelParams['email'])){
					$hotelEmail = HotelEmail::model()->find('hotel_id=:p1',array(':p1'=>$model->id));
					if(!$hotelEmail)
						$hotelEmail = new HotelEmail;
					$hotelEmail->hotel_id = $model->id;
					$hotelEmail->email_add = $modelParams['email'];
					$hotelEmail->save();
				}
				*/
                                if(isset($params['HotelContact']))
                                {
                                    foreach(Yii::app()->params->hotel_contact_info as $cky=>$cval):
                                        
                                        $hotelcontact = HotelContact::model()->find('hotel_id='.$model->id.' and contact_type='.$cky);
                                        if($hotelcontact==NULL)
                                            $hotelcontact = new HotelContact;
                                        
                                        $hotelcontact->hotel_id = $model->id;
                                        $hotelcontact->contact_type = $cky;
                                        
                                        $name = explode(" ",$params['HotelContact'][$cky]['name']);
                                        $hotelcontact->first_name = trim($name[0]);
                                        
                                        $lname = "";
                                        foreach ($name as $nky=>$nval):
                                            if($nky!=0)
                                                $lname .= $nval." ";    
                                        endforeach;
                                        $lname = trim($lname);
                                        
                                        $hotelcontact->last_name = $lname;
                                        $hotelcontact->telephone = $params['HotelContact'][$cky]['telephone'];
                                        $hotelcontact->email_address = $params['HotelContact'][$cky]['email_address'];
                                        $hotelcontact->added_at = date("Y-m-d H:i:s",strtotime("now"));
                                        $hotelcontact->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                                        $hotelcontact->save(FALSE);                                        
                                            
                                    endforeach;
                                }
                                
				HotelEmail::model()->deleteAll('hotel_id='.$model->id);
				if(isset($params['HotelDetail']['email_address'])){
					foreach($params['HotelDetail']['email_address'] as $multiEmail){
						$hEmail = new HotelEmail();
						$hEmail->email_add = $multiEmail;
						$hEmail->hotel_id = $model->id;
						$hEmail->save();
					}
				}
			}
		}else{
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($type)
	{
		if($type=="details"){
			$model=new Hotel;
		
		}elseif ($type=="administratif") {
			$model = new HotelAdministrative;
			
		}elseif ($type=="textes") {
			$model = new HotelContent;
				
		}
		$access = Yii::app()->user->getState('access');
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_REQUEST['Hotel']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST;
			$slug = $data['params']['Hotel']['name'];
			$data['params']['Hotel']['slug']= BaseClass::Slugunique($model,$slug,0);
                        $data['params']['Hotel']['simple_name']= $slug;
			$result=$this->saveData($data,array('type'=>'create'));
			echo json_encode($result);
			Yii::app()->end();
		}
	
		$this->render('create',array(
				'model'=>$model,
				'type'=>$type,
				'access'=>$access
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$type)
	{ 
                $con_stat = 0;
		$permission = $this->getAccess($id);//check access
		$access = Yii::app()->user->getState('access');
		
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$adminModel = "";$contentModel ="";$portal_id = 1;
		if ($type=="administratif") {
			$adminModel = HotelAdministrative::model()->findByAttributes(array('hotel_id'=>$id));
			if(!$adminModel)
				$adminModel = new HotelAdministrative;
			
		}elseif ($type=="textes") {
				
			if(isset($_REQUEST['HotelTextList']['portal_id']))
				$portal_id = $_REQUEST['HotelTextList']['portal_id'];
				$criteria=new CDbCriteria(array(
						'condition'=>'hotel_id='.$id.' and portal_id='.$portal_id,
				));
				$contentModel=new CActiveDataProvider('HotelContent', array(
						'criteria'=>$criteria,
				));
			
		}elseif ($type=="textadd") {
			if(isset($_REQUEST['content_id']))
				$contentModel = HotelContent::model()->findByAttributes(array('id'=>$_REQUEST['content_id']));
			else
				$contentModel = new HotelContent;
		}
		
		/************************For saving Detail Page**************************************/
		if(isset($_REQUEST['Hotel'])){
                        $data['model'] = $model;
			$data['params'] = $_REQUEST;
                        
                        $slug = $data['params']['Hotel']['name'];
			$data['params']['Hotel']['slug']= BaseClass::Slugunique($model,$slug,$id);
                        $data['params']['Hotel']['simple_name']= $slug;
                        
                        //If the hotel became active from inactive
                        if($data['params']['Hotel']['status']== 1 && $data['params']['prev_hotel_status'] == 0)
                        {
                            //Send mail
                            if($_REQUEST['HotelContact']['1']['email_address']!="")
                                $sendemail = $_REQUEST['HotelContact']['1']['email_address'];
                                   
                            $contactMail['from'] = Yii::app()->params['dayuseInfoEmail'];              
                            $contactMail['to'] = $sendemail;
                            $contactMail['subject'] = 'DAYSTAY - Hotel has been Activated';
                            $hotelUrl = "/hotel/detail?slug=".urlencode($data['params']['Hotel']['slug']);

                            $contactMail['body'] = $this->renderPartial('/mail/send_active_mail', array('HotelName' => $data['params']['Hotel']['name'],'hotelUrl'=>$hotelUrl,), true);
                            $result = CommonHelper::sendMail($contactMail);
                            
                            $con_stat = 1;
                        }
                        
			$result=$this->saveData($data,array('type'=>'update'),$con_stat);
			echo json_encode($result);
			Yii::app()->end();
		}
		
		/************************For saving Administrative**************************************/
		if(isset($_REQUEST['HotelAdministrative'])){
			$adminModel->attributes = $_REQUEST['HotelAdministrative'];
			$adminModel->hotel_id = $id;
			
			if($adminModel->save()){
				$result['status']="SUCCESS";
				$result['hotel_id'] = $id;
				HotelAdministrativeEmail::model()->deleteAll('administrative_id='.$adminModel->id);
				if(isset($_REQUEST['HotelAdministrative']['email_address'])){					
					foreach($_REQUEST['HotelAdministrative']['email_address'] as $multiEmail){
						$adminEmail = new HotelAdministrativeEmail();
						$adminEmail->email_add = $multiEmail;
						$adminEmail->administrative_id = $adminModel->id;
						$adminEmail->save();
					}
				}
			}else	
				$result['errorMessage'] = print_r($adminModel->getErrors(), true);
			echo json_encode($result);			
			Yii::app()->end();
		}
		
		/************************For saving Textes**************************************/
		if(isset($_REQUEST['HotelContent'])){ 
			foreach($_REQUEST['HotelContent'] as $portal=>$Pcontent){
				foreach($Pcontent as $type=>$Tcontent){
					foreach($Tcontent as $language=>$content){
						$condition = "portal_id='".$portal."' and hotel_id = '".$id."' and language_id = '".$language."' and type='".$type."'";
						if($content){
							$contentModel = HotelContent::model()->find($condition);
							if(!$contentModel)
								$contentModel = new HotelContent();
								$contentModel->portal_id=$portal;
								$contentModel->hotel_id=$id;
								$contentModel->language_id=$language;
								$contentModel->type=$type;
								$contentModel->content=$content;
							if($contentModel->save())
								$result['status']="SUCCESS";
							else
								$result['errorMessage'] = print_r($contentModel->getErrors(), true);
						}else{
							$contentModel = HotelContent::model()->deleteAll($condition);
							$result['status']="SUCCESS";
						}
					}	
				}
			}
			echo json_encode($result);
			Yii::app()->end();
		}
		
		/************************For saving photo order**************************************/
		if(isset($_REQUEST['HotelPhoto']) && $type=="photos"){
			$arrayHotelPosition = explode(",",$_REQUEST['HotelPhoto']['position']);
			$removePos = $_REQUEST['HotelPhoto'];
			unset($removePos['position']);//for featured image
			$photoKey=0;
			foreach($arrayHotelPosition as $hotelPosition){
				$photoKey++;
				$hotelPhoto = HotelPhoto::model()->findByPk($hotelPosition);
				$hotelPhoto->position = $photoKey;
				$hotelPhoto->is_featured=0;
				if(in_array($hotelPhoto->id, $removePos) )
					$hotelPhoto->is_featured=array_search($hotelPhoto->id, $removePos);
				$hotelPhoto->save();
			}
			if(isset($_REQUEST['PhotoPortal'])){
				PhotoPortal::model()->deleteAll('hotel_id=:p1',array(':p1'=>$id));
				$hotelPhotos = HotelPhoto::model()->findAll('hotel_id=:p1',array(':p1'=>$id));
				foreach($hotelPhotos as $hoPho){
					foreach($_REQUEST['PhotoPortal'] as $key=>$portal){
						if(in_array($hoPho->id, $portal)){
							$photoPortal = new PhotoPortal;
							$photoPortal->photo_id=$hoPho->id;
							$photoPortal->portal_id=$key;
							$photoPortal->hotel_id=$id;
							$photoPortal->save();
						}
					}
				}
			}
			$result['status']="SUCCESS";
			$result['id']=$id;
			echo json_encode($result);
			Yii::app()->end();			
		}
		
		/************************To show selected photo portal check list**************************************/
		$photoPortals = PhotoPortal::model()->findAll();
		$photoPort =array();
		foreach($photoPortals as $photoPortal){
			$photoPort[$photoPortal->photo_id][] = $photoPortal->portal_id;
		}
		
		$this->render('update',array(
				'model'=>$model,
				'adminModel'=>$adminModel,
				'contentModel'=>$contentModel,
				'portal_id'=>$portal_id,
				'type'=>$type,
				'photoPort'=>$photoPort,
				'permission'=>$permission,
				'access'=>$access
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(isset($_REQUEST['type']) && $_REQUEST['type']=="photos"){
			HotelPhoto::model()->deleteAll('id=:p1',array(':p1'=>$_REQUEST['photo_id']));
			PhotoPortal::model()->deleteAll('photo_id=:p1',array(':p1'=>$_REQUEST['photo_id']));
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('hotel/update?id='.$id.'&type=photos'));
			Yii::app()->end();
		}
		$model = $this->loadModel($id);
		if($model->status == 1)
			$model->status =0;
		else
			$model->status = 1;
		$model->save();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
        public function actionSimplename()
        {       
        	
            if ($_POST) {
            foreach ($_POST['Hotel'] as $key => $val) {
                $hotelUdate = Hotel ::model()->findByPk($key);
                $hotelUdate->simple_name = $val;
                $hotelUdate->save(FALSE);
                }
            }

            $criteria = new CDbCriteria;

            $criteria->with = 'hotelAdministratives';
            $criteria->condition = 'status = 1';
            $criteria->select = array('name', 'simple_name');

            $count = Hotel::model()->findAll($criteria);
            $this->render('simplename', array(
                'count' => $count
            ));
        }

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		if (isset($_GET['pageSize'])) {
			$pageSize = $_GET['pageSize'];
		} else {
			$pageSize = Yii::app()->params['defaultPageSize'];
		}
                
		$status = isset($_GET['type'])? $_GET['type']:1;
        $search_result = FALSE;
                
		$model=new Hotel('search');
		$model->unsetAttributes();  // clear any default values
		$userId=Yii::app()->user->getState('user_id');
		$access = Yii::app()->user->getState('access');
		
		if(isset($_REQUEST['Hotel'])){
        	$search_result = TRUE;
                        
			$model->attributes=$_REQUEST['Hotel'];
			$criteria=new CDbCriteria(array(
						'with'=>array('city'),
						'condition'=>'t.name like "%'.$_REQUEST['Hotel']['name'].'%" OR t.slug like"%'.$_REQUEST['Hotel']['name'].'%" and t.status=1',
						'together'=>true,
					
			));
			if($access=="manager"){
				$criteria=new CDbCriteria(array(
						'with'=>array('city','hotelAccess'=>array('joinType'=>'INNER JOIN', 'condition'=>'hotelAccess.user_id='.$userId)),
						'condition'=>'t.name like "%'.$_REQUEST['Hotel']['name'].'%" OR t.slug like"%'.$_REQUEST['Hotel']['name'].'%" and t.status=1',
						'together'=>true
				));
			}
			$dataProvider=new CActiveDataProvider('Hotel', array(
						'criteria'=>$criteria,
						'sort'=>array(
								'attributes'=>array(
										'city.name'=>array(
												'asc'=>'city.name',
												'desc'=>'city.name DESC',
										),
										'*',
								),
						),
	    				'pagination' => array('pageSize' => $pageSize),
				));	    	
		} else {
        	$criteria=new CDbCriteria(array(
				'with'=>array('city'),
                'condition'=>'t.status='.$status,
				'together'=>true
			));
            if($access=="manager"){
            	$criteria=new CDbCriteria(array(
                	'with'=>array('city','hotelAccess'=>array('joinType'=>'INNER JOIN', 'condition'=>'hotelAccess.user_id='.$userId)),
                    'condition'=>'t.status=1',
                    'together'=>true
				));
			}		
        	$dataProvider = Hotel::getAllHotel($criteria,$pageSize); 
		}
        
		$hotelPage = isset($_REQUEST['Hotel_page'])?$_REQUEST['Hotel_page']:1;
		$this->render('index',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'hotelPage'=>$hotelPage,
			'pageSize'=>$pageSize,
			'access'=>$access,
        		'status'=>$status,
                'search_result'=>$search_result
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Hotel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Hotel']))
			$model->attributes=$_GET['Hotel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Hotel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Hotel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Hotel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hotel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDropzoneUpload($id,$type){
		set_time_limit(0);
		ini_set('memory_limit', '2048M');
			
		$folder=Yii::app()->params->imagePath['hoteldropzone'];// folder for uploaded files
		$idPath = $id."/";
		if($type=='image'){
			$sourceImageName = 	basename( $_FILES["file"]["name"]);
			$sourceImageType =$_FILES["file"]["type"];
			$temp = explode("/", $sourceImageType) ;
			$targetName = CommonHelper::generateNewNameOfImage($sourceImageName);
			
			$targetImagePath = $folder .$idPath. $targetName;
			$inputpath = $folder .$idPath;
			if (!is_dir($inputpath) && !mkdir($inputpath,'0777',true)){
				die("Error creating folder $inputpath");
			}
			chmod($inputpath, 0777);
			//chmod($targetImagePath, 0777);
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetImagePath)) {
				$options = Yii::app()->params['thumbnails']['hotel'];
				CommonHelper::generateCropImage($inputpath, $targetName, $inputpath, $targetName, $options);
				$criteria = new CDbCriteria();
				$criteria->select = "max(position) position";
				$hotelPhoto = HotelPhoto::model()->find($criteria);
				if(!$hotelPhoto)
					$position = 0;
				else
					$position = ($hotelPhoto->position)+1;
				
				$hotelPhoto = new HotelPhoto();
				$hotelPhoto->hotel_id = $id;
				$hotelPhoto->name = $targetName;
				$hotelPhoto->position = $position;
				$hotelPhoto->is_featured = 0;
				$hotelPhoto->is_slider = 0;
				$hotelPhoto->status = 1;
				if($hotelPhoto->save()){
					$result['position']=$position;
					$result['filename']=$targetName;//GETTING FILE NAME
					$result['result']="success";
					echo json_encode($result);						
				}else{
					$result['result']="failure";
					echo json_encode($result);
				}
			}else {
				$result['result']="failure";
				echo json_encode($result);
			}
		}elseif($type=='pdf'){
			Yii::import("ext.EAjaxUpload.qqFileUploader");
			
			$uploaddir = $folder .$idPath."contract/";
			if (!is_dir($uploaddir) && !mkdir($uploaddir,'0777',true)){
				die("Error creating folder $uploaddir");
			}
			chmod($uploaddir, 0777);
			$allowedExtensions = array("pdf");//array("jpg","jpeg","gif","exe","mov" and etc...
			$sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
			$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
			$result = $uploader->handleUpload($uploaddir);
			$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
			$fileSize=filesize($uploaddir.$result['filename']);//GETTING FILE SIZE
			$fileName=$result['filename'];//GETTING FILE NAME
			
			echo $return;// it's array
			
		}else{
			header("HTTP/1.1 415 Unsupported Media Type");
		}
		Yii::app()->end();
	}
	
	public function actionChangestate($country_id,$selectName)
	{
		if(isset($country_id) && $country_id!="NA")
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$criteria->addCondition("country_id=".$country_id);
			$states=State::model()->findAll($criteria);
			//echo "<select id='state_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";
			foreach($states as $liststate)
			{
				echo "<option value=".$liststate->id.">".$liststate->name."</option>";
			}
			echo "</select>";
		}else{
			//echo "<select id='state_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";			
			echo "</select>";
		}
	}
	
	public function actionChangeCity($state_id,$selectName)
	{
		if(isset($state_id) && $state_id!="NA")
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition("status=1");
			$criteria->addCondition("state_id=".$state_id);
			$cities=City::model()->findAll($criteria);
			//echo "<select id='city_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";				
			foreach($cities as $listcity)
			{
				echo "<option value=".$listcity->id.">".$listcity->name."</option>";
			}
			echo "</select>";
		}else{
			//echo "<select id='city_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";
			echo "</select>";
		}
	}
        
        public function actionChangeArea($city_id,$selectName)
	{
		if(isset($city_id) && $city_id!="NA")
		{
			$criteria = new CDbCriteria;
                        $criteria->alias = "a";                
                        $criteria->select = "a.*";
                        $criteria->addCondition("a.status=1");
                        $criteria->addCondition("ac.city_id=".$city_id);
                        $criteria->join=" JOIN tbl_area_city ac on ac.area_id=a.id";
                        

                        $area=  Area::model()->findAll($criteria);
                        
			echo "<select id='area_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";				
			foreach($area as $listarea)
			{
				echo "<option value=".$listarea->id.">".$listarea->name."</option>";
			}
			echo "</select>";
		}else{
			echo "<select id='area_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''>NA</option>";
			echo "</select>";
		}
	}
	
	public function actionChangeGroupChain($group_id,$selectName)
	{
		if(isset($group_id) && $group_id!="")
		{
			$criteria = new CDbCriteria;
			$criteria->addCondition("parent_id=".$group_id);
			$groups=Group::getAllGroup($criteria);
			echo "<select id='chain_id' name='$selectName' class='form-control select2me'>";
			echo "<option value=''></option>";
			foreach($groups as $group)
			{
			echo "<option value=".$group->id.">".$group->name."</option>";
			}
			echo "</select>";
		}
	}
	
	private function getAccess($hotel_id){
		$type = Yii::app()->user->getState('type');
		$userId = Yii::app()->user->getState('user_id');
		if($type!="dayuse" && $userId){
			$hotelAccess = HotelAccess::model()->find('hotel_id='.$hotel_id.' and user_id='.$userId);
			if($hotelAccess)
				return true;
			else 
				return false;
		}else 
			 return false;
	}
	
	public function actionHotelList($term=null){
                $access = Yii::app()->user->getState('access');
		$finaldata = array();
		if($term){
			$criteriacity = new CDbCriteria();
			$criteriacity->select = 'id, name';
			$criteriacity->addColumnCondition(array('t.status'=>1));
			$criteriacity->addSearchCondition('t.name',$term);
                        //Manager can search only his hotel access list
                        if($access=='manager')
                        {
                            $Allowed_hids = Yii::app()->user->getState('AccHotels');
                            $criteriacity->addInCondition('id',$Allowed_hids);
                        }
			$citydata = Hotel::model()->findAll($criteriacity);
			$i = 0;
			foreach ($citydata as $ctd){
				$finaldata[$i]['id']= $ctd->id;
				$finaldata[$i]['value']= $ctd->name;
				$finaldata[$i]['level']= $ctd->slug;
				$i++;
			}
		}
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode($finaldata);
		Yii::app()->end();
	}
	public function actionHotelPhotosDelete(){
		
		if(isset($_POST['ids']))
		{
			$hotelphotoids = $_POST['ids'];
			foreach ($hotelphotoids as $photoids)
			{
				$hotelphotomodel = HotelPhoto::model()->findByPk($photoids);
				$hotelphotomodel->delete();
				//echo $photoids;
			}
		}
	}
	public function actionEditphoto(){
		$model = new Hotel;
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$targ_w = $_POST['w'];
			$targ_h = $_POST['h'];
			$jpeg_quality = 90;
			$hotelid = $_POST['hotelid'];
			$photoid = $_POST['photoid'];
			$imagename = $_POST['imagename'];
			$resolution = $_POST['resolution'];
			$baseurl = Yii::app()->getBaseUrl(true);
			$src = $baseurl.'/upload/hotel/'.$hotelid.'/'.$imagename;
			$src2 = dirname(Yii::app()->getBasePath()).'/upload/hotel/'.$hotelid.'/'.$imagename;
			$images_path = realpath(Yii::app()->basePath.'/../upload');
			$img_r = imagecreatefromjpeg($src2);
		
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
		
			imagecopyresampled($dst_r,$img_r,0,0,intval($_POST['x']),intval($_POST['y']), $targ_w,$targ_h, intval($_POST['w']),intval($_POST['h']));
		
			//header('Content-type: image/jpeg');
			//imagejpeg($dst_r,null,$jpeg_quality);
			//unlink($images_path.$imagename);
			
			imagejpeg($dst_r, $images_path.'/crop/'.$imagename,$jpeg_quality);
			
			$targetName = $imagename;
			$inputpath = $images_path.'/crop/';
			$outputpath =$images_path.'/hotel/'.$hotelid.'/';
			$options = array($resolution=>$resolution);
			chmod($inputpath.$targetName, 0777);
	
			CommonHelper::generateCropImage($inputpath, $targetName, $outputpath, $targetName, $options);
			chmod($outputpath.$targetName, 0777);
			$this->redirect(array('hotel/cropphotolist','id'=>$hotelid, 'type'=>'photos','photo_id'=>$photoid));
			//imagejpeg($dst_r, $images_path.'/hotel/'.$hotelid.'/'.$resolution.'/'.$imagename,$jpeg_quality);
		}
		
		$this->render('editphoto',array(
				'model'=>$model,
		));
	}
	public function actionCropphotolist(){
		$this->render('cropphotolist');
	}
        
        /**
         * Download file path
         * 
         * @param string $fullpath
         */
        public function downloadFile($fullpath){
            if(!empty($fullpath)){ 
                header("Content-type:application/pdf"); //for pdf file
                header('Content-Disposition: attachment; filename="'.basename($fullpath).'"'); 
                header('Content-Length: ' . filesize($fullpath));
                readfile($fullpath);
                Yii::app()->end();
            }
        }
        /**
         * download file
         */
        public function actionDownload(){
            if($_REQUEST['name']) {
                $fileName = $_REQUEST['name'];
                $hotelId = $_REQUEST['hotelId'];
                $path = Yii::getPathOfAlias('webroot')."/upload/hotel/".$hotelId."/contract/".$fileName;
                $this->downloadFile($path);
            }
        }
        
        public function getHotelStatus($data,$row)
        {
            if($data->status==1)
                echo "Active";
            elseif ($data->status==0)
                echo "Inactive";
            else
                echo "Closed";
        }
        
        public function actionSendHotelButton() 
        {
            $hotel_id = $_REQUEST['id'];
            
            // Get the hotel manager - General Manager email_address
            $hmanager = HotelContact::model()->find("hotel_id=".$hotel_id." and contact_type=1");
            
            if($hmanager!=NULL)
            {
                //check the email address already registered?
                $admin_check = AdminUser::model()->find("email_address='".$hmanager->email_address."' and type='hotel'");
                if($admin_check==NULL)
                {
                    //Add as hotel manager
                    $aduser = new AdminUser();
                    $aduser->first_name = $hmanager->first_name;
                    $aduser->last_name = $hmanager->last_name;
                    $aduser->telephone = $hmanager->telephone;
                    $aduser->email_address = $hmanager->email_address;
                    
                    $aduser->password = md5('password');
                    
                    $aduser->type = 'hotel';
                    $aduser->added_at = date("Y-m-d H:i:s",strtotime("now"));
                    $aduser->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                    $aduser->save(FALSE);
                    $manager_id = $aduser->id;
                    
                    $hmanager_email = $hmanager->email_address;
                }
                else
                {
                    $manager_id = $admin_check->id;
                    $hmanager_email = $admin_check->email_address;
                }
                
                //update the hotel contract status as 0-not verified
                $hotel = Hotel::model()->findByPk($hotel_id);
                $hotel->contract_status = 0;
                $hotel->save(FALSE);
                
                //add the hotel to the manager access
                HotelAccess::model()->deleteAll("user_id=".$manager_id." and hotel_id=".$hotel_id);
                
                $hotel_acc = new HotelAccess();
                $hotel_acc->user_id = $manager_id;
                $hotel_acc->hotel_id = $hotel_id;
                $hotel_acc->added_at = date("Y-m-d H:i:s",strtotime("now"));
                $hotel_acc->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                $hotel_acc->save(FALSE);  
                
                
                //Now prepare the mail to be sent to the manager
                $baseUrl = Yii::app()->getBaseUrl(true);
                $manager_name = $hmanager->first_name. " " .$hmanager->last_name;
                
                $emailId = Yii::app()->params['dayuseInfoEmail'];
                $contactMail['from'] = $emailId;
                $contactMail['to'] = $hmanager_email;
                $contactMail['subject'] = 'DAYSTAY - New Account Created';

                $contactMail['body'] = $this->renderPartial('/mail/hotel_manager_contract', array('managerName' => $manager_name,
                    'baseUrl' => $baseUrl,
                    'hmanager_email' =>$hmanager_email,
                    ), true);
                $result = CommonHelper::sendMail($contactMail);
                if($result)
                    echo 1;
                else
                    echo 0;
                    
                
            }
        }
}
