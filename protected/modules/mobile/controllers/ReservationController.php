<?php

class ReservationController extends Controller {

    public $layout = 'main';

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'reservation'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update','edit'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 
     */
    public function actionIndex() {

        $cityName = 'fresno'; //TODO: get from geo location
        $stateName = 'California';
        $countryName = 'USA';

        $hotelModel = Hotel::model();
        $cityModel = City::model();

        $condition = array("slug" => $cityName);
        //read geo location city
        $cityObject = $cityModel->getCityByName($condition);
        // get top 4 cities with the hotel count
        $cityListObject = $cityModel->getCity(4);
        if ($cityObject) {
            $hotelLimit = 3; //
            $cityId = $cityObject->id;
            $cityCondition = 'city_id = ' . $cityId;
            $featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($cityCondition);

            $hotelObject = $hotelModel->readHotel($featuredHotelIdforState, $hotelLimit);

            $otherHotelCondition = "id NOT IN (" . implode(',', $featuredHotelIdforState) . ") AND status = 1";
            $otherHotelObject = $hotelModel->findAll(array('condition' => $otherHotelCondition, 'limit' => $hotelLimit));
            $hotelObject = array_merge($hotelObject, $otherHotelObject);

            $this->render('index', array(
                'hotelObject' => $hotelObject,
                'cityListObject' => $cityListObject)); //080 25721933
        }
    }

    /**
     * Create Admin
     */
    public function actionCreate() {
        $customerModel = new Customer;
        $reservationModel = new Reservation;
        $arrtime = "";
        if ($_REQUEST) {
            if (isset($_REQUEST['hotelId'])) {
                $hotelId = $_REQUEST['hotelId'];
            }
            if (isset($_REQUEST['roomId'])) {
                $roomId = $_REQUEST['roomId'];
            }
            if (isset($_REQUEST['date'])) {
                $roomBookingDate = $_REQUEST['date'];
            }
            if (isset($_REQUEST['arrtime'])) {
                $arrtime = base64_decode($_REQUEST['arrtime']);
            }
            if (isset($_REQUEST['orf'])) {
                $onRequestFlag = $_REQUEST['orf'];
            }
        }
        $reservationOptionObject = array();
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
        $customerObject = Customer::model()->findByPk($customerId);
        //generate verification code
        $varificationCode = BaseClass::getUniqInt(6);
        //generate reservation code
        $reservationCode = BaseClass::getUniqInt(10);
        $message = "";
        if (Yii::app()->session['access_result'] == 'success') {
            $message = 'Access approved!'; //TODO: need read from language file
        }
        if (Yii::app()->session['access_result'] == 'faild') {
            $message = 'Account Does Not exist'; //TODO: need read from language file
        }
        Yii::app()->session['access_result'] = "";
        $isLoggedIn = 1;
        if (empty(Yii::app()->session['userid'])) {
            $isLoggedIn = 0;
        }  
        if ($_POST) { 
            $postDataArray = $_POST;

            Yii::app()->session['varification_type'] = "";
            if($postDataArray['confirmation_via'] == 'sms'){
               Yii::app()->session['varification_type'] = 'sms';
            }
            if (!empty($postDataArray['existing_customer_flag'])) {
                $this->checkCustomerIsExisted($postDataArray);
            } elseif (!$customerObject && empty($postDataArray['id'])) {
                $customreArrayObject = BaseClass::isCustomerFieldDataExisted('telephone', $postDataArray['telephone'], 'email', $postDataArray['email_address']);
                if (!$customreArrayObject) {
                    //Insert into reservation table
                    $customreArrayObject = $this->getCustomerArray($customerModel, $postDataArray);
                    $customreArrayObject->save();
                }
                $customerId = $customreArrayObject->id;
            }

            if ($postDataArray['id']) {
                $customerId = $postDataArray['id'];
                $customerObject = Customer::model()->findByPk($customerId);
                $customreArrayObject = $this->getCustomerArray($customerObject, $postDataArray);
                $customreArrayObject->save();
            }

            if ($postDataArray['action_mode'] == 'edit') { 
                $reservationId = $postDataArray['reservation_id'];
                $reservationDataObject = Reservation::model()->findByPk($reservationId);
                //delete remaining reservation option
                $deleteReservationOption = ReservationOption::model()->findAll(array('condition' => 'reservation_id = ' . $reservationId));
                foreach ($deleteReservationOption as $reservationObject) {
                    $reservationObject->delete();
                }
                
                //edit into reservation table
                $reservationObject = $this->getReservationArray(
                        $reservationDataObject, $roomObject, $customerId, $postDataArray);
                if(!$reservationObject->save()){
                    echo "<pre>"; print_r($reservationObject->getErrors());exit;
                  }
                InvReservation::deleteInvoiceReservationOption($postDataArray['reservation_code'],'1');
            } else {  
                //Insert into reservation table
                $reservationObject = $this->getReservationArray(
                        $reservationModel, $roomObject, $customerId, $postDataArray);
                if(!$reservationObject->save()){
                    echo "<pre>"; print_r($reservationObject->getErrors());exit;
                  }
            }
            $vCode = $varificationCode;
            if(!empty($reservationObject->reservation_code)){
                $vCode = $reservationObject->reservation_code;
            }
            if(isset($postDataArray['confirmation_via'])) { 
                $message = Yii::app()->params['sms_verification_text'] . $vCode;
                $mobileNumber = $postDataArray['country_id'].$customreArrayObject->telephone;
                BaseClass::sendSMS($mobileNumber, $message);
            } else { 
                $this->sendVerificationCode($customreArrayObject, $vCode);
            }
            if(isset($postDataArray['reservation_confirmation_via_email'])){
                 $this->sendVerificationLink($customreArrayObject, $reservationObject);
            }
            $reservationId = $reservationObject->id;
            if ($postDataArray['card_number']) { 
                CardDetails::model()->create($postDataArray, $reservationId);
            }
            //aditional services
            if (!empty($postDataArray['aditional_services'])) {
                $this->addSelectedServices($postDataArray['aditional_services'], $reservationId);
            }
            if(!empty($reservationId)) {
                $resultArray['cId'] = $customreArrayObject->id;//hotel Id
                $resultArray['hId'] = $hotelId;//hotel Id
                $resultArray['rId'] = $reservationId; // reservation Id
                $resultArray['roomId'] = $roomId; // room Id
                $resultArray['rdate'] = $postDataArray['booking_date']; // reservation Date
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
            'reservationCode' => $reservationCode,
            'isLoggedIn' => $isLoggedIn,
            'reservationOptionObject' => $reservationOptionObject,
            'arrtime' => $arrtime,
            'onRequestFlag' => $onRequestFlag,
            'reservationObject' => ''
        ));
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
    * send email
    */
   public function sendVerificationLink($userObject, $reservationObject, $resendEmail= "") {
        if ($reservationObject) {
            $baseurl = Yii::app()->getBaseUrl(true);
            $customerName = $userObject->first_name ." " . $userObject->last_name;
            $encryptedId = BaseClass::md5Encryption($reservationObject->nb_reservation);
            $emailId = $userObject->email_address;
            if(!empty($resendEmail)){
                $emailId = $resendEmail;
            }
            
            $url = Yii::app()->createUrl('/mobile/reservation/confirmation', 
                    array('rId' => $reservationObject->id,
                        'date' =>$reservationObject->res_date,
                        'authId'=>$encryptedId));
            $verificationMail['to'] = $emailId;
            $verificationMail['subject'] = 'Dayuse- Reservation Validation Link';
            $verificationMail['body'] = $this->renderPartial('/mail/reservation_confirm_varification_link', 
                    array('customerName' => $customerName,
                          'varificationLink' => $url,
                          'baseurl'=>$baseurl), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            $result = CommonHelper::sendMail($verificationMail);
        }
    }

    /**
     * resend verification link
     */
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
     * action confirmation
     */
    public function actionConfirmation() {
        if(isset($_REQUEST)){ 
            $responseArray = $_REQUEST;
            if(isset($responseArray['rId'])){
                $reservationId = $responseArray['rId'];
            }
            if(isset($responseArray['date'])){
                $roomBookingDate = $responseArray['date'];
            }
            //logged in user object
            $reservationCondition = array('id'=>$reservationId,'res_date' => $roomBookingDate);
            $reservationObject = Reservation::model()->findByAttributes($reservationCondition);
            if(empty($reservationObject)){
                $this->render('//site/error404');
            } else {
                $reservationObject->reservation_status = 1; // 1: confirmation
                $reservationObject->save();
            }
            // Update invoice table status to 2. 
            $invoiceReservationListObject = InvReservation::model()->findAll('nb_reservation = '. $reservationObject->nb_reservation);
            if(count($invoiceReservationListObject) > 0){
                foreach($invoiceReservationListObject as $invoiceReservationObject){ 
                    $invoiceReservationObject->status = 2;//2: confirmed
                    $invoiceReservationObject->save();//update invoice table entry
                }
            }
            if($reservationObject->reservation_status == 1){
                if($reservationObject->confirmation_type == 1) {
                    $this->sendConfirmationSMS($reservationObject);
                } elseif($reservationObject->confirmation_type == 2){
                    $this->actionSendConfirmationEmail($reservationObject->id);
                } else {
                    $this->actionSendConfirmationEmail($reservationObject->id);
                    $this->sendConfirmationSMS($reservationObject);
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
        $customerObject = Customer::model()->findByPk($reservationObject->customer_id);
        $message = 'Reservation Successful. Res RefId: ' . $reservationObject->nb_reservation . ' Res Date: ' . $reservationObject->res_date;
        return BaseClass::sendSMS($customerObject->telephone, $message);
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
       /**
     * check existing customer
     * 
     * @param type $postDataArray
     */
    public function checkCustomerIsExisted($postDataArray) {
        $phoneNumber = $postDataArray['existing_customer_phone_no'];
        $password = md5($postDataArray['existing_customer_password']);
        $customreObject = Customer::model()->findByAttributes(array('telephone' => $phoneNumber, 'password' => $password));
        
        if($customreObject) {
            $identity=new UserIdentity($phoneNumber,$password);
            if($identity->customerAuthenticate())
            Yii::app()->user->login($identity);
            Yii::app()->session['userid'] = $customreObject->id;
            Yii::app()->session['access_result'] = "success";
            echo CJSON::encode($customreObject);exit;
        } else { 
            Yii::app()->session['access_result'] = "faild";
            echo 0; 
            exit;
        }
    }
    /**
     * get customre array
     * 
     * @param type $customerModel
     * @param type $customerPostArray
     * @return type
     */
    public function getCustomerArray($customerModel, $customerPostArray) {
        $isSecret = 0;

        if (isset($customerPostArray['is_secret'])) {
            $isSecret = $customerPostArray['is_secret'];
        }
        if (isset($customerPostArray['first_name'])) {
            $customerModel->first_name = $customerPostArray['first_name'];
        }
        if (isset($customerPostArray['last_name'])) {
            $customerModel->last_name = $customerPostArray['last_name'];
        }
        if (isset($customerPostArray['email_address'])) {
            $customerModel->email_address = $customerPostArray['email_address'];
        }
        if (isset($customerPostArray['country_id'])) {
            $customerModel->country_id = $customerPostArray['country_id'];
        }
        if (isset($customerPostArray['telephone'])) {
            $customerModel->telephone = $customerPostArray['telephone'];
        }
        if (isset($customerPostArray['password'])) {
            $customerModel->password = md5($customerPostArray['password']);
        }
        if (isset($customerPostArray['input_verification_code'])) {
            $customerModel->auth_code = $customerPostArray['input_verification_code'];
        }

        $customerModel->origin_id = 1; //$customerPostArray['origin_id']; //TODO: Need to confirm with team
        $customerModel->is_subscribed = $isSecret;
        $customerModel->status = 1; //TODO: need to verify with team
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
    public function getReservationArray($reservationModel, $roomObject, $customerId, $postData) {
       
        $verificationCode = "12345"; //TODO= need to remove
        if (isset($postData['varification_code'])) {
            $verificationCode = $postData['varification_code'];
        }
        $isSecret = 0;
        if (isset($postData['is_secret'])) {
            $isSecret = $postData['is_secret'];
        }
        $comment = 'blank';
        if (isset($postData['comment'])) {
            $comment = $postData['comment'];
        }
        if (!empty($postData['reservation_code'])) {
            $reservationModel->nb_reservation = $postData['reservation_code'];
        }
        $reservationModel->customer_id = $customerId;

        $reservationModel->portal_id = 1; //TODO: Need to confirm with team
        $reservationModel->room_id = $roomObject->id;
        if (!empty($postData['booking_date'])) {
            $reservationModel->res_date = $postData['booking_date'];
        }
        $reservationModel->res_from = $roomObject->available_from;
        $reservationModel->res_to = $roomObject->available_till;
        $reservationModel->room_price = $roomObject->default_price;
        $reservationModel->currency_id = 1; //TODO: Need to confirm with team
        $reservationModel->comment = $comment; //$postData['comment'];//TODO: Need to modify the database because comment is not mandetory field
        if (!empty($postData['arrival_time'])) {
            $reservationModel->arrival_time = $postData['arrival_time'];
        }
        if(!empty($postData['reservation_confirmation_via_text'])) {
            $reservationModel->confirmation_type = 1; // 1: sms
        }
        if(!empty($postData['reservation_confirmation_via_email'])){
            $reservationModel->confirmation_type = 2; //2: Email
        }
        $reservationModel->is_secret = $isSecret;
        $reservationModel->reservation_code = $verificationCode;
        if (!empty($postData['onRequestFlag'])) {
            $reservationModel->reservation_status = $postData['onRequestFlag'];
        } else {
            $reservationModel->reservation_status = 0;
        }
        $reservationModel->payment_status = 1; //TODO: Need to confirm with team
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
     * send confirmation email
     * 
     * @param type $reservationId
     */
    public function actionSendConfirmationEmail($reservationId) {
        $reservationObject = Reservation::model()->findByPk($reservationId);
        if ($reservationObject) {
            $reservationId = $reservationObject->id;
            $roomId = $reservationObject->room_id;
            $roomObject = Room::model()->findByPk($roomId);
            $conditionArray = array('condition' => 'reservation_id = ' . $reservationId);
            $reservationOptionObject = ReservationOption::model()->findAll($conditionArray);

            $hotelObject = Hotel::model()->findByPk($roomObject->hotel_id);
            $customerObjecct = Customer::model()->findByPk($reservationObject->customer_id);

            $baseUrl = Yii::app()->getBaseUrl(true);
            $customerName = $customerObjecct->first_name . " " . $customerObjecct->last_name;
            $emailId = $customerObjecct->email_address;
            $verificationMail['to'] = $emailId;
            $verificationMail['subject'] = 'Dayuse- Reservation Confirmation !';
            $verificationMail['body'] = $this->renderPartial('/mail/reservation_confirmation', array('customerName' => $customerName,
                'baseUrl' => $baseUrl,
                'reservationObject' => $reservationObject,
                'reservationOptionObject' => $reservationOptionObject,
                'roomObject' => $roomObject,
                'hotelObject' => $hotelObject,
                'customerObjecct' => $customerObjecct), true);
            $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
            return $result = CommonHelper::sendMail($verificationMail);
        }
    }

    /**
     * Save services in to db
     * 
     * @param type $postDataArray
     */
    public function addSelectedServices($postDataArray, $reservationId) {
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
        $arrtime ="";
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
            } else if(isset ($_REQUEST['resId'])) { 
                $reservationId = $_REQUEST['resId'];
            } else {
                $this->render('//site/error404');
            }
            if (isset($_REQUEST['orf'])) {
                $onRequestFlag = $_REQUEST['orf'];
            }
            if (isset($_REQUEST['arrtime'])) {
                $arrtime = base64_decode($_REQUEST['arrtime']);
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
            if(!empty($reservationId)){
                $this->actionSendConfirmationEmail($reservationId);
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
            'onRequestFlag' => $onRequestFlag,
            'arrtime' => $arrtime,
        ));
    }

}
