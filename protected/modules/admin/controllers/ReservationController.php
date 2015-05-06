<?php

class ReservationController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','edit','reservationstatus',
                                    'reservationbydate','pendingreservation','refusedreservation',
                                    'onrequest','viewconfirmed'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

 
        
        public function actionOnRequest() {
            $userId = Yii::app()->user->getState('user_id');
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            if($userId) {
                $hotelIdArray = CommonHelper::getHotelByUserId($userId);
                if($hotelIdArray){
                    $hotelIdString = implode(",",$hotelIdArray);
                    $hotelObjectList = Hotel::model()->findAll(array('condition' =>'id IN (' . $hotelIdString.')'));
                    $roomIdArray = '';
                    foreach($hotelObjectList as $hotelObject){
                        foreach($hotelObject->rooms() as $room){
                            $roomIdArray[] = $room->id;
                        }
                    }
                    if($roomIdArray) {
                        $roomIdString = implode(",",$roomIdArray); 
                        $model = new Reservation();
                        $dataProvider = new CActiveDataProvider('Reservation',array(
                                        'criteria'=>array(
                                                        'condition'=> ('room_id IN (' . $roomIdString.') and reservation_status = 2'  ),'order'=>'id DESC',
//                                        				'pagination' => array('pageSize' => $pageSize),
                                        )));
                        $originObject = Portal::model()->findAll();
                        $this->render('onrequest',array(
                                'dataProvider'=>$dataProvider,
                                'model'=>$model,
                                'originObject'=>$originObject,
                                'reservationCount' => 0,
                                'showDateFlag' => '',
                                'selectedMonth'=>date('m')
                        ));
                    }
                } else {
                    echo "No hotel access";exit;
                }
            }
        }
        
        public function actionViewConfirmed() { 
            $userId = Yii::app()->user->getState('user_id'); 
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            if($userId) {
                $hotelIdArray = CommonHelper::getHotelByUserId($userId);
                if($hotelIdArray){
                    $hotelIdString = implode(",",$hotelIdArray); 
                    $hotelObjectList = Hotel::model()->findAll(array('condition' =>'id IN (' . $hotelIdString.')'));
                    $roomIdArray = '';
                    foreach($hotelObjectList as $hotelObject){
                        foreach($hotelObject->rooms() as $room){
                            $roomIdArray[] = $room->id;
                        }
                    }
                    if($roomIdArray) {
                        $roomIdString = implode(",",$roomIdArray);
                        $model = new Reservation();
                        $dataProvider = new CActiveDataProvider('Reservation',array(
                                        'criteria'=>array(
                                                        'condition'=> ('room_id IN (' . $roomIdString.') and reservation_status = 1'  ),'order'=>'id DESC',
//                                        				'pagination' => array('pageSize' => $pageSize),
                                        )));
                        $originObject = Portal::model()->findAll();

                        $this->render('confirmed',array(
                                'dataProvider'=>$dataProvider,
                                'model'=>$model,
                                'originObject'=>$originObject,
                                'reservationCount' => 0,
                                'showDateFlag' => '',
                                'selectedMonth'=>date('m')
                        ));
                    }
                } else {
                    echo "No hotel access";exit;
                }
            }
        }

        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($nbReservationId="")
	{   
            if(empty($_REQUEST['rid'])){ 
                $message = '';
                $this->render('searchReservation',array('errorMessage'=>$message));
            } else {
                $nbReservationId = $_REQUEST['rid'];
                $portalId = $_REQUEST['portal'];
            }
            $portalObject = "";
            if($portalId){
                $portalObject = Portal::model()->findByPk($portalId);
            }
            $reservationObject = Reservation::model()->findByAttributes(array('nb_reservation' => $nbReservationId));
            if(empty($reservationObject)){
                $message = 'Reservation does not exist!';
                $this->render('searchReservation',array('errorMessage'=>$message));
            }
            $customerObject =  Customer::model()->findByPk($reservationObject->customer_id);
            $roomObject =  Room::model()->findByPk($reservationObject->room_id);
            $hotelObject =  Hotel::model()->findByPk($roomObject->hotel_id);
            $reservationOptionObject = ReservationOption::model()->findAll('reservation_id = '. $reservationObject->id);
            $this->render('view',array(
                    'reservationObject'=>$reservationObject,
                    'customerObject'=>$customerObject,
                    'roomObject'=>$roomObject,
                    'hotelObject'=>$hotelObject,
                    'reservationOptionObject'=>$reservationOptionObject,
                    'portalObject'=>$portalObject
            ));
	}
        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionReservationStatus($nbReservationId="")
	{
            if($_REQUEST) { 
                $portalId = 1;
                if(!empty($_REQUEST['portal'])){
                    $portalId = $_REQUEST['portal'];
                }
                //update customer data
                $customerObject =  Customer::model()->findByPk($_REQUEST['customer_id']);
                $reservationObject =  Reservation::model()->findByPk($_REQUEST['reservation_id']);
                $this->setReservationActions($customerObject, $reservationObject, $_REQUEST['admin_action']);
                if(isset($_REQUEST['manager'])){
                    $this->redirect(array('/admin/reservation/viewconfirmed'));
                } else {
                    $this->redirect(array('/admin/reservation/view','rid'=>$reservationObject->nb_reservation,'portal'=>$portalId));
                }
            }
            
        }
        
        public function setReservationActions($customerObject, $reservationObject, $actionId){
                if($actionId == 1){ //send mail
                    $res = $this->sendConfirmationSMS($reservationObject); // 1: sms
                    if($res->messages['0']->status!=0)
                    {
                        $message = '';
                        foreach ($res->messages['0'] as $ky=>$val):
                            $message .= $val."--";
                        endforeach;
                        $level='error';
                        $category='sms.failure';
                        Yii::log($message, $level, $category);
                    }
                    $this->actionSendConfirmationEmail($reservationObject->id);
                }elseif($actionId == 2){
                    $reservationObject->reservation_status = 5;//No Show id
                    $customerObject->status = 3; // greay list
                } elseif($actionId == 3){
                    $reservationObject->reservation_status = 6;//admin cancel reservation
                } elseif($actionId == 4){
                    $customerObject->status = 2;//add to black list
                } elseif($actionId == 5){
                    $reservationObject->reservation_status = 1;//confirmed
                    
                    if($reservationObject->confirmation_type == 0)
                    {
                        $this->actionSendConfirmationEmail($reservationObject->id);
                        $this->sendConfirmationSMS($reservationObject);
                    }
                    else
                    {
                        if($reservationObject->confirmation_type == 2){ //2: send email
                            $this->actionSendConfirmationEmail($reservationObject->id);
                        } else {
                            $this->sendConfirmationSMS($reservationObject); // 1: sms
                        }
                    }
                } elseif($actionId == 6){
                    $reservationObject->reservation_status = 4;//refused
                } elseif($actionId == 7){ // send mail to hotel
                    $this->actionSendConfirmationEmail($reservationObject,1);
                } else { //send mail
                    $this->actionSendConfirmationEmail($reservationObject->id);
                }
                $customerObject->save();
                $reservationObject->save();
                return 1;
        }

        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEdit()
	{  
            $reservationOptionModel = new ReservationOption;
            if($_REQUEST){
                if(isset($_REQUEST['hotelId'])){
                    $hotelId = $_REQUEST['hotelId'];
                }
                if(isset($_REQUEST['roomId'])){
                    $roomId = $_REQUEST['roomId'];
                }
                if(isset($_REQUEST['date'])){
                    $roomBookingDate = $_REQUEST['date'];
                }
                if(isset($_REQUEST['rid'])){
                    $reservationId = $_REQUEST['rid'];
                }
                if(isset($_REQUEST['portal'])){
                	$portal = $_REQUEST['portal'];
                }
                if(isset($_REQUEST['orf'])){
                    $onRequestFlag= $_REQUEST['orf'];
                }
            }
            $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationId);
            $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);
            
            $reservationObject = Reservation::model()->findByPk($reservationId);
            
            $hotelObject = Hotel::model()->findByPk($hotelId);
            $roomObject = Room::model()->findByPk($roomId);
            $roomOptionCondition = array('condition' => 'room_id =' . $roomId);
            $roomOptionObject = RoomOptions::model()->findAll($roomOptionCondition);
            if(!empty($reservationObject)){
                $customerId = $reservationObject->customer_id;
            }

            $customerObject = Customer::model()->findByPk($customerId);
            // $this->performAjaxValidation($model);
            $originObject = Origin::model()->findAll();
          
            if ($_POST) { 
                $postDataArray = $_POST;
                //create customre 
                $customreArrayObject = $this->getCustomerArray($customerObject, $postDataArray);
                $customreArrayObject->save();
                $customerId = $customreArrayObject->id;
                //Insert into reservation table
                $reservationObject = $this->getReservationArray(
                        $reservationObject, $roomObject, $customerId, $postDataArray);
                $reservationObject->save();
                
                $reservationId = $reservationObject->id;

                //delete remaining reservation option
                $deleteReservationOption = ReservationOption::model()->findAll(array('condition'=>'reservation_id = '.$reservationId));
                
                if(count($deleteReservationOption) > 0){ 
                    foreach($deleteReservationOption as $reservationOptions){
                        $reservationOptions->delete();
                    }
                }
                //aditional services
                if (!empty($postDataArray['aditional_services'])) {
                    $this->addSelectedServices($postDataArray['aditional_services'],$reservationId);
                }
                /*if(!empty($postDataArray['reservation_confirmation_via_text'])) {
                    $this->sendConfirmationSMS($reservationObject); // 1: sms
                } */
                if(!empty($postDataArray['admin_action'])){
                    $this->setReservationActions($customerObject, $reservationObject, $postDataArray['admin_action']);
                }
                if($reservationId){
                    $this->redirect('/admin/reservation');
                }
                
            }
            
           
        $this->render('create', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $roomBookingDate,
            'roomOptionObject' => $roomOptionObject,
                'originObject' => $originObject,
            'customerObject' =>$customerObject,
            'reservationOptionObject'=>$reservationOptionObject,
            'portal'=>$portal,
            'reservationCode' => '',
            'onRequestFlag' => $onRequestFlag,
            'reservationObject' => $reservationObject,
            'actionMode'=>'edit',
        ));
            
        }
        
        /**
        * Save services in to db
        * 
        * @param type $postDataArray
        */
       public function addSelectedServices($postDataArray, $reservationId){
           foreach ($postDataArray as $services) {
               $reservationOptionModel = new ReservationOption;
               $serviceAndPrice = explode("_", $services); //$services
               $reservationOptionModel->reservation_id = $reservationId;
               $reservationOptionModel->equipment_id = $serviceAndPrice['0'];
               $reservationOptionModel->equipment_price = $serviceAndPrice['1'];
               $reservationOptionModel->added_at = new CDbExpression('NOW()');
               $reservationOptionModel->updated_at = new CDbExpression('NOW()');
               //Inserte in reservation option table
               $reservationOptionModel->save();
           }
       }
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
				
            $customerModel = new Customer;
            $reservationModel = new Reservation;
            $reservationOptionModel = new ReservationOption;
            
  
            if($_REQUEST){
                if(isset($_REQUEST['hotelId'])){
                    $hotelId = $_REQUEST['hotelId'];
                }
                if(isset($_REQUEST['roomId'])){
                    $roomId = $_REQUEST['roomId'];
                }
                if(isset($_REQUEST['date'])){
                    $roomBookingDate = $_REQUEST['date'];
                }
                if(isset($_REQUEST['orf'])){
                    $onRequestFlag= $_REQUEST['orf'];
                }
                if(isset($_REQUEST['portal'])){
                	$portal = $_REQUEST['portal'];
                }
                if(isset($_REQUEST['destination'])){
                	$destination = $_REQUEST['destination'];
                }
                
            }
            $hotelObject = Hotel::model()->findByPk($hotelId);
            $roomObject = Room::model()->with('roomInfos')->findByPk($roomId);
            $roomOptionCondition = array('condition' => 'room_id =' . $roomId);
            $roomOptionObject = RoomOptions::model()->findAll($roomOptionCondition);
            $reservationCode =  mt_rand(100000000, 999999999);
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            $originObject = Origin::model()->findAll();
          
            if(isset($_POST['reservation_form'])){ 
            	$postDataArray = $_POST;

                //create customer
                $customreArrayObject = $this->getCustomerArray($customerModel, $postDataArray);
                $customreArrayObject->save();
                $customerId = $customreArrayObject->id;
                
                //Insert into reservation table
                $reservationObject = $this->getReservationArray($reservationModel, $roomObject, $customerId, $postDataArray);
                $reservationObject->save();
                
                $reservationId = $reservationObject->id;
            
                //aditional services
                if (!empty($postDataArray['aditional_services'])) {
                    $this->addSelectedServices($postDataArray['aditional_services'],$reservationId);
                }
                if($reservationId){
                    $memail = FALSE;
                    if(!empty($postDataArray['reservation_confirmation_via_text'])) {
                        $this->sendConfirmationSMS($reservationObject); // 1: sms
                    }
                    if(!empty($postDataArray['reservation_confirmation_via_email'])) {
                        $this->actionSendConfirmationEmail($reservationObject->id); //2: Email
                        $memail = TRUE;
                    }
                    if(!$memail)
                        $this->actionSendConfirmationEmail($reservationObject->id,1);
                    
                    InvReservation::model()->createInvoiceReservation($postDataArray,$reservationObject->reservation_status);
                    
                    $this->redirect('/admin/reservation');
                }
            }
        	
        $this->render('create', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $roomBookingDate,
            'roomOptionObject' => $roomOptionObject,
            'originObject' => $originObject,
            'reservationCode' =>$reservationCode,
            'customerObject' => '',
            'reservationOptionObject' => '',
            'onRequestFlag'=>$onRequestFlag,
            'reservationObject'=>'',
            'actionMode'=>'',
            'portal'=>$portal,
            'destination'=>$destination,
            'portalObject'=>"",
            'usersearch'=>$_REQUEST,
        ));     
           
    }

    /**
     * send reservation confirmation sms.
     * 
     * @param object $reservationObject
     * @return response
     */
    public function sendConfirmationSMS($reservationObject) {
        if(!empty($reservationObject)){
            $roomObject = Room::model()->findByPk($reservationObject->room_id);
            $hotelName = $roomObject->hotel->name;
            $address = $roomObject->hotel->address;
            $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
            if($reservationObject->reservation_status == 2)
                $title = "Reservation On Request.";
            else
                $title = "Reservation Successful.";
            
            $message = $title.' Res RefId: ' . $reservationObject->nb_reservation . '  HOTEL: ' .$hotelName .', on '. $reservationObject->res_date . ' Add : '.$address;
            $response = BaseClass::sendSMS($customerObject->country->country_code.$customerObject->telephone, $message);
            return $response;
        }
    }
    
    /**
     * get customre array
     * 
     * @param type $customerModel
     * @param type $customerPostArray
     * @return type
     */
    public function getCustomerArray($customerModel, $customerPostArray){
        $isSecret = 0;
        
        if(isset($customerPostArray['is_secret'])){
            $isSecret = $customerPostArray['is_secret'];
        }
        if(isset($customerPostArray['first_name'])){
            $customerModel->first_name = $customerPostArray['first_name'];
        }
        if(isset($customerPostArray['last_name'])){
            $customerModel->last_name = $customerPostArray['last_name'];
        }
        if(isset($customerPostArray['email_address'])){
            $customerModel->email_address = $customerPostArray['email_address'];
        }
        if (isset($customerPostArray['country_id'])) {
            $customerModel->country_id = $customerPostArray['country_id'];
        }
        if(isset($customerPostArray['telephone'])){
            $customerModel->telephone = $customerPostArray['telephone'];
        }
        if(isset($customerPostArray['password'])){
        	$customerModel->password = md5($customerPostArray['password']);
        }        
        if(isset($customerPostArray['input_verification_code'])){
            $customerModel->auth_code = $customerPostArray['input_verification_code'];
        }
        
        $customerModel->origin_id = 1;//$customerPostArray['origin_id']; //TODO: Need to confirm with team
        $customerModel->is_subscribed = $isSecret;
        $customerModel->status = 1;//TODO: need to verify with team
        $customerModel->added_at = new CDbExpression('NOW()');
        $customerModel->updated_at = new CDbExpression('NOW()');
        return $customerModel;
    }

    /**
     * 
     * @param type $reservationModel
     * @param type $roomObject
     * @param type $customerId
     * @param type $postData
     * @return type
     */
    public function getReservationArray($reservationModel, $roomObject, $customerId, $postData){
        
            $verificationCode = "12345"; //TODO= need to remove
            if(isset($postData['input_verification_code'])){
                $verificationCode = $postData['input_verification_code'];
            }
            $isSecret = 0;
            if(isset($postData['is_secret'])){
                $isSecret = $postData['is_secret'];
            }
            $comment = '';
            if(isset($postData['comment'])){
                $comment = $postData['comment'];
            }
            if(!empty($postData['reservation_code'])){
                 $reservationModel->nb_reservation = $postData['reservation_code'];
            }
            if(!empty($postData['country_id'])){
                $reservationModel->country_code = $postData['country_id'];
            }
            $reservationModel->customer_id = $customerId;
            
            $portal_id = (isset($postData['portal'])) ?  $postData['portal'] : YII::app()->params['default']['portalId'];
            $reservationModel->portal_id = $portal_id; 
            
            $reservationModel->room_id = $roomObject->id;
            if(!empty($postData['booking_date'])){
                $reservationModel->res_date = $postData['booking_date'];
            }
            $reservationModel->res_from = $roomObject->available_from;
            $reservationModel->res_to = $roomObject->available_till;
            
            $roomPr = RoomTariff::model()->find("room_id=".$roomObject->id." and tariff_date = '".$postData['booking_date']."'");
            $reservationModel->room_price = $roomPr->price;
            
            
            $reservationModel->currency_id = 1; //TODO: Need to confirm with team
            $reservationModel->comment = $comment;
            if(!empty($postData['arrival_time'])){
                $reservationModel->arrival_time = $postData['arrival_time'];
            }
            $reservationModel->is_secret = $isSecret;
            $reservationModel->reservation_code = $verificationCode;
            
            $res_status = ($postData['onRequestFlag']==1) ? 2 : 1;
            $reservationModel->reservation_status = $res_status;
            
            if(!empty($postData['reservation_confirmation_via_text']) && !empty($postData['reservation_confirmation_via_email']))
            {
                $reservationModel->confirmation_type = 0; // 0: email & sms
            }
            else
            {
                if(!empty($postData['reservation_confirmation_via_text'])) {
                    $reservationModel->confirmation_type = 1; // 1: sms
                }
                if(!empty($postData['reservation_confirmation_via_email'])){
                    $reservationModel->confirmation_type = 2; //2: Email
                }
            }

            $reservationModel->payment_status = 1;
            $reservationModel->added_by = Yii::app()->user->getstate('user_id');
            error_log(Yii::app()->user->getstate('user_id'));
            $reservationModel->updated_by = Yii::app()->user->getstate('user_id');
            
            $reservationModel->added_at = new CDbExpression('NOW()');
            $reservationModel->updated_at = new CDbExpression('NOW()');
            return $reservationModel;
        }
        
        /**
        * send email
        */
        public function actionSendMail($postDataArray, $reservationCode) {
            if ($postDataArray) {
                $to = $postDataArray['email'];
                $subject = 'Reservation Verification Code';
                //$message = "Hi,". $customerObject->first_name . " ". $customerObject->first_name . "< /br>";
                $message = "Hi, " . $postDataArray['customerName'] . " < /br>";
                $message = "Reservation code " . $reservationCode;

                return mail($to, $subject, $message);
            }
        }
    
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reservation']))
		{
			$model->attributes=$_POST['Reservation'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_REQUEST['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $model = new Reservation();
            $todayDate = date('Y-m-d');
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            $dataProvider = new CActiveDataProvider('Reservation',array(
                            'criteria'=>array(
                                            'condition'=> ('res_date >= "'.$todayDate . '" AND nb_reservation != 0 AND reservation_status = 1' ),'order'=>'id DESC',
                            ),'pagination' => array('pageSize' => $pageSize),));
            $originObject = Portal::model()->findAll();
            $reservationCount = Reservation::model()->count(array('condition'=> ('res_date >= "'.$todayDate . '" AND nb_reservation != 0 AND reservation_status = 1')));
            if(!empty($_REQUEST['res_search_filter'])){
                
                $criteria = new CDbCriteria;
                $criteria->with = array( 'customer','room.hotel' );
                $criteria->compare('nb_reservation', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.first_name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.telephone', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('hotel.name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->addCondition('res_date >= "'.$todayDate . '"');
                $dataProvider = new CActiveDataProvider('Reservation',array(
                    'criteria'=>$criteria,
                    'pagination' => array('pageSize' => $pageSize),));
                 $reservationCount = Reservation::model()->count($criteria);
            }
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'originObject'=>$originObject,
                    'reservationCount' => $reservationCount,
                    'showSearch' => '1',
                    'step'=>1,
                    'selectedMonth'=>date('m')
            ));
	}

        /**
	 * read reservation by date
	 */
	public function actionReservationByDate()
	{
            $month = date('m');
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            if(!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
                $toDay = '01';
                $fromDay = '31';
                $year = $_REQUEST['year'];
                $month = $_REQUEST['month'];
                if($month < 10){
                    $month = '0'.$_REQUEST['month'];
                }
                $status = $_REQUEST['res_filter'];
                $toDate = $year.'-'.$month.'-'.$toDay;
                $fromDate = $year.'-'.$month.'-'.$fromDay;
            } else {
                $toDate = date('Y-m-01');
                $fromDate = date('Y-m-31');
                $status = 1;
            }
            $condition = "  AND nb_reservation != 0 AND reservation_status = ". $status;
            if(!empty($_REQUEST['res_filter']) && $_REQUEST['res_filter'] == 8){
                $condition = "  AND nb_reservation != 0 ";
            }
            $model = new Reservation();
            $dataProvider = new CActiveDataProvider('Reservation',array(
                            'criteria'=>array(
                                            'condition'=> ('res_date >= "'.$toDate . '" AND res_date <= "'.$fromDate . '"'.$condition),
                            ),'pagination' => array('pageSize' => $pageSize),));
            
            $originObject = Portal::model()->findAll();
            $reservationCount = Reservation::model()->count(array('condition'=> ('res_date >= "'.$toDate . '" AND res_date <= "'.$fromDate . '"' . $condition)));
            $showDateFlag = 1;
            if(!empty($_REQUEST['res_search_filter'])){
                
                $criteria = new CDbCriteria;
                $criteria->with = array( 'customer','room.hotel' );
                $criteria->compare('nb_reservation', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.first_name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.telephone', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('hotel.name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->addBetweenCondition('res_date', $toDate, $fromDate);
                $dataProvider = new CActiveDataProvider('Reservation',array(
                    'criteria'=>$criteria,
                    'pagination' => array('pageSize' => $pageSize),));
                $reservationCount = Reservation::model()->count($criteria);
            }
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'originObject'=>$originObject,
                    'reservationCount' => $reservationCount,
                    'showDateFlag' => $showDateFlag,
                    'step'=>2,
                    'selectedMonth'=>$month
            ));
	}
        
        /**
	 * Lists all models.
	 */
	public function actionPendingReservation()
	{  
            $model = new Reservation();
            $todayDate = date('2020-m-d');
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            //read pending reservation and status flag is 2
            $dataProvider = new CActiveDataProvider('Reservation',array(
                            'criteria'=>array(
                                            'condition'=> ('reservation_status = 2 AND nb_reservation != 0'),
                            ),'pagination' => array('pageSize' => $pageSize),));
            $originObject = Portal::model()->findAll();
            $reservationCount = Reservation::model()->count(array('condition'=> ('reservation_status = 2 AND nb_reservation != 0')));
            
            if(!empty($_REQUEST['res_search_filter'])){
                
                $criteria = new CDbCriteria;
                $criteria->with = array( 'customer','room.hotel' );
                $criteria->compare('nb_reservation', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.first_name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.telephone', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('hotel.name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->addCondition('reservation_status = 2 ');
                $dataProvider = new CActiveDataProvider('Reservation',array(
                    'criteria'=>$criteria,
                    'pagination' => array('pageSize' => $pageSize),));
                 $reservationCount = Reservation::model()->count($criteria);
            }
            
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'originObject'=>$originObject,
                    'reservationCount' => $reservationCount,
                    'showDateFlag' => '',
                    'pendingFlag' => '1',
                    'step'=>3,
                    'selectedMonth'=>date('m')
            ));
        }
            /**
	 * Lists all models.
	 */
	public function actionRefusedReservation()
	{  
            $model = new Reservation();
            $todayDate = date('2020-m-d');
            $pageSize = Yii::app()->params['defaultPageSize'];
            
            //read refused reservation and status flag is 3
            $dataProvider = new CActiveDataProvider('Reservation',array(
                            'criteria'=>array(
                                            'condition'=> ('reservation_status = 7'),//7:Refused
                            				
                            ),'pagination' => array('pageSize' => $pageSize),));
            $originObject = Portal::model()->findAll();
            $reservationCount = Reservation::model()->count(array('condition'=> ('reservation_status = 7')));
            
            if(!empty($_REQUEST['res_search_filter'])){
                
                $criteria = new CDbCriteria;
                $criteria->with = array( 'customer','room.hotel' );
                $criteria->compare('nb_reservation', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.first_name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('customer.telephone', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->compare('hotel.name', $_REQUEST['res_search_filter'], true, 'OR');
                $criteria->addCondition('reservation_status = 7 ');
                $dataProvider = new CActiveDataProvider('Reservation',array(
                    'criteria'=>$criteria,
                    'pagination' => array('pageSize' => $pageSize),));
                $reservationCount = Reservation::model()->count($criteria);
            }
            
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
                    'model'=>$model,
                    'originObject'=>$originObject,
                    'reservationCount' => $reservationCount,
                    'showDateFlag' => '',
                    'refusedFlag' => '1',
                    'step'=>4,
                    'selectedMonth'=>date('m')
            ));
	}
        
        
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reservation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_REQUEST['Reservation']))
			$model->attributes=$_REQUEST['Reservation'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
    /**
     * Get the reservation status
     * 
     * @param type $data 
     * @param type $row
     */
    public function getReservationStatus($data, $row) {
    $url = Yii::app()->createUrl("/admin/reservation/view", array("rid" => $data->nb_reservation, "portal" => $data->portal->id));
        switch ($data->reservation_status) {
            case "0":
                echo "<a href=" . $url . " title='In Progress'>IP</a>";
                break;
            case "1":
                echo "<a href=" . $url . " title='Confirmed'>Conf</a>";
                break;
            case "2":
                echo "<a href=" . $url . " title='Waiting For Confirmation'>WFC</a>";
                break;
            case "3":
                echo "<a href=" . $url . " title='Cancelled By User'>CBU</a>";
                break;
            case "4":
                echo "<a href=" . $url . " title='Cancelled By Admin'>CBA</a>";
                break;
            case "5":
                echo "<a href=" . $url . " title='No Show'>No Show</a>";
                break;
            case "6":
                echo "<a href=" . $url . " title='Cancelled By Hotel'>CBH</a>";
                break;
            case "7":
                echo "<a href=" . $url . " title='Refused'>Refused</a>";
                break;
        }
    }
        
        public function getTotalReservationPrice($data,$row) {
            $optionsObject = ReservationOption::model()->findAll('reservation_id ='. $data->id);
            $totalPrice = 0;
            if($optionsObject){
                foreach($optionsObject as $options){
                    $totalPrice+=$options->equipment_price;
                }
            }
            $roomPrice = $data->room_price;
            echo "$". number_format($totalPrice+$roomPrice,2);
        }

                /**
         * Get the Reservation Option
         * 
         * @param type $data 
         * @param type $row
         */
        public function getReservationOption($data,$row){
            $optionsObject = ReservationOption::model()->findAll('reservation_id ='. $data->id);
            
            if($optionsObject){
                $optionArray = array();
                $key = 1;
                foreach($optionsObject as $options){
                    
                    $optionArray[] =  $key . ". ".$options->equipment->name;
                    $key++;
                }
                if($optionArray) {
                   $toolTipList = implode(", ", $optionArray);
                   echo "<p title='". $toolTipList . "'>" . substr($optionsObject[0]->equipment->name,0,9) . "...</p>";
                           
                }
            } else {
                echo "";
            }
            
        }

        public function getReservationDateAndTime($data,$row){
            echo $data->res_date  . " " .  $data->arrival_time;
        }


        public function getformattedPhoneNumber($data,$row){
        	echo '+'.$data->countryObj['country_code'].$data->customer->telephone;
        }

        /**
         * Get the Reservation Option
         * 
         * @param type $data 
         * @param type $row
         */
        public function getReservationOptionPriceCount($data,$row){
            $optionsObject = ReservationOption::model()->findAll('reservation_id ='. $data->id);
            $totalPrice = 0;
            if($optionsObject){
                foreach($optionsObject as $options){
                    $totalPrice+=$options->equipment_price;
                }
            }
            echo "$". number_format($totalPrice,2);
            
        }
        
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Reservation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Reservation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Reservation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reservation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    public function actionSendConfirmationEmailToHotel($reservationObject){
        $reservationObject = Reservation::model()->findByPk($reservationObject->id);
        if($reservationObject) {
            $reservationId = $reservationObject->id;
            $roomId = $reservationObject->room_id;
            $roomObject = Room::model()->findByPk($roomId);
            $conditionArray = array('condition' => 'reservation_id = '.$reservationId);
            $reservationOptionObject = ReservationOption::model()->findAll($conditionArray);

            $hotelObject = Hotel::model()->findByPk($roomObject->hotel_id);
            $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
        
            $invoiceReservationObject = InvReservation::model()->findByAttributes(array('nb_reservation'=>$reservationObject->nb_reservation));
            if($invoiceReservationObject){
                $hotelId = $invoiceReservationObject->hotel_id;
                $hotelAdministrativeObject = HotelAdministrative::model()->findByAttributes(array('hotel_id'=>$hotelId));
                $administrativeObject = $hotelAdministrativeObject->hotelAdministrativeEmails(array('condition'=>'administrative_id = '.$hotelAdministrativeObject->id));
                $emailId = $administrativeObject[0]->email_add;
            }  
            
            if(empty($emailId)){
                echo "Hotel don't have any email"; exit;
            }
            $baseUrl = Yii::app()->getBaseUrl(true);
            $customerName = $customerObject->first_name ." ".$customerObject->last_name;
            $emailId = $customerObject->email_address;
            $verificationMail['to'] = $emailId;
            $verificationMail['subject'] = 'Dayuse- Reservation Confirmation Details!';
            $verificationMail['body'] = $this->renderPartial('/mail/resend_reservation_confirmation', 
                    array('customerName' => $customerName,
                          'baseUrl'=>$baseUrl,
                        'reservationObject' => $reservationObject,
                        'reservationOptionObject'=>$reservationOptionObject,
                        'roomObject'=>$roomObject,
                        'hotelObject'=>$hotelObject,
                        'customerObjecct'=>$customerObject), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            return $result = CommonHelper::sendMail($verificationMail);
            
        }
    }
    /**
     * send confirmation email
     * 
     * @param type $reservationId
     */
    public function actionSendConfirmationEmail($reservationId,$sendall=0){
        $reservationObject = Reservation::model()->findByPk($reservationId);
        if($reservationObject) {
            $reservationId = $reservationObject->id;
            $roomId = $reservationObject->room_id;
            $roomObject = Room::model()->findByPk($roomId);
            $conditionArray = array('condition' => 'reservation_id = '.$reservationId);
            $reservationOptionObject = ReservationOption::model()->findAll($conditionArray);

            $hotelObject = Hotel::model()->findByPk($roomObject->hotel_id);
            $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
        
            $baseUrl = Yii::app()->getBaseUrl(true);
            $customerName = $customerObject->first_name ." ".$customerObject->last_name;
            $emailId = $customerObject->email_address;
            $verificationMail['to'] = $emailId;
            if($reservationObject->reservation_status == 2)
                $verificationMail['subject'] = 'Dayuse- Reservation On Request!';
            else
                $verificationMail['subject'] = 'Dayuse- Reservation Confirmation !';
            
            $verificationMail['body'] = $this->renderPartial('/mail/resend_reservation_confirmation', 
                    array('customerName' => $customerName,
                          'baseUrl'=>$baseUrl,
                        'reservationObject' => $reservationObject,
                        'reservationOptionObject'=>$reservationOptionObject,
                        'roomObject'=>$roomObject,
                        'hotelObject'=>$hotelObject,
                        'customerObjecct'=>$customerObject), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            
            //Confirmation type ==1 : Manager True, ==2,0 : Manager and User True
            if($sendall!=1)
                $result = CommonHelper::sendMail($verificationMail);
            
            $hmanager = HotelContact::model()->find("hotel_id=".$roomObject->hotel_id." and contact_type=1");
            if($hmanager!=NULL)
            {
                $verificationMail['to'] = $hmanager->email_address;
                if($reservationObject->reservation_status == 2)
                    $verificationMail['subject'] = 'Reservation On-Request - Please confirm the reservation!';
                else
                    $verificationMail['subject'] = 'Dayuse- Reservation Confirmation !';
                
                CommonHelper::sendMail($verificationMail);
            }
            
            return;
            
        }
    }
    
    /**
    * Get the Reservation Option
    * 
    * @param type $data 
    * @param type $row
    */
   public function getActions($data,$row){
       $today = date('Y-m-d');
       echo "<form name='confirm_frm' class='form-inline' id='confirm_frm' method='post' action='/admin/reservation/reservationstatus'>"
        . "<select name='admin_action' class='form-control input-small select2me margin-right15' id='manager_action'>"
         . "<option value='5'>Select</option>";
            if($data->reservation_status != 1 && $data->res_date >= date('Y-m-d')) {
                echo "<option value='5'>Confirm</option>";
            }
            if($data->res_date <= date('Y-m-d')) {  
                echo "<option value='2'>No Show</option>";
            } else {
                echo "<option value='6'>Refuse</option>";
            }
        echo "</select>"
        . "<input type='hidden' value='manager' name='manager'/>"
        . "<input type='hidden' value='1' name='portal'/>"
        . "<input type='hidden' value='".$data->customer->id."' name='customer_id'/>"
        . "<input type='hidden' value='".$data->id."' name='reservation_id'/>"
        . "<input type='submit' class='btn btn-primary' value='OK'></form>";

   }
   
   public function reservationStatusOption($data,$row){
        echo $this->renderPartial('managerAction', array('data' => $data), true);
   }
}
