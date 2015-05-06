<?php

class RoomController extends Controller
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
				'actions'=>array('index','view','options','saveroominfoprice','tariff','changeequipment','changestatus','deloptions', 'Deleteoption'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','options','saveroominfoprice'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','tariff','stariff','availability','savailability','options','saveroominfoprice'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Room;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		//$type = $_GET['type'];
		$hotel_id = Yii::app()->session['hotel_id'];
		$model1=new Room('search');
		$model1->unsetAttributes();
		$_GET['Room']['hotel_id']=$hotel_id;  // clear any default values
		if(isset($_GET['Room']))
			$model1->attributes=$_GET['Room'];
		
		if(isset($_REQUEST['Room']))
		{
			
			$data['model'] = $model;
			$data['params'] = $_REQUEST;
			
			$result=$this->saveData($data);
			
			if(isset($_REQUEST['roomst']))
				$this->addStatusDefinition($result['room']['id'],$_REQUEST['roomst'],$_REQUEST['room_no']);
			
			if($result['status']=="SUCCESS")
			{
				$tariff = RoomTariff::model();
				$connection = Yii::app()->db;
				
				// Add tariff for the newly created room
				$room_price = (isset($_REQUEST['Room']['default_price'])) ? $_REQUEST['Room']['default_discount_price'] : 100;
				$room_id = $result['room']['id'];
				$hotel_id = $result['room']['hotel_id'];
				
				// Get the default currency id for the hotel
				$hotel = Hotel::model()->find("id=".$hotel_id);
				$currency_id = ($hotel->default_currency_id!=0)? $hotel->default_currency_id : 1;
				
								
				$begin = strtotime(date('Y-m-d'));
				$end = strtotime(date("Y")."-12-31"); // Convert date to a UNIX timestamp
				
				// Loop from the start date to end date and output all dates inbetween
				for ($i=$begin; $i<=$end; $i+=86400) {
				
					$dt = date("Y-m-d", $i);
					$dname = date('D', strtotime($dt));
						
					$condition = "room_id='".$room_id."' and tariff_date = '".$dt."'";
					$recExists = $tariff->exists($condition);

					if($recExists)
					{
						$sqlStatement = "update `tbl_room_tariff` set `price`= '".$room_price."',`updated_at`=now() where `room_id`='".$room_id."' and `tariff_date`='".$dt."'";
					}
					else
					{
						$sqlStatement = "INSERT INTO  `tbl_room_tariff` (`id`,`room_id`,`tariff_date`,`price`,`currency_id`,`added_at`,`updated_at`)
						VALUES (NULL,$room_id,'$dt',$room_price,$currency_id,now(),CURRENT_TIMESTAMP)";
					}
					$command=$connection->createCommand($sqlStatement);
					$command->execute();
				}

			}
			
			echo json_encode($result);
			Yii::app()->end();
		}

		$this->render('create',array(
			'model'=>$model,
			'model1'=>$model1
		));
	}
	
	public function addStatusDefinition($room_id,$roomst,$room_no)
	{
		//Add the information in the Room Status Definitation for Availability Section
		$connection = Yii::app()->db;
		$rmdef = RoomStatusDef::model();
		
		// Delete all the information regarding the room id from the availability table
		RoomAvailability::model()->deleteAll("room_id='".$room_id."'");
		
		if(count($roomst))
		{
			foreach ($roomst as $ky=>$rstat)
			{
				// Mon - $ky --- open - $rstat
				$condition = "`room_id`='".$room_id."' and `dyname`='".$ky."'";
				$recExists = $rmdef->exists($condition);
				
				$room_num = $room_no[$ky];
				
				if($recExists)
				{
					$sqlStatement = "update `tbl_room_status_def` set `room_no`= ".$room_num.",`room_status` = '".$rstat."',`updated_at`=now() where ".$condition;
				}
				else
				{
					$sqlStatement = "INSERT INTO  `tbl_room_status_def` (`id`,`room_id`,`dyname`,`room_status`,`room_no`,`added_at`,`updated_at`)
					VALUES (NULL,$room_id,'$ky','$rstat',$room_num,now(),CURRENT_TIMESTAMP)";
				}
				$command=$connection->createCommand($sqlStatement);
				$command->execute();
				
				// insert the new records for the room availability
				$begin = strtotime(date('Y-m-d')); // Convert date to a UNIX timestamp
				$end = strtotime(date('Y')."-12-31"); // Convert date to a UNIX timestamp
				
				
				for ($i=$begin; $i<=$end; $i+=86400) {
						
					//$dt = $date->format("Y-m-d");
					$indt = date("Y-m-d", $i);
					$dname = date('D', strtotime($indt));
					if($dname == $ky)
					{
						$sqlStatement = "INSERT INTO  `tbl_room_availability` (`id`,`room_id`,`availability_date`,`nb_rooms`,`room_status`,`added_at`,`updated_at`)
						VALUES (NULL,$room_id,'$indt',$room_num,'$rstat',now(),CURRENT_TIMESTAMP)";
							
						$command=$connection->createCommand($sqlStatement);
						$command->execute();
					}
				}
				
				/*
				foreach ($rstat as $rky=>$rval)
				{
					// Open - $ky --- Mon - $rky
		
					$condition = "`room_id`='".$room_id."' and `dyname`='".$rky."' and `room_status` = '".$ky."'";
					$recExists = $rmdef->exists($condition);
					
					$room_num = $room_no[$rky];
					if($recExists)
					{
						$sqlStatement = "update `tbl_room_status_def` set `room_no`= ".$room_num.",`updated_at`=now() where ".$condition;
					}
					else
					{
						$sqlStatement = "INSERT INTO  `tbl_room_status_def` (`id`,`room_id`,`dyname`,`room_status`,`room_no`,`added_at`,`updated_at`)
						VALUES (NULL,$room_id,'$rky','$ky',$room_num,now(),CURRENT_TIMESTAMP)";
					}
					$command=$connection->createCommand($sqlStatement);
					$command->execute();
					
						
					
					// insert the new records for the room availability
					//$begin = new DateTime(date('Y-m-d'));
					//$end = new DateTime(date('Y')."-12-31");
					//$end = $end->modify( '+1 day' );
					
					//$interval = new DateInterval('P1D');
					//$daterange = new DatePeriod($begin, $interval ,$end);
					
					$begin = strtotime(date('Y-m-d')); // Convert date to a UNIX timestamp
					$end = strtotime(date('Y')."-12-31"); // Convert date to a UNIX timestamp
					
					
					// Loop from the start date to end date and enter the data for the room availability based upon the status
					//foreach($daterange as $date) {
						//$indt = $date->format("Y-m-d");
						
					for ($i=$begin; $i<=$end; $i+=86400) {
					
						//$dt = $date->format("Y-m-d");
						$indt = date("Y-m-d", $i);
						$dname = date('D', strtotime($indt));
						if($dname == $rky)
						{
							$sqlStatement = "INSERT INTO  `tbl_room_availability` (`id`,`room_id`,`availability_date`,`nb_rooms`,`room_status`,`added_at`,`updated_at`)
							VALUES (NULL,$room_id,'$indt',$room_num,'$ky',now(),CURRENT_TIMESTAMP)";
							
							$command=$connection->createCommand($sqlStatement);
							$command->execute();
						}
					}
				}
				*/
			}
		}
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model=$this->loadModel($id);
		
		$hotel_id = Yii::app()->session['hotel_id'];
		$model1=new Room('search');
		$model1->unsetAttributes();
		$_GET['Room']['hotel_id']=$hotel_id;  // clear any default values
		if(isset($_GET['Room']))
			$model1->attributes=$_GET['Room'];
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Room'])){
			
			if(isset($_REQUEST['roomst']))
				$this->addStatusDefinition($id,$_REQUEST['roomst'],$_REQUEST['room_no']);
			
			
			$data['model'] = $model;
			$data['params'] = $_REQUEST;
		
			$result=$this->saveData($data);
			
			if($result['status']=="SUCCESS")
			{
				$tariff = RoomTariff::model();
				$connection = Yii::app()->db;
			
				// Add tariff for the newly created room
				$room_price = (isset($_REQUEST['Room']['default_price'])) ? $_REQUEST['Room']['default_discount_price'] : 100;
				$room_id = $id;
			
				// Get the default currency id for the hotel
				$hotel = Hotel::model()->find("id=".$hotel_id);
				$currency_id = ($hotel->default_currency_id!=0)? $hotel->default_currency_id : 1;
			
			
				$begin = strtotime(date('Y-m-d'));
				$end = strtotime(date("Y")."-12-31"); // Convert date to a UNIX timestamp
			
				// Loop from the start date to end date and output all dates inbetween
				for ($i=$begin; $i<=$end; $i+=86400) {
			
					$dt = date("Y-m-d", $i);
					$dname = date('D', strtotime($dt));
			
					$condition = "room_id='".$room_id."' and tariff_date = '".$dt."'";
					$recExists = $tariff->exists($condition);
			
					if($recExists)
					{
						$sqlStatement = "update `tbl_room_tariff` set `price`= '".$room_price."',`updated_at`=now() where `room_id`='".$room_id."' and `tariff_date`='".$dt."'";
					}
					else
					{
						$sqlStatement = "INSERT INTO  `tbl_room_tariff` (`id`,`room_id`,`tariff_date`,`price`,`currency_id`,`added_at`,`updated_at`)
						VALUES (NULL,$room_id,'$dt',$room_price,$currency_id,now(),CURRENT_TIMESTAMP)";
					}
					$command=$connection->createCommand($sqlStatement);
					$command->execute();
				}
			
			}
			
			echo json_encode($result);
			Yii::app()->end();
		}

		$this->render('update',array(
			'model'=>$model,
			'model1'=>$model1
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
	
		$model = $this->loadModel($id);
		if($model->status == 1)
			$model->status =0;
		else
			$model->status = 1;
		$model->save();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index?type=room&hotel_id='.$model->hotel_id));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$type = $_GET['type'];
		$hotel_id = $_GET['hotel_id'];
		Yii::app()->session['hotel_id'] = $hotel_id;
		$model=new Room('search');
		$model->unsetAttributes();
		$_GET['Room']['hotel_id']=$hotel_id;  // clear any default values
		if(isset($_GET['Room']))
			$model->attributes=$_GET['Room'];

		$this->render('index',array(
			'model'=>$model,
			'type'=>$type,
			'hotel_id'=>$hotel_id,	
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Room('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Room']))
			$model->attributes=$_GET['Room'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function saveData($data){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$modelParams = $params['Room'];
		$model->attributes=$modelParams;
		//$model->attributes=$params;
		//$model->filter = implode("#", $params['filter']);
		
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		//print_r($params['RoomInfo']);exit
		if($model->validate()){
		if($model->save()){
			$room_id = $model->id;
			$gethid = Room::model()->findByPk($model->id);
			$result['status']="SUCCESS";
			$result['room']['id']=$room_id;
			$result['room']['hotel_id']=$gethid->hotel_id;
			
			if(isset($params['check_list']))
			{
				foreach($params['check_list'] as $key=>$value){
					$findops = RoomOptions::model()->findByAttributes(array('room_id'=>$room_id,'equipment_id'=>$key));
					if(empty($findops)){
						$RoomOps = new RoomOptions;
					}else{
						$RoomOps = RoomOptions::model()->findByAttributes(array('room_id'=>$room_id,'equipment_id'=>$key));
					}
					$RoomOps->equipment_id = $key;
					$RoomOps->room_id = $room_id;
					$RoomOps->price = $params['check_price'][$key];
					$RoomOps->currency_id = $params['check_currency'][$key];
					$RoomOps->added_at = date("Y-m-d H:i:s",strtotime("now"));
					$RoomOps->updated_at = date("Y-m-d H:i:s",strtotime("now"));
					$RoomOps->save(false);
				}
			}
			if(isset($params['RoomInfo'])){
				foreach($params['RoomInfo'] as $key=>$roomInfo){
					$language_id = $roomInfo['language_id'];
					$name = $roomInfo['name'];
					$room_condition  = $roomInfo['room_condition'];
					$criteria = new CDbCriteria;
					$criteria->addCondition("room_id='$room_id'");
					$criteria->addCondition("language_id='$language_id'");
					$RoomInfo = RoomInfo::model()->find($criteria);
					if(empty($RoomInfo)){
						$RoomInfo = new RoomInfo;
						$RoomInfo->room_id = $room_id;
						$RoomInfo->language_id = $language_id;
						$RoomInfo->added_at = date("Y-m-d H:i:s",strtotime("now"));
						$RoomInfo->updated_at = date("Y-m-d H:i:s",strtotime("now"));
					}
					$RoomInfo->name = $name;
					$RoomInfo->room_condition = $room_condition;
					$RoomInfo->updated_at = date("Y-m-d H:i:s",strtotime("now"));
					if($RoomInfo->validate()){
						$RoomInfo->save(false);
					}else{
						$result['errorMessage'] = print_r($RoomInfo->getErrors(), true);
						}
					}
				}
			}
		}else{
			//echo '<pre>';print_r($model->getErrors());exit;
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Room the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Room::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Room $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Room-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
	public function actionOptions() { 
		$hotelId = 0;
		$optionId = 0;
		if(isset($_GET['id'])) {
			$hotelId = $_GET['id'];
		}
		
		$model = new Equipment;
		$model->hotel_id = $hotelId;
		$optionInfo = array();
		if(!empty($_GET['optionid'])) {
			$optionId = $_GET['optionid'];
			$model = Equipment::model()->findByPk($optionId);
			foreach($model->roomOptionInfos as $roomOptionInfo) {
				$optionInfo[$roomOptionInfo->language_id]['description'] = $roomOptionInfo->description;
				$optionInfo[$roomOptionInfo->language_id]['term_condition'] = $roomOptionInfo->term_condition;
			}
		}
		if(isset($_REQUEST['Equipment']))
		{
			$optionId = $_REQUEST['Equipment']['id'];
			if($optionId != 0) {
				$model = Equipment::model()->findByPk($optionId);
			}
			$data = array();
			$data['model'] = $model;
			$data['optionInfo'] = $_REQUEST['Equipment']['OptionInfo'];
			unset($_REQUEST['Equipment']['OptionInfo']);
			$data['params'] = $_REQUEST['Equipment'];
			$result = $this->saveOptionData($data, $optionId);
			echo json_encode($result);
			Yii::app()->end();
		}
			
		$this->render('options',array('id'=>$hotelId, 'optionId'=>$optionId, 'model' => $model, 'optionInfo' => $optionInfo));
	}
	
	public function saveOptionData($data, $id=0){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$optionInfo = $data['optionInfo'];
		$model->attributes=$params;
		$model->base_type=1;//Options
		$model->type='room';
		if($id == 0) {
			$model->added_at = date("Y-m-d H:i:s");
		}
		$model->updated_at = date("Y-m-d H:i:s");
		if($model->validate()){
			$addSql = ($id > 0)? " and id!=".$id : "";
			$name = $params['name'];
			$flag=$model::model()->find("name='$name' $addSql and type='room' and base_type = 1");
			if($flag)
				$result['status']="NAME-ERROR";
			else{
				if($model->save()){
					$equipment_id = $model->id;
					//Get option info if found update else insert
					foreach ($optionInfo as $langId => $optInfo) {
						$optionInfoObj = RoomOptionInfo::model()->find("equipment_id = $equipment_id and language_id = $langId");
						if($optionInfoObj) {
								
						} else {
							$optionInfoObj = new RoomOptionInfo;
							$optionInfoObj->added_at = date("Y-m-d H:i:s");
						}
						$optionInfoObj->equipment_id = $equipment_id;
						$optionInfoObj->language_id = $langId;
						$optionInfoObj->description = $optInfo['description'];
						$optionInfoObj->term_condition = $optInfo['term'];
						$optionInfoObj->updated_at = date("Y-m-d H:i:s");
	
						$optionInfoObj->save();
					}
					$result['status']="SUCCESS";
					$result['equipment']['id']=$equipment_id;
				}
			}
		}else{
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	
	public function actionChangestatus()
	{
		$equipmentid = $_REQUEST['equipmentid'];
		//$pk = $_REQUEST['primary'];
		$post=Equipment::model()->findByPk($equipmentid);
		if($post->status == 1)
		{
			$post->status = 0;
		}else {
			$post->status = 1;
		}
		if($post->save())
		{echo "saved"; }
	}
	public function actionSaveroominfoprice()
	{
		$price = $_REQUEST['price'];
		$pk = $_REQUEST['primary'];
		$post=RoomOptions::model()->findByPk($pk);
		$post->price=$price;
		if($post->save())
		{echo "saved"; }
	}
	
	public function actionTariff($id)
	{
		/* $connection = Yii::app()->db;
		$cmodel = City::model();
		$city = $cmodel->findAll();
		foreach ($city as $ky=>$ct):
			$slug = BaseClass::Slugunique($cmodel,$ct->name,$ct->id);
			$sqlStatement = "update `tbl_city` set `slug`= '".$slug."' where `id`=".$ct->id;
			$command=$connection->createCommand($sqlStatement);
			$command->execute();
		endforeach; */
		
		$model=Room::model()->findAll("hotel_id=$id");
		$rmcount=Room::model()->count("hotel_id=$id");
		
		$tariff = RoomTariff::model();
		$this->render('rmtariff',array(
				'model'=>$model,
				'tariff'=>$tariff,
				'hotel_id'=>$id,
				'type'=>'tariff',
				'rmcount'=>$rmcount
		));
	}
	
	public function actionStariff()
	{
		$result['status']="ERROR";
		$result['id']=$_POST['hotel_id'];
		$err=0;
		
		// lowest room price
		$lwprice = 0;
		
		// Get the default currency id for the hotel
		$hotel = Hotel::model()->find("id=".$_POST['hotel_id']);
		$currency_id = ($hotel->default_currency_id!=0)? $hotel->default_currency_id : 1;
	
		$tariff = RoomTariff::model();
		$connection = Yii::app()->db;
	
		if($_POST['form_type']==1)
		{
			if($_POST['start_date']!="" && $_POST['end_date']!="")
			{
				$datetime1 = new DateTime($_POST['start_date']);
				$datetime2 = new DateTime($_POST['end_date']);
					
				// Check the date range valid or not
				if($datetime1 <= $datetime2)
				{
					if(isset($_POST['dy']))
					{
						
						$begin = strtotime($_POST['start_date']); // Convert date to a UNIX timestamp						
						$end = strtotime($_POST['end_date']); // Convert date to a UNIX timestamp
						
						/*
						// Get the dates between the range
						$begin = new DateTime($_POST['start_date']);
						$end = new DateTime($_POST['end_date']);
						$end = $end->modify( '+1 day' );
	
						$interval = new DateInterval('P1D');
						$daterange = new DatePeriod($begin, $interval ,$end);
						*/
	
						$room_no = $room_wpr = 0;
						
						
						foreach($_POST['room'] as $room_id => $room_price)
						{
							$room_no++;
							
							//Room specific lowest price to get the best deal information
							$rm_lowestPrice = 0;
							
							if($room_price!="")
							{
								// Set the lowest price irrespective of the room ids
								$lwprice = ($lwprice == 0 || $lwprice > $room_price)? $room_price : $lwprice;
								
								// Set the lowest price for the specific room id
								//$rm_lowestPrice = ($rm_lowestPrice == 0 || $rm_lowestPrice > $room_price)? $room_price : $rm_lowestPrice;
								
								$room_wpr ++;
	
								//foreach($daterange as $date){
								// Loop from the start date to end date and output all dates inbetween
								for ($i=$begin; $i<=$end; $i+=86400) {
								
									//$dt = $date->format("Y-m-d");
									$dt = date("Y-m-d", $i);
									$dname = date('D', strtotime($dt));
										
									//Check the day is asked for?
									if(array_key_exists($dname,$_POST['dy']))
									{
										$condition = "room_id='".$room_id."' and price='".$room_price."' and tariff_date = '".$dt."'";
										$recExists = $tariff->exists($condition);
											
										// The record has no updated information..take only those have any update info
										if(!$recExists)
										{
											$condition2 = "room_id='".$room_id."' and tariff_date = '".$dt."'";
											$recExists2 = $tariff->exists($condition2);
											
											if($recExists2)
											{
												$sqlStatement = "update `tbl_room_tariff` set `price`= '".$room_price."',`updated_at`=now() where `room_id`='".$room_id."' and `tariff_date`='".$dt."'";
											}
											else
											{
												$sqlStatement = "INSERT INTO  `tbl_room_tariff` (`id`,`room_id`,`tariff_date`,`price`,`currency_id`,`added_at`,`updated_at`)
												VALUES (NULL,$room_id,'$dt',$room_price,$currency_id,now(),CURRENT_TIMESTAMP)";
											}
											$command=$connection->createCommand($sqlStatement);
											$command->execute();
										}										
									}
								}
							}
						}
						if($room_no==0)
						{
							$err =1;
							$msg = "Create Room First";
						}
						else
						{
							if(!$room_wpr)
							{
								$err =1;
								$msg = "Atleast enter price for one room";
							}
						}
					}
					else
					{
						$err =1;
						$msg="Select days";
					}
				}
				else
				{
					$err =1;
					$msg="Invalid date range";
				}
			}
			else
			{
				$err =1;
				$msg="Enter Start and End Date in proper format";
			}
		}
		else
		{
			$year = isset($_REQUEST['prenextyear'])?$_REQUEST['prenextyear']:date('Y');
			$curdate=strtotime(date('Y-m-d'));
		
			foreach($_POST['room'] as $room_id => $trDate)
			{
				foreach ($trDate as $tdt => $room_price)
				{
					// Set the lowest price irrespective of the room ids
					$lwprice = ($lwprice == 0 || $lwprice > $room_price)? $room_price : $lwprice;
					
					// Can only set the price for the current and future days
					$mdt =  strtotime($tdt);
					if($curdate <= $mdt)
					{
						//Check if the record already exits or not
						$condition = "room_id='".$room_id."' and price='".$room_price."' and tariff_date = '".$tdt."'";
						$recExists = $tariff->exists($condition);
							
						// The record has no updated information..take only those have any update info
						if(!$recExists)
						{
							$condition2 = "room_id='".$room_id."' and tariff_date = '".$tdt."'";
							$recExists2 = $tariff->exists($condition2);
							
							if($recExists2)
							{
								$sqlStatement = "update `tbl_room_tariff` set `price`= '".$room_price."',`updated_at`=now() where `room_id`='".$room_id."' and `tariff_date`='".$tdt."'";
							}
							else
							{
								$sqlStatement = "INSERT INTO  `tbl_room_tariff` (`id`,`room_id`,`tariff_date`,`price`,`currency_id`,`added_at`,`updated_at`)
								VALUES (NULL,$room_id,'$tdt',$room_price,$currency_id,now(),CURRENT_TIMESTAMP)";
							}
							$command=$connection->createCommand($sqlStatement);
							$command->execute();
						}						
					}
				}
			}
		}
		// Update the room least price and best deal for the hotel
		//$lwprice
		
		if(!$err)
			$result['status']="SUCCESS";
	
		$result['msg'] = ($err)? $msg : "";
						echo json_encode($result);
						Yii::app()->end();
	}
	
	public function actionAvailability($id,$rmstatus="open")
	{
		$rmcount=Room::model()->count("hotel_id=$id");
		$model=Room::model()->findAll("hotel_id=$id");
		$avail = RoomAvailability::model();
		
		// Check the availability data for the current year
		$year = isset($_REQUEST['prenextyear'])?$_REQUEST['prenextyear']:date('Y');
		$avdate = $year."-01-01";
		$endate = $year."-12-31";
		$avr = array();
		// Construct array with $av[room_id][month_no][dayno] = room_nb - status
		foreach ($model as $ind=>$md):		
			$room_avail = $avail->findAll(array("condition"=>"`room_id`=".$md->id." and availability_date >= '".$avdate."' and availability_date <='".$endate."'","order"=>"availability_date"));	
			foreach ($room_avail as $aky=>$av):
				$dm = date("n", strtotime($av->availability_date));
				$avr[$md->id][$dm][$av->availability_date] = $av->nb_rooms."-".$av->room_status;				
			endforeach;		
		endforeach;

		$rstatus_model = RoomStatusDef::model();
		
		$this->render('rmavailability',array(
				'model'=>$model,
				'avdetail'=>$avr,
				'avail'=>$avail,
				'hotel_id'=>$id,
				'type'=>'availability',
				'rmstatus'=>$rmstatus,
				'rstatus_model'=>$rstatus_model,
				'rmcount'=>$rmcount
		));
	}
	
	public function actionSavailability()
	{
		$result['status']="ERROR";
		$result['id']=$_POST['hotel_id'];
		$result['rmstatus']=$_POST['rmstatus'];
		$err=0;
		
		$avail = RoomAvailability::model();
		$connection = Yii::app()->db;
		
		$default_status = $_POST['rmstatus'];
		$year = isset($_REQUEST['prenextyear'])?$_REQUEST['prenextyear']:date('Y');
		$curdate=strtotime(date('Y-m-d'));
		if($_POST['form_type']==1)
		{
			if($_POST['start_date']!="" && $_POST['end_date']!="")
			{
				$datetime1 = new DateTime($_POST['start_date']);
				$datetime2 = new DateTime($_POST['end_date']);
					
				// Check the date range valid or not
				if($datetime1 <= $datetime2)
				{
					$hotelObject = Hotel::model()->findByPk($_REQUEST['hotel_id']);
					
					$begin = strtotime($_POST['start_date']); // Convert date to a UNIX timestamp
					$end = strtotime($_POST['end_date']); // Convert date to a UNIX timestamp
		
					$room_no = $room_wpr = 0;		
					$desc_date= array();
					
					foreach($_POST['room'] as $room_id => $nb_rooms)
					{
						$room_no++;
							
						if($nb_rooms!="")
						{
							if($nb_rooms=="FS")
								$nb_rooms = 0;
							
							$room_wpr++;
							
							// Loop from the start date to end date and output all dates inbetween
							for ($i=$begin; $i<=$end; $i+=86400) {
		
								$tdt = date("Y-m-d", $i);
								$room_status = (isset($_POST['room_status']))? $_POST['room_status'] : $default_status;
		
								//Check if the record already exits or not
								$condition = "room_id='".$room_id."' and room_status='".$room_status."' and nb_rooms='".$nb_rooms."' and  availability_date = '".$tdt."'";
								$recExists = $avail->exists($condition);
					
								// The record has no updated information..take only those have any update info
								if(!$recExists)
								{
									$condition2 = "room_id='".$room_id."' and  availability_date = '".$tdt."'";
									$recExists2 = $avail->exists($condition2);
										
									if($recExists2)
									{
										$exavail = $avail->find($condition2);
										$prev_val = $exavail->nb_rooms;
										
										$action = true;
										$access = Yii::app()->user->getState('access');
										if($access=="manager"){
											if($nb_rooms < $prev_val){
										
												$countDescDate = count($desc_date);
												if(!in_array($tdt, $desc_date)){
													if(($countDescDate >= $hotelObject->auth_dec)){
														$action = false;
													}else{
														array_push($desc_date,$tdt);
													}
												}
											}
										}
										if($action)
											$sqlStatement = "update `tbl_room_availability` set `nb_rooms`= '".$nb_rooms."',`room_status` = '".$room_status."',`updated_at`=now() where `room_id`='".$room_id."' and `availability_date`='".$tdt."'";
									}
									else
									{
										$sqlStatement = "INSERT INTO  `tbl_room_availability` (`id`,`room_id`,`availability_date`,`nb_rooms`,`room_status`,`added_at`,`updated_at`)
										VALUES (NULL,$room_id,'$tdt',$nb_rooms,'$room_status',now(),CURRENT_TIMESTAMP)";
									}
									$command=$connection->createCommand($sqlStatement);
									$command->execute();
										
								}
							}
						}
					}
					if($room_no==0)
					{
						$err =1;
						$msg = "Create Room First";
					}
					else
					{
						if(!$room_wpr)
						{
							$err =1;
							$msg = "Atleast enter available number for one room";
						}
					}	

					if(count($desc_date))
					{
						$dec_no = count($desc_date);
					
						$hotelObject->auth_dec = $hotelObject->auth_dec - $dec_no;
						$hotelObject->save();
					}
				}
				else
				{
					$err =1;
					$msg="Invalid date range";
				}
			}
			else
			{
				$err =1;
				$msg="Enter Start and End Date in proper format";
			}
		}
		else 
		{
			$decAuth = false;
			$hotelObject = Hotel::model()->findByPk($_REQUEST['hotel_id']);
			$desc_date= array();
			
			foreach($_POST['room'] as $room_id => $trDate)
			{
				foreach ($trDate as $tdt => $nb_rooms)
				{
					// Can only set the days for the current and future days
					if($nb_rooms=="FS")
						$nb_rooms = 0;
					$mdt =  strtotime($tdt);
					if($curdate <= $mdt)
					{ 
						$room_status = (isset($_POST[$room_id."-".$tdt]))? $_POST[$room_id."-".$tdt] : $default_status;
						$prev_val = (isset($_POST["pval-".$room_id."-".$tdt]))? $_POST["pval-".$room_id."-".$tdt] : 0;
						
							
						$action = true;
						$access = Yii::app()->user->getState('access');
						if($access=="manager"){							
							if($nb_rooms < $prev_val){
								
								$countDescDate = count($desc_date);
								if(!in_array($tdt, $desc_date)){
									if(($countDescDate >= $hotelObject->auth_dec)){
										$action = false;
									}else{
										array_push($desc_date,$tdt);										
									}
								}
							}
						}
						//Check if the record already exits or not
						$condition = "room_id='".$room_id."' and room_status='".$room_status."' and nb_rooms='".$nb_rooms."' and  availability_date = '".$tdt."'";
						$recExists = $avail->exists($condition);
			
						// The record has no updated information..take only those have any update info
						if(!$recExists && $action)
						{
							$condition2 = "room_id='".$room_id."' and  availability_date = '".$tdt."'";
							$recExists2 = $avail->exists($condition2);
								
							if($recExists2)
							{
								$sqlStatement = "update `tbl_room_availability` set `nb_rooms`= '".$nb_rooms."',`room_status` = '".$room_status."',`updated_at`=now() where `room_id`='".$room_id."' and `availability_date`='".$tdt."'";
							}
							else
							{
								$sqlStatement = "INSERT INTO  `tbl_room_availability` (`id`,`room_id`,`availability_date`,`nb_rooms`,`room_status`,`added_at`,`updated_at`)
								VALUES (NULL,$room_id,'$tdt',$nb_rooms,'$room_status',now(),CURRENT_TIMESTAMP)";
							}
							$command=$connection->createCommand($sqlStatement);
							$command->execute();
								
						}						
					}
				}
			}
			if(count($desc_date))
			{
				$dec_no = count($desc_date);
				
				$hotelObject->auth_dec = $hotelObject->auth_dec - $dec_no;
				$hotelObject->save();
			}
		}
		if(!$err)
			$result['status']="SUCCESS";
		
		$result['msg'] = ($err)? $msg : "";
		echo json_encode($result);
		Yii::app()->end();
	}
	public function actionChangeequipment()
	{
		$roomid = $_REQUEST['roomid'];
		$eqarray = array();
		$roomopts = RoomOptions::model()->findAllByAttributes(array('room_id'=>$roomid));
		foreach($roomopts as $geteqids){
			$eqarray[]=$geteqids->equipment_id;
		}
		$criteria = new CDbCriteria;
		$criteria->addNotInCondition("id",$eqarray);
		$criteria->addCondition("status=1");
		$equipments=Equipment::model()->findAll($criteria);
	
	
	
		echo "<select name = 'Roomop[equipment_id]' class='form-control select2me'>";
		foreach ($equipments as $equip)
		{
			echo "<option value='$equip->id'>".$equip->name."</option>";
		}
		echo"</select>";
	
	}
	public function actionDeloptions(){
		if(isset($_REQUEST['prime']))
		{
			$primekey = $_REQUEST['prime'];
			$delrow = RoomOptions::model()->findByPk($primekey);
			$delrow->delete();
		}		
	}
	
	public function actionDeleteoption($id)
	{
		$model = Equipment::model()->findByPk($id);
		$hotelId = $model->hotel_id;
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('/admin/room/options?id='.$hotelId.'&type=option'));
	}
	
	public function getCategoryName($data,$row)
	{
		if($data->category == "sun") {
			$name = "DayUse";
		}else if($data->category == "halfsun")
		{
			$name = "Late break";
		}else{
			$name = "Night";
		}
		return $name; 
	} 
	public function getSlot($data,$row)
	{
		$gettime = Room::model()->findByPk($data->id);
		$timefrom = new DateTime($gettime->available_from);
		$timetill = new DateTime($gettime->available_till);
		$alltime = $timefrom->format('h:i A')." - ".$timetill->format('h:i A');
		return $alltime; 
	}
	public function getPrice($data,$row)
	{
		$gettime = Room::model()->findByPk($data->id);
		
			if($data->category == "sun") {
				$price = $gettime->default_discount_price." (".$gettime->default_price.")";
			}else if($data->category == "halfsun")
			{
				$price = $gettime->default_discount_price." (".$gettime->default_price.")";
			}else{
				$price = $gettime->default_discount_night_price." (".$gettime->default_night_price.")";
			}
		return $price;
	}
}
