<?php
//use ReservationManager as ReservationManager;
class ReservationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','create','edit','resendvarificationlink',
                                    'payment','callback','selectedservices','sendconfirmationemail','isemailexisted',
                                    'validation','confirmation','isphoneexisted'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
     * create reservation 
     * 1. create new customre
     * 2. insert in to reservation table
     * 3. insert or read from customer table
     * 4. insert in reservation option table
     * 5. send verification code
     * 
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $customerObject = new Customer;
        $reservationModel = new Reservation;
        $onRequestFlag = 1;
        $reservationObject = "";
        $reservationOptionObject = array();
        $reservationId = 0;
        
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
            if(isset($_REQUEST['arrtime'])){
                $arrtime= base64_decode($_REQUEST['arrtime']);
            }
            if(isset($_REQUEST['orf'])){
                $onRequestFlag= $_REQUEST['orf'];
            }
            if(isset($_REQUEST['rId'])){
                if($_REQUEST['rId']!=0){
                    $reservationId = $_REQUEST['rId'];
                    $reservationObject = Reservation::model()->findByPk($reservationId);  

                    $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationId);
                    $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);

                    $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
                }
            }
        }
        
        //read hotel by id
        $hotelObject = Hotel::model()->findByPk($hotelId);
        //read room by id
        $roomObject = Room::model()->findByPk($roomId);
        
        //read room option by room by id
        $roomOptionCondition = array('condition' => 'room_id =' . $roomId);
        $roomOptionObject = RoomOptions::model()->findAll($roomOptionCondition);
        
        //read all origins
        $originObject = Origin::model()->findAll();
        
        //find loggedin customer details
        $customerId = Yii::app()->session['userid'];
        if(!empty($customerId))
        {
           $customerObject = Customer::model()->findByPk($customerId);
        }
        
        //generate verification code
        $varificationCode =  BaseClass::getUniqInt(6);
        //generate reservation code
        $reservationCode =  BaseClass::getUniqInt(10);
        $message = "";
        if(Yii::app()->session['access_result'] == 'success'){
            $message = 'Access approved!';//TODO: need read from language file
        }
        if(Yii::app()->session['access_result'] == 'faild'){
            $message = 'Account Does Not exist';//TODO: need read from language file
        }
        Yii::app()->session['access_result'] = "";
        
        $isLoggedIn = 0;
        if(isset(Yii::app()->session['userid'])) { 
            $isLoggedIn = 1;
        } 
        
        if($_POST) {
            $postDataArray = $_POST;
            $resultArray = array();
            
            Yii::app()->session['varification_type'] = "";
            if($postDataArray['confirmation_via'] == 'sms'){
               Yii::app()->session['varification_type'] = 'sms';
            }
            
            //Customer Section
            //Customer Logged In
            if (!empty($postDataArray['existing_customer_flag'])) { 
                //Existing Customer
                $this->checkCustomerIsExisted($postDataArray);
            } 
            else
            {
                //Customer Not Logged In
                //First verify the entered information in email address and phone no is unique or not
                if( $postDataArray['telephone']{0} == 0 ) {
                    $postDataArray['telephone'] = substr($postDataArray['telephone'], 1);
                }
                
                if($postDataArray['existing_user']==0)
                {
                    //Check the telephone should be not same with existing subscibed users
                    $notun_telephone = BaseClass::isCustomerFieldDataExisted('telephone',$postDataArray['telephone']);
                    $notun_email = BaseClass::isCustomerFieldDataExisted('email_address',$postDataArray['email_address']);

                    if($notun_telephone || $notun_email)
                    {
                        //Already exists then stop further execution
                        $resultArray['status'] = "ERROR";
                        $resultArray['email_error'] = $notun_email;
                        $resultArray['tel_error'] = $notun_telephone;

                        echo json_encode($resultArray);
                        Yii::app()->end();
                    }
                }
                
                //Insert/Update into customer table
                $customreArrayObject = $this->getCustomerArray($customerObject, $postDataArray);
                $customreArrayObject->save();
                $customerId = $customreArrayObject->id;
                
                $customerObject = Customer::model()->findByPk($customerId);
                
                if($postDataArray['existing_user']==0)
                {
                    if($customerObject->is_subscribed==1 && !$isLoggedIn)
                    {
                        //Send new account creation mail
                        $baseurl = Yii::app()->getBaseUrl(true);
                        $verificationMail['to'] = $customerObject->email_address;
                        $verificationMail['subject'] = 'DayStay- Account';
                        $verificationMail['body'] = $this->renderPartial('/mail/signup_success',
                                        array('userdetails' => $customerObject,
                                                        'baseurl'=>$baseurl), true);
                        $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
                        CommonHelper::sendMail($verificationMail);
                    }
                }
            }
            
            //Reservation Section
            if($reservationId)
            { 
                //$reservationId = $postDataArray['reservation_id'];
                $reservationDataObject = Reservation::model()->findByPk($reservationId);
                //delete remaining reservation option
                $deleteReservationOption = ReservationOption::model()->findAll(array('condition'=>'reservation_id = '.$reservationId));
                foreach($deleteReservationOption as $reservationObject){
                    $reservationObject->delete();
                }
                //edit into reservation table
                $reservationObject = $this->getReservationArray(
                        $reservationDataObject, $roomObject, $customerId, $postDataArray);
                $reservationObject->save();
                
            } 
            else 
            {
                //Insert into reservation table
                $reservationObject = $this->getReservationArray(
                        $reservationModel, $roomObject, $customerId, $postDataArray);
                $reservationObject->save();
            }
            $reservationId = $reservationObject->id;
            
            //SEND VERIFICATION LINK
            $vCode = $varificationCode;
            if(!empty($reservationObject->reservation_code)){
                $vCode = $reservationObject->reservation_code;
            }
            if($postDataArray['confirmation_via'] == 'sms') { 
                $message = Yii::app()->params['sms_verification_text'] . $vCode;
                $mobileNumber = $customreArrayObject->country->country_code.$customreArrayObject->telephone;
                BaseClass::sendSMS($mobileNumber, $message);
            } else if($postDataArray['confirmation_via'] == 'email'){ 
                $this->sendVerificationLink($customreArrayObject, $reservationObject,$onRequestFlag);
            }

            //Store CARD details
            if($postDataArray['card_number']) {
                $this->saveCardDetails($postDataArray,$reservationId);
            }
            
            //Aditional services
            if (!empty($postDataArray['aditional_services'])) {
                $this->addSelectedServices($postDataArray['aditional_services'],$reservationId);
            }
            
            if(!empty($reservationId)) {
                $resultArray['cId'] = $customreArrayObject->id;//hotel Id
                $resultArray['hId'] = $hotelId;//hotel Id
                $resultArray['rId'] = $reservationId; // reservation Id
                $resultArray['roomId'] = $roomId; // room Id
                $resultArray['rdate'] = $postDataArray['booking_date']; // reservation Date
                $resultArray['orf'] = $onRequestFlag;
                $resultArray['status'] = "SUCCESS";
                
                echo json_encode($resultArray);
                InvReservation::model()->createInvoiceReservation($postDataArray);
                Yii::app()->end();
            } else {
                echo json_encode('error');
                Yii::app()->end();
            }
        }
        
        
        $this->render('create', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $roomBookingDate,
            'roomOptionObject' => $roomOptionObject,
            'customerObject' => $customerObject,
            'varificationCode' => $varificationCode,
            'message' => $message,
            'originObject' => $originObject,
            'reservationCode'=>$reservationCode,
            'isLoggedIn'=>$isLoggedIn,
            'reservationObject'=>$reservationObject,
            'reservationOptionObject'=>$reservationOptionObject,
            'arrtime' => $arrtime,
            'onRequestFlag'=>$onRequestFlag
        ));
    }
    
    /**
     * edit reservation 
     * 1. edit new customre
     * 2. insert in to reservation table
     * 3. insert or read from customer table
     * 4. insert in reservation option table
     * 5. send verification code
     * 
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionEdit() {
        
        $customerModel = new Customer;
        $reservationModel = new Reservation;
        if($_REQUEST) {
            if(isset($_REQUEST['hotelId'])){
                $hotelId = $_REQUEST['hotelId'];
            }
            if(isset($_REQUEST['roomId'])){
                $roomId = $_REQUEST['roomId'];
            }
            if(isset($_REQUEST['date'])){
                $roomBookingDate = $_REQUEST['date'];
            }
            if(isset($_REQUEST['resnb'])){
                $reservationId = base64_decode($_REQUEST['resnb']);
            } elseif(isset($_REQUEST['rId'])) { 
                $reservationId = $_REQUEST['rId'];
            } else { 
                $this->render('//site/error404');
            }
            $reservationCondition = array('id'=>$reservationId, 'room_id'=>$roomId, 'res_date' => $roomBookingDate);
            $reservationObject = Reservation::model()->findByAttributes($reservationCondition);
            if(empty($reservationObject)){
                $this->render('//site/error404');
            }
            
        }
        
        $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationId);
        $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);
        $reservationObject = Reservation::model()->findByPk($reservationId);
        //read hotel by id
        $hotelObject = Hotel::model()->findByPk($hotelId);
        //read room by id
        $roomObject = Room::model()->findByPk($roomId);
        //read room option by room by id
        $roomOptionCondition = array('condition' => 'room_id =' . $roomId);
        $roomOptionObject = RoomOptions::model()->findAll($roomOptionCondition);
        //read all origins
        $originObject = Origin::model()->findAll();
        //find loggedin customer details
        $customerId = Yii::app()->session['userid'];
        if(!empty($reservationObject)){
            $customerId = $reservationObject->customer_id;
        }
        
        $customerObject = Customer::model()->findByPk($customerId);
        //generate verification code
        $varificationCode =  BaseClass::getUniqInt(6);
        //generate reservation code
        $reservationCode =  BaseClass::getUniqInt(10);
        $message = "";
        if(Yii::app()->session['access_result'] == 'success'){
            $message = 'Access approved!';//TODO: need read from language file
        }
        if(Yii::app()->session['access_result'] == 'faild'){
            $message = 'Account Does Not exist';//TODO: need read from language file
        }
        Yii::app()->session['access_result'] = "";
        $isLoggedIn = 1;
        
        if ($_POST) {
            $postDataArray = $_POST;
            
            Yii::app()->session['varification_type'] = "";
            if($postDataArray['confirmation_via'] == 'sms'){
               Yii::app()->session['varification_type'] = 'sms';
            }
            
            if (!empty($postDataArray['existing_customer_flag'])) { 
                $this->checkCustomerIsExisted($postDataArray);
            } elseif(!$customerObject && empty($postDataArray['id'])){ 
                //Insert into reservation table
                $customreArrayObject = $this->getCustomerArray($customerModel, $postDataArray);
                $customreArrayObject->save();
                $customerId = $customreArrayObject->id;
            }
            
            if($postDataArray['id']){ 
                $customerId = $postDataArray['id'];
                $customerObject = Customer::model()->findByPk($customerId);
            }

            //Insert into reservation table
            $reservationObject = $this->getReservationArray(
                    $reservationModel, $roomObject, $customerId, $postDataArray);
            //$reservationObject->save();
            if(!$reservationObject->save()){
                var_dump($reservationObject->getErrors());exit;
            }
            $reservationId = $reservationObject->id;
            //aditional services
            if (!empty($postDataArray['aditional_services'])) {
                $this->addSelectedServices($postDataArray['aditional_services'],$reservationId);
            }
            if(!empty($reservationId)) {
                //delete invoice reservation
                $this->deleteInvoiceReservationOption($postDataArray['reservation_code']);
                $this->actionSendConfirmationEmail($reservationId);
                //create invoice reservation
                InvReservation::model()->createInvoiceReservation($postDataArray);
                echo $reservationId; exit;
            }
        }
        $this->render('create', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $roomBookingDate,
            'roomOptionObject' => $roomOptionObject,
            'customerObject' => $customerObject,
            'varificationCode' => $varificationCode,
            'message' => $message,
            'originObject' => $originObject,
            'reservationCode'=>$reservationCode,
            'isLoggedIn'=>$isLoggedIn,
            'reservationOptionObject'=>$reservationOptionObject,
            'reservationObject'=>$reservationObject,
            'onRequestFlag' => '',
            'arrtime'=>''
        ));
    }
    
    /**
     * create reservation 
     * 1. create new customre
     * 2. insert in to reservation table
     * 3. insert or read from customer table
     * 4. insert in reservation option table
     * 5. send verification code
     * 
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionValidation() {
        
        $customerId = Yii::app()->session['userid'];
        if($_REQUEST){
            if(isset($_REQUEST['hId'])){
                $hotelId = $_REQUEST['hId'];
            }
            if(isset($_REQUEST['rId'])){
                $reservationId = $_REQUEST['rId'];
            }
            if(isset($_REQUEST['date'])){
                $roomBookingDate = $_REQUEST['date'];
            }
            if(isset($_REQUEST['cId'])){
                $customerId = $_REQUEST['cId'];
            }
            if(isset($_REQUEST['roomId'])){
                $roomId = $_REQUEST['roomId'];
            }
            
            $reservationCondition = array('id'=>$reservationId, 'res_date' => $roomBookingDate);
            $reservationObject = Reservation::model()->findByAttributes($reservationCondition);
            if($reservationObject->reservation_status == 1){
                $this->redirect(array('reservation/confirmation', 'rId' => $reservationObject->id, 'date'=> $reservationObject->res_date)); 
            }
            if(empty($reservationObject)){
                $this->render('//site/error404');
            }
        }
        
        $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationId);
        $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);
        
        //read hotel by id
        $hotelObject = Hotel::model()->findByPk($hotelId);
        //read room by id
        $roomObject = Room::model()->findByPk($roomId);
        //read room option by room by id
        $roomOptionCondition = array('condition' => 'room_id =' . $roomId);
        $roomOptionObject = RoomOptions::model()->findAll($roomOptionCondition);
        //read all origins
        $originObject = Origin::model()->findAll();
        
        //find loggedin customer details

        $customerObject = Customer::model()->findByPk($customerId);
        $this->render('validation', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $roomBookingDate,
            'roomOptionObject' => $roomOptionObject,
            'customerObject' => $customerObject,
            'originObject' => $originObject,
            'reservationObject'=>$reservationObject,
            'reservationOptionObject'=>$reservationOptionObject,
        ));
    }
    
    public function saveCardDetails($postDataArray, $reservationId) {
        
        $cardDetailString = $postDataArray['card_number'] ."-".$postDataArray['card_year']."-".$postDataArray['card_month']."-".$postDataArray['card_security_code']."-".$postDataArray['card_holder_name'];
        $cardDetailsObject = new CardDetails;
        $cardDetailsObject->reservation_id = $reservationId;
        $cardDetailsObject->card_details = base64_encode($cardDetailString);
        $cardDetailsObject->created_at = new CDbExpression('NOW()');
        $cardDetailsObject->updated_at = new CDbExpression('NOW()');
        //Inserte in reservation option table
        return $cardDetailsObject->save();
    }
    
    /**
     * 
     */
    public function actionIsEmailExisted(){
        if($_POST){
            $emailId = $_POST['email'];
            $result = BaseClass::isCustomerFieldDataExisted('email_address',$emailId);
            if($result){
                echo CJSON::encode(1);exit;
            } else {
                echo CJSON::encode(0);exit;
            }
        } 
    }

    /**
     * 
     */
    public function actionIsPhoneExisted(){
        if($_POST){
            $telephone = $_POST['telephone'];
            $result = BaseClass::isCustomerFieldDataExisted('telephone',$telephone);
            if($result){
                echo CJSON::encode(1);exit;
            } else {
                echo CJSON::encode(0);exit;
            }
        } 
    }
    /**
     * check existing customer
     * 
     * @param type $postDataArray
     */
    public function checkCustomerIsExisted($postDataArray) {
        $phoneNumber = $postDataArray['existing_customer_phone_no'];
        $password = md5($postDataArray['existing_customer_password']);
        $customreObject = Customer::model()->findByAttributes(array('telephone' => $phoneNumber, 'password' => $password),'is_subscribed=1');
        if($customreObject) {
            $identity=new UserIdentity($phoneNumber,$password);
            if($identity->customerAuthenticate())
            Yii::app()->user->login($identity);
            Yii::app()->session['userid'] = $customreObject->id;
            Yii::app()->session['access_result'] = "success";
            echo CJSON::encode($customreObject);exit;
        } else { 
            Yii::app()->session['access_result'] = "faild";
            echo CJSON::encode(0);exit;
        }
    }

    public function createInvoiceReservation($postDataArray) {
        $invoiceModel = new InvReservation;
        $roomObjecct = Room::model()->findByPk($postDataArray['roomId']);
        
        $roomTariffCondition = array('room_id'=>$postDataArray['roomId'], 'tariff_date' => $postDataArray['booking_date']);
        $roomTrriffObjecct = RoomTariff::model()->findByAttributes($roomTariffCondition);
        if($roomObjecct){
            $hotelObject = Hotel::model()->findByPk($roomObjecct->hotel_id);
            $hotelPercentage = $hotelObject->day_commission;
            if($roomObjecct->category == 'moon') {
                $hotelPercentage = $hotelObject->night_commission;
            }
            $commAmount = BaseClass::getPercentage($roomTrriffObjecct->price, $hotelPercentage, 1);
            $invoiceModel->nb_reservation = $postDataArray['reservation_code'];
            $invoiceModel->hotel_id = $postDataArray['hotelId'];
            $invoiceModel->res_date = $postDataArray['booking_date'];
            $invoiceModel->opt_type = 'room';
            $invoiceModel->opt_id = 0;
            $invoiceModel->opt_title = $roomObjecct->name;
            $invoiceModel->opt_price = $roomTrriffObjecct->price;
            $invoiceModel->opt_curr_id = 1;//TODO: need to change 
            $invoiceModel->comm_perc = $hotelPercentage;
            $invoiceModel->comm_amt = $commAmount;
            $invoiceModel->vat_perc = 0.00;//TODO: need to change 
            $invoiceModel->vat_amt = 0.00;//TODO: need to change 
            $invoiceModel->status = 1;//In-progress
            $invoiceModel->total_comm_amt = ($commAmount+$roomTrriffObjecct->price);
            $invoiceModel->added_at = new CDbExpression('NOW()');
            $invoiceModel->updated_at = new CDbExpression('NOW()');
            $invoiceModel->save();
            if(!$invoiceModel->save()){
                echo "<pre>"; print_r($invoiceModel->getErrors());exit;
            }
            if (!empty($postDataArray['aditional_services'])) {
                foreach ($postDataArray['aditional_services'] as $services) {
                    $invoiceOptionModel = new InvReservation;          
                    $serviceAndPrice = explode("_", $services); //$services
                    $hotelOptionPercentage = $hotelObject->addon_commission;
                    $equipmentObject = Equipment::model()->findByPk($serviceAndPrice['0']);
                    $commOptAmount = BaseClass::getPercentage($serviceAndPrice['1'], $hotelOptionPercentage, 1);
                    $invoiceOptionModel->nb_reservation = $postDataArray['reservation_code'];
                    $invoiceOptionModel->hotel_id = $postDataArray['hotelId'];
                    $invoiceOptionModel->res_date = $postDataArray['booking_date'];
                    $invoiceOptionModel->opt_type = 'opt';
                    $invoiceOptionModel->opt_id = $serviceAndPrice['0'];
                    $invoiceOptionModel->opt_title = $equipmentObject->name;
                    $invoiceOptionModel->opt_price = $serviceAndPrice['1'];
                    $invoiceOptionModel->opt_curr_id = 1;//TODO: changed after 
                    $invoiceOptionModel->comm_perc = $hotelOptionPercentage;
                    $invoiceOptionModel->comm_amt = $commAmount;
                    $invoiceOptionModel->vat_perc = 0.00;//TODO: need to change 
                    $invoiceOptionModel->vat_amt = 0.00;//TODO: need to change 
                    $invoiceOptionModel->status = 1;//In-progress
                    $invoiceOptionModel->total_comm_amt = ($commOptAmount+$serviceAndPrice['1']);
                    $invoiceOptionModel->added_at = new CDbExpression('NOW()');
                    $invoiceOptionModel->updated_at = new CDbExpression('NOW()');
                    $invoiceOptionModel->save();
                    if(!$invoiceOptionModel->save()){
                        echo "<pre>"; print_r($invoiceOptionModel->getErrors());exit;
                    }
                }
            }
            return $invoiceModel;
        }
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
     * ajax function to get selected services
     */
    public function actionSelectedServices() { 
        if (!empty($_POST['selected_service'])) {
            $selectedService = $_POST['selected_service'];
            $selectedService = rtrim($selectedService, ",");

            $criteriahotel = array("condition" => "id IN (" . $selectedService . ") AND cc_required =1");

            $hoteldataObject = RoomOptions::model()->findAll($criteriahotel);
            if ($hoteldataObject) {
                $totalCardPayment = 0;
                foreach ($hoteldataObject as $hoteldata) {
                    $totalCardPayment+=$hoteldata->price;
                }
                echo $totalCardPayment;
                exit;
            }
            echo 0;
            exit;
        }
        echo 0;
        exit;
    }

    /**
    * send email
    */
   public function sendVerificationLink($userObject, $reservationObject,$onRequestFlag, $resendEmail= "") {
        if ($reservationObject) {
            $baseurl = Yii::app()->getBaseUrl(true);
            $customerName = $userObject->first_name ." " . $userObject->last_name;
            $encryptedId = BaseClass::md5Encryption($reservationObject->nb_reservation);
            $emailId = $userObject->email_address;
            if(!empty($resendEmail)){
                $emailId = $resendEmail;
            }
            
            
            $url = Yii::app()->createUrl('/reservation/confirmation', 
                    array('rId' => $reservationObject->id,
                        'date' =>$reservationObject->res_date,
                        'authId'=>$encryptedId,
                        'orf'=>$onRequestFlag));
            $verificationMail['to'] = $emailId;
            $verificationMail['subject'] = 'Dayuse- Reservation Validation Code';
            $verificationMail['body'] = $this->renderPartial('/mail/reservation_verification', 
                    array('customerName' => $customerName,
                          'varificationLink' => $url,
                          'baseurl'=>$baseurl), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            $result = CommonHelper::sendMail($verificationMail);
        }
    }
    
    public function actionResendVarificationLink(){
        if($_POST){
            $reservationObject = Reservation::model()->findByPk($_POST['rservationId']);
           $customerObject = "";
           if($reservationObject){
                $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
           }
           $this->sendVerificationLink($customerObject, $reservationObject, $_POST['resendEmail']);
        }
    }

    /**
    * send email
    */
   public function sendVerificationCode($customerObjet, $varificationCode) {
        if ($customerObjet) {
            $baseurl = Yii::app()->getBaseUrl(true);
            $customerName = $customerObjet->first_name . " ". $customerObjet->last_name;
            $emailId = $customerObjet->email_address;
            
            $verificationMail['to'] = $emailId;
            $verificationMail['subject'] = 'Dayuse- Reservation Validation Code';
            $verificationMail['body'] = $this->renderPartial('/mail/reservation_verification', 
                    array('customerName' => $customerName,
                          'varificationCode' => $varificationCode,
                          'baseurl'=>$baseurl), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            CommonHelper::sendMail($verificationMail);
        }
    }

    /**
     * Send confirmation email
     * 
     * @param type $reservationId
     */
    public function actionSendConfirmationEmail($reservationId,$sendall=0) {
        $reservationObject = Reservation::model()->findByPk($reservationId);
        if($reservationObject) {
            $reservationId = $reservationObject->id;
            $roomId = $reservationObject->room_id;
            $roomObject = Room::model()->findByPk($roomId);
            $conditionArray = array('condition' => 'reservation_id = '.$reservationId);
            $reservationOptionObject = ReservationOption::model()->findAll($conditionArray);

            $hotelObject = Hotel::model()->findByPk($roomObject->hotel_id);
            $customerObjecct = Customer::model()->findByPk($reservationObject->customer_id);
        
            $baseUrl = Yii::app()->getBaseUrl(true);
            $customerName = $customerObjecct->first_name ." ".$customerObjecct->last_name;
            $emailId = $customerObjecct->email_address;
            $verificationMail['to'] = $emailId;
            if($reservationObject->reservation_status == 2)
                $verificationMail['subject'] = 'Dayuse- Reservation On Request!';
            else
                $verificationMail['subject'] = 'Dayuse- Reservation Confirmation !';
            
            $verificationMail['body'] = $this->renderPartial('/mail/reservation_confirmation', 
                    array('customerName' => $customerName,
                          'baseUrl'=>$baseUrl,
                        'reservationObject' => $reservationObject,
                        'reservationOptionObject'=>$reservationOptionObject,
                        'roomObject'=>$roomObject,
                        'hotelObject'=>$hotelObject,
                        'customerObjecct'=>$customerObjecct), true);
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
            
            return $result;
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
        
        $isSecret =  0;
        $subscribed = (!empty($customerModel->is_subscribed)) ? $customerModel->is_subscribed : 0;
        
        if(isset($customerPostArray['is_secret'])){
            $isSecret = $customerPostArray['is_secret'];
        }
        if(isset($customerPostArray['password'])){
            if($customerPostArray['password']!="")            
            {
                $subscribed = 1;
                $customerModel->password = md5($customerPostArray['password']);
            }
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
        if(isset($customerPostArray['input_verification_code'])){
            $customerModel->auth_code = $customerPostArray['input_verification_code'];
        }

        $customerModel->origin_id = 1;//$customerPostArray['origin_id']; //TODO: Need to confirm with team
        $customerModel->is_subscribed = $subscribed;
        $customerModel->status = 1;//TODO: need to verify with team
        $customerModel->added_at = new CDbExpression('NOW()');
        $customerModel->updated_at = new CDbExpression('NOW()');
        return $customerModel;
    }

    /**
     * create reservation array
     * 
     * @param type $reservationModel
     * @param type $roomObject
     * @param type $customerId
     * @param type $postData
     * @return type
     */
    public function getReservationArray($reservationModel, $roomObject, $customerId, $postData){
        
        $verificationCode = "12345"; //TODO= need to remove 
            if(isset($postData['varification_code'])){
                $verificationCode = $postData['varification_code'];
            }
            $isSecret = 0;
            if(isset($postData['is_secret'])){
                $isSecret = $postData['is_secret'];
            }
            $comment = '';
            if(isset($postData['comment'])){
                $comment = $postData['comment'];
            }
            if(!empty($postData['come_accross'])){
                 $reservationModel->origin_id = $postData['come_accross'];
            }
            if(!empty($postData['reservation_code'])){
                 $reservationModel->nb_reservation = $postData['reservation_code'];
            }
            if(!empty($postData['country_id'])){
                $reservationModel->country_code = $postData['country_id'];
            }
            $reservationModel->customer_id = $customerId;
           
            $reservationModel->portal_id = 1; //TODO: Need to confirm with team
            $reservationModel->room_id = $roomObject->id;
            if(!empty($postData['booking_date'])){
                $reservationModel->res_date = $postData['booking_date'];
            }
            
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
           
            
            $reservationModel->res_from = $roomObject->available_from;
            $reservationModel->res_to = $roomObject->available_till;
            $reservationModel->room_price = $roomObject->default_price;
            $reservationModel->currency_id = 1; //TODO: Need to confirm with team
            $reservationModel->comment = $comment;//$postData['comment'];//TODO: Need to modify the database because comment is not mandetory field
            if(!empty($postData['arrival_time'])){
                $reservationModel->arrival_time = $postData['arrival_time'];
            }
            $reservationModel->is_secret = $isSecret;
            $reservationModel->reservation_code = $verificationCode;
            if(!empty($postData['onRequestFlag'])){
                $reservationModel->reservation_status = 0;//0: in-progress
            }
            $reservationModel->payment_status = 1; //TODO: Need to confirm with team
            $reservationModel->added_at = new CDbExpression('NOW()');
            $reservationModel->updated_at = new CDbExpression('NOW()');
            /*echo "<pre>";
            print_r($reservationModel);
            exit;*/
            return $reservationModel;
    }


    /**
     * Paybox payment
     */
    public function actionPayment(){    
        $paymentConfigArray =  Yii::app()->params['payment'];

        $reservationArray['reservationId'] = $_GET['reservationId'];
        $reservationArray['price'] = $_GET['price'];
        $targetUrl = $paymentConfigArray['target_url'];
        //logged in user object
        $postString = $this->createPaymentCurlString($paymentConfigArray, $reservationArray);
        try{
            //payment curl request
            $curl_connection = curl_init($targetUrl);
            curl_setopt($curl_connection, CURLOPT_POST,1);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl_connection, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS
            curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $postString);
            curl_exec($curl_connection);
            exit;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
        
    /**
     * create payment curl string
     * 
     * @param type $paymentConfig
     * @param type $course
     * @param type $userObject
     * @param type $postDataArray
     * @return type
     */
    public function createPaymentCurlString($paymentConfig, $reservationArray) {
        if(strlen((string) $reservationArray['price']) == 1){
            $paymentConfig['PBX_TOTAL'] = "00" . $reservationArray['price'];
        } elseif(strlen((string) $reservationArray['price']) == 2){
            $paymentConfig['PBX_TOTAL'] = "0" . $reservationArray['price'];
        } else {
            $paymentConfig['PBX_TOTAL'] = $reservationArray['price']; 
        }
        $reservationCode =  BaseClass::getUniqInt(10);
        $callBackUrl = "http://{$_SERVER['HTTP_HOST']}" . $paymentConfig['call_back_url'];
        $refNumber = $reservationCode ."-". $reservationArray['reservationId'];
        $dataArray = array(
            'PBX_MODE'          => $paymentConfig['PBX_MODE'],
            'PBX_SITE'          => $paymentConfig['PBX_SITE'],
            'PBX_RANG'          => $paymentConfig['PBX_RANG'],
            'PBX_IDENTIFIANT'   => $paymentConfig['PBX_IDENTIFIANT'],
            'PBX_TOTAL'         => $paymentConfig['PBX_TOTAL'],
            'PBX_DEVISE'        => $paymentConfig['PBX_DEVISE'],
            'PBX_CMD'           => $refNumber,
            'PBX_PORTEUR'       => 'cool@gmail.com',
            'REFERENCE'         => $refNumber,
            'PBX_RETOUR'        => $paymentConfig['PBX_RETOUR'],
            'PBX_EFFECTUE'      => $callBackUrl,
            'PBX_REFUSE'        => $callBackUrl,
            'PBX_ANNULE'        => $callBackUrl,
        );
        // course payment table insert.
        $this->insetIntoPaymentTable($dataArray, $reservationArray);
        
        foreach ($dataArray as $key => $value) {
            $arrayItems[] = $key . '=' . $value;
        }
        //construct string
        $requestString = implode('&', $arrayItems);
        return $requestString;
    }
    
    public function insetIntoPaymentTable($dataArray, $reservationArray){
        $paymentModel = new CardPayment();
        
        $paymentModel->reservation_id = $reservationArray['reservationId'];
        $paymentModel->nb_reference = $dataArray['REFERENCE']; //TODO: Need to confirm with team
        $paymentModel->amount = $dataArray['PBX_TOTAL'];
        $paymentModel->date = new CDbExpression('NOW()');
        $paymentModel->status = 0;
        $paymentModel->error_code = NULL;
        $paymentModel->created_at = new CDbExpression('NOW()');
        $paymentModel->updated_at = new CDbExpression('NOW()');
        $paymentModel->save();
        return $paymentModel;
    }

    public function actionConfirmation() {
        if(isset($_REQUEST)){
            $reservation_status = 1;
            $responseArray = $_REQUEST;
            if(isset($responseArray['rId'])){
                $reservationId = $responseArray['rId'];
            }
            if(isset($responseArray['date'])){
                $roomBookingDate = $responseArray['date'];
            }
            if(isset($responseArray['orf'])){
                $reservation_status = ($responseArray['orf']==0)? 1 : 2;
            }
            //logged in user object
            $reservationCondition = array('id'=>$reservationId,'res_date' => $roomBookingDate);
            $reservationObject = Reservation::model()->findByAttributes($reservationCondition);
            if(empty($reservationObject)){
                $this->render('//site/error404');
            } else {
                $reservationObject->reservation_status = $reservation_status; // 1: confirmation
                $reservationObject->save();
            }
            // Update invoice table status to 2. 
            $invoiceReservationListObject = InvReservation::model()->findAll('nb_reservation = '. $reservationObject->nb_reservation);
            if(count($invoiceReservationListObject) > 0){
                foreach($invoiceReservationListObject as $invoiceReservationObject){ 
                    //If reservation status is pending then invoice should be same, 2 for confirmed,1 for pending
                    $inv_status = ($reservation_status==1)? 2: 1;
                    
                    $invoiceReservationObject->status = $inv_status;
                    $invoiceReservationObject->save();//update invoice table entry
                }
            }
            
            if($reservationObject->reservation_status == 1 || $reservationObject->reservation_status == 2){
                if($reservationObject->confirmation_type == 1) {
                    $this->sendConfirmationSMS($reservationObject);
                    $this->actionSendConfirmationEmail($reservationObject->id,1);
                } elseif($reservationObject->confirmation_type == 2){
                    $this->actionSendConfirmationEmail($reservationObject->id);
                } else {
                    $this->sendConfirmationSMS($reservationObject);
                    $this->actionSendConfirmationEmail($reservationObject->id);
                }
            }
            $roomObject = Room::model()->findByPk($reservationObject->room_id);
            $hotelObject = Hotel::model()->findByPk($roomObject->hotel_id);
            $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationObject->id);
            $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);
            $this->render('confirmation', array(
                'hotelObject' => $hotelObject,
                'roomObject' => $roomObject,
                'roomBookingDate' => $reservationObject->res_date,
                'reservationOptionObject' => $reservationOptionObject,
                'reservationObject' => $reservationObject
            )); 
        } else {
            $this->render('//site/error404');
        }
    }
    
    /**
     * send reservation confirmation sms.
     * 
     * @param object $reservationObject
     * @return response
     */
    public function sendConfirmationSMS($reservationObject) {
        $roomObject = Room::model()->findByPk($reservationObject->room_id);
        $hotelName = $roomObject->hotel->name;
        $address = $roomObject->hotel->	address;
        $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
        
        if($reservationObject->reservation_status == 2)
            $title = "Reservation On Request.";
        else
            $title = "Reservation Successful.";
            
        $message = $title.'Res RefId: ' . $reservationObject->nb_reservation . '  HOTEL: ' .$hotelName .', on '. $reservationObject->res_date . ' Add : '.$address;
        return BaseClass::sendSMS($customerObject->country->country_code.$customerObject->telephone, $message);
    }

    /**
     * Get course download access using access Key
     * 
     */
    public function actionCallback(){
        $responseArray = $_REQUEST;
        //logged in user object
        $paymentRefId = $responseArray['ref'];
        $conditionArray = array('nb_reference'=> $paymentRefId);
        $coursePaymentObject = CardPayment::model()->findByAttributes($conditionArray);
        $reservationId = $coursePaymentObject->reservation_id;

        $reservationObject = Reservation::model()->findByPk($reservationId);
        $roomId = $reservationObject->room_id;
        $roomObject = Room::model()->findByPk($roomId);
        $hotelId = $roomObject->hotel_id;
        $hotelObject = Hotel::model()->findByPk($hotelId);
        $reservationOptionCondition = array('condition' => 'reservation_id =' . $reservationObject->id);
        $reservationOptionObject = ReservationOption::model()->findAll($reservationOptionCondition);
        $this->actionSendConfirmationEmail($reservationObject);
        //redirect to corse page
        $this->render('confirmation', array(
            'hotelObject' => $hotelObject,
            'roomObject' => $roomObject,
            'roomBookingDate' => $reservationObject->res_date,
            'reservationOptionObject' => $reservationOptionObject,
        )); 
    }
    
        /**
     * update payment response
     * 
     * @param type $responseArray
     * @return status
     */
    public function updatePaymentCallBackResponse($responseArray){
        $paymentRefId = $responseArray['ref'];
        $conditionArray = array('nb_reference'=> $paymentRefId);
        $coursePaymentObject = CardPayment::model()->findByAttributes($conditionArray);
        $coursePaymentObject->nb_reference = $paymentRefId;
        $coursePaymentObject->transaction_code = $responseArray['trans'];
        $coursePaymentObject->status = $responseArray['error'];
        $coursePaymentObject->error_code = $responseArray['error'];
        $coursePaymentObject->save();
    
        if($responseArray['error'] == 0000){
            return 'success';
        } elseif ($responseArray['error'] == 0001){
            return 'cancel';
        } elseif ($responseArray['error'] == 0002){
            return 'faild';
        } else {
            return 'something went wrong!';
        }
    }
    
    /**
     * Generage unique 10 digit key
     * 
     * @return string $randomString
     */
    public function generateCourseKey() {
        //$test  = md5(uniqid(rand())); 
        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$id = Yii::app()->request->getQuery('roomid'); 
		//echo $id;
		$dataProvider=new CActiveDataProvider('Reservation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reservation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reservation']))
			$model->attributes=$_GET['Reservation'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
        
}
