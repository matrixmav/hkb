<?php

class InvoiceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('create', 'update', 'index', 'view', 'delete',
                    'bills', 'updatebills', 'readequipment', 'updateinvoiceeqipment',
                    'addequipment', 'cronhotelinvoice', 'deletereservationinvoice', 
                    'updateinvoicepayment','change','sendbill','reminder','hotelbills',
                    'downloadinvoice','regulationstatus','createhotelbillcsv','createregulationstatuscsv',
                    'getpaymentinvoice'),
                
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionGetPaymentInvoice(){
        if($_REQUEST['id']){
            $invoicePaymentListObject = InvoicePayment::model()->findAll('inv_no = '.$_REQUEST['id']);
            if(!empty($invoicePaymentListObject)){
                $tableDiv = ""; 
                foreach($invoicePaymentListObject as $invoiceObject){
                    $paymentType = " - Cash"; 
                    if($invoiceObject->payment_type==1){
                        $paymentType = " - Cheque"; 
                    }
                    $paymentRef = "";
                    if(!empty($invoiceObject->payment_ref)){
                        $paymentRef = " - ". $invoiceObject->payment_ref;
                    }
                    $tableDiv[] = "<tr class='temprow' bgcolor='#C0C0C0' ><td>&nbsp;</td><td>".BaseClass::convertStandardDateFormate($invoiceObject->payment_date)."</td><td colspan='5'>".$invoiceObject->bank->code.$paymentType.$paymentRef."</td><td>".$invoiceObject->paid_inv."</td><td colspan='2'>&nbsp;</td></tr>";
                } 
                $invString = implode(" ", $tableDiv);
                echo json_encode($invString);
                Yii::app()->end();
            } else {
               echo 1;exit; 
            }
        }
    }

    public function actionRegulationStatus(){
        $month = date('m');
        $pageSize = Yii::app()->params['defaultPageSize'];

        if(!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
            $year = $_REQUEST['year'];
            $month = $_REQUEST['month'];
        } else {
            $year = date('Y');
            $month = date('m');
            $status = 1;
        }
        $criteria = new CDbCriteria;
        $criteria->alias='p';
        $criteria->with = 'invoice';
        //previous logic date based on invoice date
        //$criteria->with = array('invoice'=> array('joinType'=>'INNER JOIN', 'condition'=> 'invoice.inv_month = '.$month . ' AND invoice.inv_year = '.$year));
        
        //new logic to have data based on the paymant date
        $criteria->addCondition("date_format(p.payment_date,'%m')=".$month);
        $criteria->addCondition("date_format(p.payment_date,'%Y')=".$year);
        
        $access = Yii::app()->user->getState('access');
        if($access=='manager')
        {
            $Allowed_hids = Yii::app()->user->getState('AccHotels');
            $criteria->addInCondition('p.hotel_id',$Allowed_hids);
        }
        
        $dataProvider = new CActiveDataProvider('InvoicePayment'
                ,array('criteria'=>$criteria,
            'pagination' => array('pageSize' => $pageSize),)
                );
        
        $originObject = Portal::model()->findAll();
        $reservationCount = 1;//InvoicePayment::model()->count(array('condition'=> ('payment_date >= "'.$toDate . '" AND payment_date <= "'.$fromDate . '"' . $condition)));
        $showDateFlag = 1;
        
        $this->render('regulationstatus',array(
                'dataProvider'=>$dataProvider,
                'originObject'=>$originObject,
                'reservationCount' => $reservationCount,
                'showDateFlag' => $showDateFlag,
                'selectedMonth'=>$month
        ));
    }
    
    public function actionCreateRegulationStatusCsv(){
        // Any changes here should be replicated to the actionHotelBills
        
        Yii::import('ext.csv.ECSVExport');
        
        $month = (!empty($_REQUEST['month']))? $_REQUEST['month'] : 0;
        $year = (!empty($_REQUEST['year']))? $_REQUEST['year'] : date('Y');

        $criteria = new CDbCriteria;
        $criteria->alias='p';
        $criteria->with = 'invoice';
          
        $criteria->addCondition("date_format(p.payment_date,'%m')=".$month);
        $criteria->addCondition("date_format(p.payment_date,'%Y')=".$year);
        
        $access = Yii::app()->user->getState('access');
        if($access=='manager')
        {
            $Allowed_hids = Yii::app()->user->getState('AccHotels');
            $criteria->addInCondition('p.hotel_id',$Allowed_hids);
        }
        
        //$dataProvider = new CActiveDataProvider('InvoicePayment',array('criteria'=>$criteria,));
        $model = InvoicePayment::model()->findAll($criteria);
        
        $dataProvider = array();
        foreach($model as $data)
        {
            $dt = array();
            
            $dt['InvoiceDate']=$data->invoice->inv_due_date; 
            $dt['Invoice']=$data->inv_no; 
            $dt['Client']=$data->hotel->name;
            $dt['Amount']=$data->paid_inv;
            $dt['Means']=($data->payment_type == 1)?"Cheque":"Cash";
            $dt['Reference']=$data->payment_ref;
            $dt['BankCode']=$data->bank->code;
            $dt['PaymentDate']=$data->payment_date;
                
            array_push($dataProvider, $dt);
        }
 
        // for use with array of arrays
        //$dataProvider = array(array('key1'=>'value1', 'key2'=>'value2'),array('key1'=>'value1', 'key2'=>'value2'));

        $csv = new ECSVExport($dataProvider);
        $output = $csv->toCSV(); // returns string by default
        
        $addName = ($month)? "-".$month."-".$year : "-".$year;
        $filename = "PaymentHistory".$addName.".csv";

        Yii::app()->getRequest()->sendFile($filename, $output, "text/csv", false);
        exit();
    }
        /**
     * Hotel bills
     */
    public function actionHotelBills(){
        
        // Any changes here should be replicated to the actionCreateHotelBillCsv
        $model = new Invoice();
        $pageSize = Yii::app()->params['defaultPageSize'];
        
        $month = (!empty($_REQUEST['Invoice']['month']))? $_REQUEST['Invoice']['month'] : 0;
        $year = (!empty($_REQUEST['Invoice']['year']))? $_REQUEST['Invoice']['year'] : date('Y');
        
        if(!empty($_REQUEST['invoice_search'])){
            $criteria = new CDbCriteria;
            $criteria->with = array('hotel');
            $criteria->addCondition('hotel.name LIKE "%'.$_REQUEST['invoice_search'].'%"','OR');
            $criteria->addCondition('inv_no  LIKE "%'.$_REQUEST['invoice_search'].'%"','OR');            
        }
        else
            $criteria = new CDbCriteria;
        
        if($month)
            $criteria->addCondition('inv_month ='.$month);
        $criteria->addCondition('inv_year ='.$year);
        
        $access = Yii::app()->user->getState('access');
        if($access=='manager')
        {
            $Allowed_hids = Yii::app()->user->getState('AccHotels');
            $criteria->addInCondition('hotel_id',$Allowed_hids);
        }
        
        $dataProvider = new CActiveDataProvider('Invoice', array(
                'criteria' => $criteria,
                'pagination' => array('pageSize' => $pageSize),));

        $model = $model->findAll($criteria);
//            echo "<pre>"; print_r($model);exit;
        $this->render('hotelBills', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'selectedYear' =>$year,
            'selectedMonth' =>$month,
        ));
    }
    
    public function actionCreateHotelBillCsv(){
        // Any changes here should be replicated to the actionHotelBills
        
        Yii::import('ext.csv.ECSVExport');
        
        $month = (!empty($_REQUEST['month']))? $_REQUEST['month'] : 0;
        $year = (!empty($_REQUEST['year']))? $_REQUEST['year'] : date('Y');

        /*if(!empty($_REQUEST['stxt'])){
            $criteria = new CDbCriteria;
            //$criteria->with = array('hotel'=>array('joinType'=>'LEFT OUTER JOIN'));            
            $criteria->with = array('hotel');
            $criteria->addCondition('hotel.name LIKE "%'.$_REQUEST['stxt'].'%"','OR');
            $criteria->addCondition('inv_no  LIKE "%'.$_REQUEST['stxt'].'%"','OR');            
        }
        else*/
            $criteria = new CDbCriteria;
        
        if($month)
            $criteria->addCondition('inv_month ='.$month);
        $criteria->addCondition('inv_year ='.$year);
        
        
        $criteria->select="inv_no as InvoiceNumber,inv_date as InvoiceDate,account_no as AccountNumber,inv_label as InvoiceLabel,"
                . "hotel_inv as HotelInvoiceAmt,vat_amt as VatAmount,total_inv as TotalInvoiceAmount,paid_inv as PaidAmount,"
                . "pending_inv as PendingAmount,reminder_nos as ReminderSent,inv_due_date as InvoiceDueDate";
        
        $access = Yii::app()->user->getState('access');
        if($access=='manager')
        {
            $Allowed_hids = Yii::app()->user->getState('AccHotels');
            $criteria->addInCondition('hotel_id',$Allowed_hids);
        }
        
        $dataProvider = new CActiveDataProvider('Invoice', array('criteria' => $criteria,));
        
        // for use with array of arrays
        //$dataProvider = array(array('key1'=>'value1', 'key2'=>'value2'),array('key1'=>'value1', 'key2'=>'value2'));

        $csv = new ECSVExport($dataProvider);
        $output = $csv->toCSV(); // returns string by default
        
        $addName = ($month)? "-".$month."-".$year : "-".$year;
        $filename = "HotelInvoiceDetail".$addName.".csv";

        Yii::app()->getRequest()->sendFile($filename, $output, "text/csv", false);
        exit();
    }
    
    /**
     * send reminder
     */
    public function actionReminder(){
        
        if(!empty($_POST['cid'])){ //echo "<pre>"; print_r($_POST);exit;
            if(isset($_POST['send_reminder']) && !empty($_POST['send_reminder'])){
                foreach($_POST['cid'] as $inVoiceId) { 
                    $invoiceObject = Invoice::model()->findByPk($inVoiceId);
                    $hotelContract = HotelContact::model()->findByAttributes(array('hotel_id'=>$invoiceObject->hotel_id,'contact_type'=>1));
                    if($hotelContract){
                        $this->createPdf($hotelContract->email_address,$hotelContract->id,$invoiceObject); 
                           $invoiceObject->reminder_nos = ($invoiceObject->reminder_nos+1);
                           if(!$invoiceObject->save(FALSE)){
                               var_dump($invoiceObject->getErrors());exit;
                          }
                        $reminderObject = new InvoiceReminder;
                        $reminderObject->inv_no = $invoiceObject->inv_no;
                        $reminderObject->reminder_date = new CDbExpression('NOW()');
                        $reminderObject->total_inv = $invoiceObject->total_inv;
                        $reminderObject->pending_inv = $invoiceObject->pending_inv;
                        $reminderObject->aduser_id = Yii::app()->user->getState('user_id');
                        $reminderObject->added_at = new CDbExpression('NOW()');
                        $reminderObject->updated_at = new CDbExpression('NOW()');
                        if(!$reminderObject->save()){
                            var_dump($reminderObject->getErrors());exit;
                        }
                    }
                }
            } else if(isset($_POST['block']) && !empty($_POST['block'])){ //
                foreach($_POST['cid'] as $inVoiceId) { 
                    $invoiceObject = Invoice::model()->findByPk($inVoiceId);
                    $hotelObject = Hotel::model()->findByPk($invoiceObject->hotel_id);
                    if($hotelObject){
                        $hotelObject->reminder_block = 1;
                        $hotelObject->save();
                    }
                }
            } else {
                foreach($_POST['cid'] as $inVoiceId) { 
                    $invoiceObject = Invoice::model()->findByPk($inVoiceId);
                    $hotelObject = Hotel::model()->findByPk($invoiceObject->hotel_id);
                    if($hotelObject){
                        $hotelObject->reminder_block = 0;
                        $hotelObject->save();
                    }
                }
            }
        }
        $nonBlockedInvoiceListCriteria = new CDbCriteria(array(
                'with'=>array('hotel'=>array('joinType'=>'INNER JOIN', 'condition'=>'hotel.reminder_block= 0')),
                'condition'=>'t.pending_inv != "0.00"',
                'together'=>true,
        ));
        
        $nonBlockedInvoiceListDataProvider = new CActiveDataProvider('Invoice', array(
            'criteria' => $nonBlockedInvoiceListCriteria,
        ));
        
        $blockedInvoiceListCriteria = new CDbCriteria(array(
                'with'=>array('hotel'=>array('joinType'=>'INNER JOIN', 'condition'=>'hotel.reminder_block= 1')),
                'condition'=>'t.pending_inv != "0.00"',
                'together'=>true,
        ));
        
         $blockedInvoiceListDataProvider = new CActiveDataProvider('Invoice', array(
            'criteria' => $blockedInvoiceListCriteria,
        ));
        
        $model = Invoice::model()->findAll($nonBlockedInvoiceListCriteria);
        $modelBlock = Invoice::model()->findAll($blockedInvoiceListCriteria);
        $this->render('reminder', array(
            'nonBlockedInvoiceListDataProvider' => $nonBlockedInvoiceListDataProvider,
            'blockedInvoiceListDataProvider'=>$blockedInvoiceListDataProvider,
            'model'=> $model,
            'modelBlock'=> $modelBlock
        ));
    }

    /**
     * download all hotel invoice
     */
    public function actionDownloadInvoice(){
        
        if(!empty($_REQUEST['invId'])){          
            $inVoiceId = $_REQUEST['invId'];
            $invoiceObject = Invoice::model()->findByPk($inVoiceId);
            $con_hid = $invoiceObject->hotel_id;
            $folder=Yii::app()->params->imagePath['hoteldropzone'];// folder for uploaded files
            $idPath = $con_hid."/invoice/";
            $inputpath = $folder .$idPath;
            $hotel_folder = $folder.$con_hid."/";
            
            if (!is_dir($inputpath) && !mkdir($inputpath,'0777',true)){
                    die("Error creating folder $inputpath");
            }
            chmod($inputpath, 0777); 

            $todayDay = '1';
            $fromDay = '31';
            $toResDate = $invoiceObject->inv_year ."-". $invoiceObject->inv_month."-".$todayDay;
            $fromResDate = $invoiceObject->inv_year ."-". $invoiceObject->inv_month."-".$fromDay;

            $criteria = new CDbCriteria();
            $criteria->addCondition('status = 2');
            $criteria->addCondition('opt_type = "room"');
            $criteria->addCondition('hotel_id = '.$invoiceObject->hotel_id);
            $criteria->addBetweenCondition('res_date', $toResDate, $fromResDate);

            $invReservationObject = InvReservation::model()->findAll($criteria);
            $administrativeObject = HotelAdministrative::model()->findByAttributes(array('hotel_id' => $invoiceObject->hotel_id));
            $baseUrl = Yii::app()->getBaseUrl(true);
            $downType = isset($_REQUEST['type'])? $_REQUEST['type'] : 1;
            $pdfReservationfile = $this->renderPartial('/mail/send_invoice_to_hotel', 
                    array('baseUrl'=>$baseUrl,
                        'type'=>$downType,
                        'invReservationObject' => $invReservationObject,
                        'invoiceObject'=>$invoiceObject,
                        'administrativeObject'=>$administrativeObject), true);
            /*$pdfReservationfile = $this->renderPartial('/mail/send_invoice_to_hotel', 
                    array('baseUrl'=>$baseUrl,
                        'invReservationObject' => $invReservationObject,
                        'invoiceObject'=>$invoiceObject,
                        'administrativeObject'=>$administrativeObject));
            echo $pdfReservationfile;
            exit;
            */
            $fileNewName = $invoiceObject->inv_no;
            $fileName = $fileNewName.'_'.date('d-m-Y').'.pdf';
            $outputFilePath = $inputpath.'/'.$fileName;
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($pdfReservationfile);
            $html2pdf->Output($outputFilePath, EYiiPdf::OUTPUT_TO_FILE);
            chmod($outputFilePath, 0777);
            //echo $outputFilePath;
            $sendMail = isset($_REQUEST['send_email'])? $_REQUEST['send_email'] : 0;
            if($sendMail==0)
            {
                BaseClass::downloadFile($outputFilePath);
                exit;
            }
            else
            {
                $contactMail['from'] = Yii::app()->params['dayuseInfoEmail'];              
                //$contactMail['to'] = 'sandeep.sen@itvillage.fr';//$email;
                $contactMail['to'] = 'arnaud.daniel@gmail.com';//$email;
                $contactMail['subject'] = 'Dayuse- Hotel Monthly Invoice';
                $contactMail['file_path'] = $outputFilePath;


                $contactMail['body'] = 'Dayuse- Hotel Reservation Invoice';

                $result = CommonHelper::sendMail($contactMail);
                $this->redirect(array('invoice/hotelbills'));
            }            
        }
    }

    public function createPdf($email,$hotelId,$invoiceObject){
        $con_hid = $hotelId;
        $folder=Yii::app()->params->imagePath['hoteldropzone'];// folder for uploaded files
        $idPath = $con_hid."/contract/";
        $inputpath = $folder .$idPath;
        $hotel_folder = $folder.$con_hid."/";
        
        if (!is_dir($hotel_folder) && !mkdir($hotel_folder,'0777',true)){
                die("Error creating folder $hotel_folder");
        }
        chmod($hotel_folder, 0777);

        if (!is_dir($inputpath) && !mkdir($inputpath,'0777',true)){
                die("Error creating folder $inputpath");
        }
        chmod($inputpath, 0777); 
        
        $todayDay = '1';
        $fromDay = '31';
        $toResDate = $invoiceObject->inv_year ."-". $invoiceObject->inv_month."-".$todayDay; 
        $fromResDate = $invoiceObject->inv_year ."-". $invoiceObject->inv_month."-".$fromDay;
        
        $criteria = new CDbCriteria();
        $criteria->addCondition('status = 2');
        $criteria->addCondition('opt_type = "room"');
        $criteria->addCondition('hotel_id = '.$invoiceObject->hotel_id);
        $criteria->addBetweenCondition('res_date', $toResDate, $fromResDate);
          
        $invReservationObject = InvReservation::model()->findAll($criteria);
        $administrativeObject = HotelAdministrative::model()->findByAttributes(array('hotel_id' => $invoiceObject->hotel_id));
        $baseUrl = Yii::app()->getBaseUrl(true);
        $pdfReservationfile = $this->renderPartial('/mail/send_invoice_to_hotel', 
                array('baseUrl'=>$baseUrl,
                    'invReservationObject' => $invReservationObject,
                    'invoiceObject'=>$invoiceObject,
                    'administrativeObject'=>$administrativeObject), true);
        
        $fileName = $hotelId.'_'.date('d-m-Y').'.pdf';
        $outputFilePath = $inputpath.'/'.$fileName;
        $html2pdf = Yii::app()->ePdf->HTML2PDF();
        $html2pdf->WriteHTML($pdfReservationfile);
        $html2pdf->Output($outputFilePath, EYiiPdf::OUTPUT_TO_FILE);
        chmod($outputFilePath, 0777);

        //Send Email along with the attachment

        
        $contactMail['from'] = Yii::app()->params['dayuseInfoEmail'];              
        //$contactMail['to'] = 'sandeep.sen@itvillage.fr';//$email;
        $contactMail['to'] = 'arnaud.daniel@gmail.com';//$email;
        $contactMail['subject'] = 'Dayuse- Hotel Reservation Invoice';
        $contactMail['file_path'] = $outputFilePath;

        
        $contactMail['body'] = 'Dayuse- Hotel Reservation Invoice';
            
        $result = CommonHelper::sendMail($contactMail);
    }
    
    public function actionChange(){
        $invReservationObject = InvReservation::model()->findByPk($_POST['id']);
        if(!empty($_POST['status'])){
            $invReservationObject->status = $_POST['status'];
            $invReservationObject->save();
            $reservationObject = Reservation::model()->findByAttributes(array('nb_reservation' => $invReservationObject->nb_reservation));
            $reservationObject->reservation_status = $_POST['status'];
            $reservationObject->save();
            echo json_encode('success');exit;
            Yii::app()->end();
        }
        if(!empty($_POST)){
            $invReservationObject->availed = $_POST['availed'];
            $invReservationObject->save();
            echo json_encode('success');exit;
            Yii::app()->end();
        }
    }
    /**
     * read equipments
     */
    public function actionReadEquipment() {
        if ($_POST) {
            $equipmentObject = Equipment::model()->findByPk($_POST['equipmentId']);
            echo json_encode($equipmentObject->default_price);
            Yii::app()->end();
        }
    }

    public function actionAddEquipment() {
        if ($_POST) {
            $reservationCondition = array('nb_reservation' => $_POST['nb_reservation']);
            $reservationObject = InvReservation::model()->findByAttributes($reservationCondition);
            $invReservationObject = new InvReservation;
            $invReservationObject->nb_reservation = $_POST['nb_reservation'];
            $invReservationObject->hotel_id = $reservationObject->hotel_id;
            $invReservationObject->res_date = $reservationObject->res_date;
            $invReservationObject->opt_title = $_POST['equipment_name'];
            $invReservationObject->opt_type = 'manual';
            $invReservationObject->opt_id = 0;
            $invReservationObject->opt_curr_id = 1; //TODO: change based on currency
            $invReservationObject->opt_price = $_POST['opt_price'];
            $invReservationObject->comm_perc = $_POST['comm_perc'];
            $invReservationObject->comm_amt = $_POST['comm_amt'];
            $invReservationObject->vat_perc = $_POST['vat_perc'];
            $invReservationObject->total_comm_amt = $_POST['total_comm_amt'];
            $invReservationObject->status = 2; //2: completed
            $invReservationObject->added_at = new CDbExpression('NOW()');
            $invReservationObject->updated_at = new CDbExpression('NOW()');
            if ($invReservationObject->save()) {
                echo json_encode($invReservationObject->id);
            } else {
                print_r($invReservationObject->getErrors());
            }
            Yii::app()->end();
        }
    }

    public function actionUpdateInvoiceEqipment() {
        if ($_POST) {
            $invReservationObject = InvReservation::model()->findByPk($_POST['invoiceId']);
            if ($invReservationObject->opt_type == 'manual') {
                $invReservationObject->opt_title = $_POST['equipment_name'];
            } else {
                if (!empty($_POST['opt_id'])) {
                    $invReservationObject->opt_id = $_POST['opt_id'];
                } else {
                    $invReservationObject->opt_id = 0;
                }
            }
            $invReservationObject->opt_price = $_POST['opt_price'];
            $invReservationObject->comm_perc = $_POST['comm_perc'];
            $invReservationObject->comm_amt = $_POST['comm_amt'];
            $invReservationObject->vat_perc = $_POST['vat_perc'];
            $invReservationObject->total_comm_amt = $_POST['total_comm_amt'];
            if ($invReservationObject->save()) {
                echo json_encode($invReservationObject->id);
            } else {
                echo "0";
            }
            Yii::app()->end();
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Invoice;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Invoice'])) {
            $model->attributes = $_POST['Invoice'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Invoice'])) {
            $model->attributes = $_POST['Invoice'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        
        $access = Yii::app()->user->getState('access');
        
        $month = date('m');
        $pageSize = Yii::app()->params['defaultPageSize'];
        
        //Get the from and to date
        $user_month = isset($_REQUEST['month']) ? $_REQUEST['month'] : date('n');
        $user_year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date('Y');
                    
        $fromDate = $user_year.'-'.$user_month.'-1'; 
        $toDate = BaseClass::getlastDate($user_month,$user_year);
        
        $orderBy = isset($_GET['order']) ? 'order by id DESC' : ' order by id ASC';
        
        $hotelId = isset($_REQUEST['selected_hotel_id'])? $_REQUEST['selected_hotel_id'] : 0;
        //For the Admin
        if($access!='manager')
            $addhotel = ($hotelId!=0) ? ' and hotel_id='.$hotelId : '';
        else
        {
            //For the hotel managers
            $Allowed_hids = Yii::app()->user->getState('AccHotels');
            $Hids = implode(',',$Allowed_hids);
            $addhotel=' and hotel_id in ('.$Hids.')';
            
            //check the hotel id which is being searched is in the accesslist for the manager
            if($hotelId!=0)
            {
                if(in_array($hotelId,$Allowed_hids))
                    $addhotel=' and hotel_id='.$hotelId;
            }            
        }
        
        $condition = ' res_date >= "'.$fromDate.'" and res_date <= "'.$toDate.'" and opt_type="room" AND status IN(2,5)'.$addhotel." GROUP BY hotel_id ".$orderBy;
        $resv_condition = ' and res_date >= "'.$fromDate.'" and res_date <= "'.$toDate.'" AND status IN(2,5)';
                
        $invReservationListObject = InvReservation::model()->findAll($condition);

        $showDateFlag = 1;
        $this->render('index', array(
            'invReservationListObject' => $invReservationListObject,
            'showDateFlag' => $showDateFlag,
            'selectedMonth' => $user_month,
            'selectedYear' => $user_year,
            'resv_condition'=>$resv_condition
        ));
    }
    /**
     * Lists all Bills.
     */
    public function actionBills($id, $type) {
        $model = new Invoice();
        $user_month = isset($_REQUEST['Invoice']['month']) ? $_REQUEST['Invoice']['month'] : 0;
        $user_year = isset($_REQUEST['Invoice']['year']) ? $_REQUEST['Invoice']['year'] : date('Y');
        
        $month = ($user_month!= 0) ? " and inv_month=".$user_month : "";
        $year = ($user_year!= 0) ? " and inv_year=".$user_year : " and inv_year=".date('Y');
        
        $criteria = new CDbCriteria(array(
                'condition' => 'hotel_id='.$id.$month.$year,
            ));
        
        $dataProvider = new CActiveDataProvider('Invoice', array(
            'criteria' => $criteria,
        ));
        $model = $model->findAll($criteria);
        $this->render('bills', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'type' => $type,
            'hotel_id' => $id,
            'user_month'=>$user_month,
            'user_year'=>$user_year
        ));
    }
    
    public function getDateFormate($data, $row){
        if(!empty($data->inv_date)){
            $inputDate = new DateTime($data->inv_date);
            echo $fromtime1 = $inputDate->format('d/m/Y');
        } else {
            echo "";
        }
    }
    
    public function getInvDueDate($data, $row){
        if(!empty($data->inv_due_date)){
            $inputDate = new DateTime($data->inv_due_date);
            echo $fromtime1 = $inputDate->format('d/m/Y');
        } else {
            echo "";
        }
        
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateBills($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Invoice'])) {
            $model->attributes = $_POST['Invoice'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
        }

        $this->render('updatebills', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Invoice('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Invoice']))
            $model->attributes = $_GET['Invoice'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Invoice the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Invoice::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Invoice $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCronhotelinvoice() {
        $duration = Yii::app()->params->default['invoice_payment_duration'];
                
        $criteria = new CDbCriteria();
        $criteria->condition = "status=1";
        $criteria->with = "hotelAdministratives";
        $hotel = Hotel::getAllHotel($criteria);
        
        foreach ($hotel->getData() as $hotel) {
            
            $cur_year = date('Y');
            //MONTH( CURDATE( ) )YEAR( CURDATE())
            for($m=1;$m<=12;$m++)
            {
                $invRes = InvReservation::model()->findAll("status = 2 and `hotel_id` = $hotel->id
                                                        AND YEAR( `res_date` ) = ".$cur_year."
                                                        AND MONTH( `res_date` ) = ".$m);
                
                
                
                if (isset($invRes) && !empty($invRes)) {
                    $comm_amt = $vat_amt = $total_comm_amt = "";
                    foreach ($invRes as $invRe) {
                        $comm_amt += $invRe->comm_amt;
                        $vat_amt += $invRe->vat_amt;
                        $total_comm_amt += $invRe->total_comm_amt;
                    }

                    $invoiceCriteria = new CDbCriteria();
                    $invoiceCriteria->select = "inv_no";
                    $invoiceCriteria->order = "inv_no desc";
                    $invoiceCriteria->limit = 1;
                    $invoice = Invoice::model()->find($invoiceCriteria);
                    $invoiceno = isset($invoice->inv_no) ? $invoice->inv_no : 0;

                    $invoices = Invoice::model()->find("hotel_id=" . $hotel->id . " AND inv_year = ".$cur_year."
                                            AND inv_month = ".$m);
                    $new_no = false;
                    if (!$invoices) {
                        $invoices = new Invoice();
                        $new_no = true;
                    }
                    $initial_no = (($hotel->country_id * 10000) + $cur_year) * 1000000;
                    
                    $last_date = BaseClass::getlastDate($m,$cur_year);
                    $due_date = date('Y-m-d', strtotime($last_date. ' + '.$duration.' days'));
                    $inv_date = date('Y-m-d', strtotime($last_date));
                    $inv_month = date('m',strtotime($last_date));
                    
        

                    $invoices->inv_no = ($new_no) ? $initial_no + ($invoiceno + 1) : $invoices->inv_no; //countryid,year,6digit autoinc
                    $invoices->inv_date = $inv_date;
                    $invoices->inv_month = $inv_month;
                    $invoices->inv_year = $cur_year;
                    $invoices->hotel_id = $hotel->id;
                    $invoices->inv_country = $hotel->country_id;
                    $invoices->account_no = isset($hotel->hotelAdministratives[0]->account_no) ? $hotel->hotelAdministratives[0]->account_no : "";
                    $invoices->inv_label = "Monthly Recap " .$m." ".$cur_year;
                    $invoices->hotel_inv = $comm_amt;
                    $invoices->vat_amt = $vat_amt;
                    
                    $invoices->inv_due_date = $due_date;
                    $invoices->total_inv = $total_comm_amt;
                    $invoices->paid_inv = 0;
                    $invoices->pending_inv = $total_comm_amt;
                    $invoices->save();
                }
            }
        }
    }

    /**
     * Set status to 0 : deleted or inactive
     */
    public function actionDeleteReservationInvoice() {
        if ($_REQUEST) {
            $invoiceObject = InvReservation::model()->findByPk($_REQUEST['id']);
            $invoiceObject->status = 0; // 0: deleted
            $invoiceObject->save();
            $this->redirect(array('index'));
        }
    }

    public function actionUpdateInvoicePayment() {
        
        if($_REQUEST) {  //echo "<pre>"; print_r($_REQUEST);exit;
            $invoicePaymentObject = new InvoicePayment();
            $invoicePaymentObject->hotel_id = $_REQUEST['hotel_id'];
            $invoicePaymentObject->bank_id = $_REQUEST['bank'];
            $invoicePaymentObject->paid_inv = $_REQUEST['amount'];
            $invoicePaymentObject->inv_no = $_REQUEST['inv_number'];
            $invoicePaymentObject->payment_date = new CDbExpression('NOW()');
            $invoicePaymentObject->payment_ref = $_REQUEST['refrence'];
            $paymentMode = 1;
            if($_REQUEST['payment_mode'] == 'Cheque'){
                $paymentMode = 2;
            }
            $invoicePaymentObject->payment_type = $paymentMode;
            if($invoicePaymentObject->save()){
                if(!empty($_REQUEST['inv_id'])){
                    $invoiceObject = Invoice::model()->findByPk($_REQUEST['inv_id']);
                    if(!empty($invoiceObject)){
                        $invoiceObject->pending_inv = ($invoiceObject->pending_inv - $_REQUEST['amount']);
                        $invoiceObject->save();
                    }
                }
            }
        }
        $redirectUrl = Yii::app()->createUrl('admin/invoice/hotelbills', 
                array('id' => $_REQUEST['hotel_id'],'type'=>'bill'));
        $this->redirect($redirectUrl);
    }

    public function getInvoiceedit($data, $row) {

        $bankList = Bank::model()->findAll();
        echo $this->renderPartial('invoiceActions', array('bankList' => $bankList,
            'data' => $data), true);
    }
    
    public function getAllInvoiceLink($data, $row) {
       // removed parameter as $column, it gives the column information
        //$send_email = ($column->name == 'Send')? 1 : 0;
        $bankList = Bank::model()->findAll();
        echo $this->renderPartial('allHotelInvoiceActions', array('bankList' => $bankList,
            'data' => $data), true);
    }
    
    public function actionSendBill() {
        if($_POST){
            $hotelId = $_POST['hotelId'];
            $invReservationObject = InvReservation::model()->findAll(array('condition'=>'status = 2 AND hotel_id = '.$hotelId));
             
            if($invReservationObject){
                $hotelAdministrativeObject = HotelEmail::model()->findByAttributes(array('hotel_id' => $hotelId));
                $baseUrl = Yii::app()->getBaseUrl(true);
                $emailId = $hotelAdministrativeObject->email_add;
                $hotelAdministrativeArray['to'] = $emailId;
                $hotelAdministrativeArray['subject'] = 'Dayuse- Hotel Reservation Invoice !';

                $hotelAdministrativeArray['body'] = $this->renderPartial('/mail/send_invoice_to_hotel', 
                        array('baseUrl'=>$baseUrl,
                            'invReservationObject' => $invReservationObject), true);
                $hotelAdministrativeArray['from'] = Yii::app()->params['dayuseInfoEmail'];
                $result = CommonHelper::sendMail($hotelAdministrativeArray);
                echo "<pre>";print_r($result);exit;
            }
        }
    }
}
