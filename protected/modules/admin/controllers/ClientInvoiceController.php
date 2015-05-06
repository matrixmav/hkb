<?php

class ClientInvoiceController extends Controller
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
				'actions'=>array('index','view','payment','downloadclientinvoice'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','payment'),
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

        
public function actionDownloadClientInvoice(){
    if(!empty($_REQUEST['invId'])){          
            $inVoiceId = $_REQUEST['invId'];
            $invoiceObject = ClientInvoice::model()->findByPk($inVoiceId);
            $con_hid = 'client';
            $folder=Yii::app()->params->imagePath['upload'];// folder for uploaded files
            $idPath = $con_hid."/invoice";
            $inputpath = $folder .$idPath;
            $clientFolder = $folder.$con_hid;
            
            if (!is_dir($clientFolder) && !mkdir($clientFolder,'0777',true)){
                    die("Error creating folder $clientFolder");
            }
            chmod($clientFolder, 0777); 
             
            if (!is_dir($inputpath) && !mkdir($inputpath,'0777',true)){
                    die("Error creating folder $inputpath");
            }
            chmod($inputpath, 0777); 

            $clientInvoiceList = ClientInvline::model()->findAll('client_inv_no = '. $invoiceObject->client_inv_no);
            $baseUrl = Yii::app()->getBaseUrl(true);
            $pdfReservationfile = $this->renderPartial('invoice', 
                    array('baseUrl'=>$baseUrl,
                        'clientInvoiceList' => $clientInvoiceList,
                        'invoiceObject'=>$invoiceObject), true);
            $fileNewName = $invoiceObject->client_inv_no;
            $fileName = $fileNewName.'_'.date('d-m-Y').'.pdf';
            $outputFilePath = $inputpath.'/'.$fileName;
            $html2pdf = Yii::app()->ePdf->HTML2PDF();
            $html2pdf->WriteHTML($pdfReservationfile);
            $html2pdf->Output($outputFilePath, EYiiPdf::OUTPUT_TO_FILE);
            chmod($outputFilePath, 0777);
            BaseClass::downloadFile($outputFilePath);
            exit;
        }
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
		$model=new ClientInvoice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ClientInvoice']))
		{
			$model->attributes=$_POST['ClientInvoice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
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

		if(isset($_POST['ClientInvoice']))
		{
			$model->attributes=$_POST['ClientInvoice'];
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
    public function actionIndex() {
        if (!empty($_GET)) {

            $clientId = $_GET['clientId'];
            $clientObject = Client::model()->findByPk($clientId);

            $month = date('m');
            $pageSize = Yii::app()->params['defaultPageSize'];

            if (!empty($_REQUEST['year']) && !empty($_REQUEST['month'])) {
                $toDay = '01';
                $fromDay = '31';
                $year = $_REQUEST['year'];
                $month = $_REQUEST['month'];
                if ($month < 10) {
                    $month = '0' . $_REQUEST['month'];
                }
                $toDate = $year . '-' . $month . '-' . $toDay;
                $fromDate = $year . '-' . $month . '-' . $fromDay;
            } else {
                $toDate = date('Y-m-01');
                $fromDate = date('Y-m-31');
            }
            $dataProvider = new CActiveDataProvider('ClientInvoice', array(
                'criteria' => array(
                    'condition' => ('inv_date >= "' . $toDate . '" AND inv_date <= "' . $fromDate . '" AND client_id=' . $clientId),
            )));
            $this->render('index', array(
                'dataProvider' => $dataProvider,
                'clientObject' => $clientObject,
                'selectedMonth' => $month
            ));
        }
    }

    public function getTotalAmount($data, $row) {
            $total = 0;
            if(count($data->clientInvlines > 0)){
                foreach($data->clientInvlines as $clientInvLin){
                    $total+=$clientInvLin->tot_amt;
                }
            }
            echo $total.".00";
        }
        public function getTotalWvAmount($data, $row) {
            $vat = 0;
            if(count($data->clientInvlines > 0)){
                foreach($data->clientInvlines as $clientInvLin){
                    $vat+=$clientInvLin->wv_amt;
                }
            }
            echo $vat.".00";
        }
        public function getTotalVatAmount($data, $row) {
            $vatAmt = 0;
            if(count($data->clientInvlines > 0)){
                foreach($data->clientInvlines as $clientInvLin){
                    $vatAmt+=$clientInvLin->vat_amt;
                }
            }
            echo $vatAmt.".00";
        }

        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ClientInvoice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ClientInvoice']))
			$model->attributes=$_GET['ClientInvoice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    /**
     * payment.
     */
    public function actionPayment() {
        
        if ($_REQUEST['clientId']) {
            $clientListObject = Client::model()->findAll();
            $clientId = $_REQUEST['clientId'];
            $clientObject = Client::model()->findByPk($clientId);
            if ($_POST) {
                $clientInvNo =  '411'.$clientObject->country_id*$clientId.date('mdHms');//123456789;//TODO : gen invoice id
                $clientInvoiceObject = new ClientInvoice;
                $clientInvoiceObject->client_id = $_POST['clientId'];
                $clientInvoiceObject->client_inv_no = $clientInvNo;
                $clientInvoiceObject->inv_date = $_POST['inv_date'];
                $clientInvoiceObject->label = $_POST['label'];
                $clientInvoiceObject->added_at = new CDbExpression('NOW()');
                $clientInvoiceObject->updated_at = new CDbExpression('NOW()');
                if(!$clientInvoiceObject->save()){
                    echo "<pre>"; print_r($clientInvoiceObject->getErrors());exit;
                }
                
                $puhtArray = $_POST['puht'];
                $qteArray = $_POST['qte'];
                $tvaArray = $_POST['tva'];
                $linesArray = array();
                foreach($_POST['lines'] as $key => $lines){
                    $insertArray[] = $lines;
                    $insertArray[] = $puhtArray[$key];
                    $insertArray[] = $qteArray[$key];
                    $insertArray[] = $tvaArray[$key];
                    $amount = ($puhtArray[$key] * $qteArray[$key]);
                    $vatAmount = (($puhtArray[$key] * $qteArray[$key]) / ($tvaArray[$key]));
                    $totalAmount = ($vatAmount + $amount);
                    
                    $clientInvline = new ClientInvline;
                    $clientInvline->client_inv_no = $clientInvNo;
                    $clientInvline->title = $lines;
                    $clientInvline->unit_price =  $puhtArray[$key];
                    $clientInvline->qty = $qteArray[$key];
                    $clientInvline->wv_amt = $amount;
                    $clientInvline->vat = $tvaArray[$key];
                    $clientInvline->vat_amt = $vatAmount;
                    $clientInvline->tot_amt = $totalAmount;
                    $clientInvline->added_at = new CDbExpression('NOW()');
                    $clientInvline->updated_at = new CDbExpression('NOW()');
                    if(!$clientInvline->save()){
                        echo "<pre>"; print_r($clientInvline->getErrors());exit;
                    }
                }
                $this->redirect(array('index','clientId'=>$clientId));
            }
            $this->render('payment', array('clientListObject' => $clientListObject, 'clientId' => $clientId));
        }
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ClientInvoice the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ClientInvoice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ClientInvoice $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
