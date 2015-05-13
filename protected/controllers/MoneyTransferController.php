<?php

class MoneyTransferController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='inner';

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
				'actions'=>array('index','view','list','transfer','autocomplete','confirm'),
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
    public function actionList(){
             $dataProvider = new CActiveDataProvider('MoneyTransfer', array(
	    				'pagination' => array('pageSize' => 10),
				));
            $this->render('list',array('dataProvider'=>$dataProvider));
        }   
      public function actionTransfer(){
			 if(isset($_POST['transfer'])){
				 $percentage = ($_POST['paid_amount'])/100;
				 $createdtime = new CDbExpression('NOW()');
				 $userObject = User::model()->findByAttributes(array('name' => $_POST['username']));
				$transactionObjuser = new Transaction;
				$transactionObjuser->user_id = $userObject->id;
				$transactionObjuser->mode =1;
				$transactionObjuser->gateway_id=1;
				$transactionObjuser->actual_amount = $_POST['actual_amount'];
				$transactionObjuser->paid_amount = 0;
				$transactionObjuser->total_rp = $_POST['total_rp'];
				$transactionObjuser->used_rp = ($_POST['actual_amount'] - $percentage);
				$transactionObjuser->status =0;
				$transactionObjuser->created_at = $createdtime;
				$transactionObjuser->updated_at = $createdtime;
				if(!$transactionObjuser->save()){
                    echo "<pre>"; print_r($transactionObjuser->getErrors());exit;
                }
				$transactionObjadmin = new Transaction;
				$transactionObjadmin->user_id = 1;
				$transactionObjadmin->mode =1;
				$transactionObjadmin->gateway_id=1;
				$transactionObjadmin->actual_amount = $_POST['actual_amount'];
				$transactionObjadmin->paid_amount = 0;
				$transactionObjadmin->total_rp = $_POST['total_rp'];
				$transactionObjadmin->used_rp = ($percentage);
				$transactionObjadmin->status =0;
				$transactionObjadmin->created_at = $createdtime;
				$transactionObjadmin->updated_at = $createdtime;
				if(!$transactionObjadmin->save()){
                    echo "<pre>"; print_r($transactionObjadmin->getErrors());exit;
                }
				$moneyTransferObj = new MoneyTransfer;				
				$moneyTransferObj->from_user_id =1;				 
				$moneyTransferObj->to_user_id =$userObject->id;
				$moneyTransferObj->tranaction_id = $transactionObjuser->id;
				$moneyTransferObj->fund_type = 1;
				$moneyTransferObj->comment =$_POST['paid_amount'];
				$moneyTransferObj->status =0;
				$moneyTransferObj->created_at = $createdtime;
				$moneyTransferObj->updated_at = $createdtime;				
				$moneyTransferObjsave = $moneyTransferObj->save();
				//print_r($moneyTransferObjsave); echo $moneyTransferObj->id; exit;
				 if(!$moneyTransferObj->save()){
                    echo "<pre>"; print_r($moneyTransferObj->getErrors());exit;
                }
				$this->render('confirm',array('transactioncode'=>$transactioncode));
			 }
			 
          $adminId = Yii::app()->params['adminId'];
          $walletObject = Wallet::model()->findAllByAttributes(array('user_id' => $adminId));
          $this->render('transfer',array('walletObject'=>$walletObject));
        }
		
		 public function actionAutocomplete(){
			 if($_GET['username']){
				 $userObject = User::model()->findAll(array(
						'condition' => 't.name LIKE :name',
						'params' => array(':name' => '%'.$_GET['username'].'%'),
					));
			$newuserobj = array();$i=0;
			   foreach ( $userObject as  $user) {
				   $newuserobj[$i] = $user->name;
				   $i++;
			   }
         	echo json_encode($newuserobj);
			 }
			 else{
			   $userObject = User::model()->findAll();
			   $newuserobj = array();$i=0;
			   foreach ( $userObject as  $user) {
				   $newuserobj[$i] = $user->name;
				   $i++;
			   }
         	echo json_encode($newuserobj);
			 }
        }
		
		 public function actionConfirm(){
			 if(isset($_POST['confirm'])){			 
				 
				 $moneyTransferObj = MoneyTransfer::model()->findByPk(9);
				 $moneyTransferObj->comment = $_POST['master_code'];
				 $moneyTransferObj->update();
			 }
			 $this->render('confirm');
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MoneyTransfer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MoneyTransfer']))
		{
			$model->attributes=$_POST['MoneyTransfer'];
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

		if(isset($_POST['MoneyTransfer']))
		{
			$model->attributes=$_POST['MoneyTransfer'];
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
		$dataProvider=new CActiveDataProvider('MoneyTransfer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MoneyTransfer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MoneyTransfer']))
			$model->attributes=$_GET['MoneyTransfer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MoneyTransfer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MoneyTransfer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MoneyTransfer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='money-transfer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
