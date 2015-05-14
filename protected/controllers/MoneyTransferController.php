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
				'actions'=>array('index','view','list','transfer','autocomplete','confirm','status'),
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
		 // $redirectUrl = $this->createUrl('confirm',array('transactioncode'=>123,'actualamount'=>111));
			//	$this->redirect($redirectUrl);
		  
			 if(isset($_POST['transfer'])){
				 $percentage = ($_POST['paid_amount'])/100;
				 $actualamount = ($_POST['paid_amount'] + $percentage);
				 $createdtime = new CDbExpression('NOW()');
				 $userObject = User::model()->findByAttributes(array('name' => $_POST['username']));
				$transactionObjuser = new Transaction;
				$transactionObjuser->user_id = $userObject->id;
				$transactionObjuser->mode =1;
				$transactionObjuser->gateway_id=1;
				$transactionObjuser->actual_amount = $_POST['actual_amount'];
				$transactionObjuser->paid_amount = $_POST['paid_amount'];
				$transactionObjuser->total_rp = $_POST['total_rp'];
				$transactionObjuser->used_rp = $actualamount;
				$transactionObjuser->status =0;
				$transactionObjuser->created_at = $createdtime;
				$transactionObjuser->updated_at = $createdtime;
				if(!$transactionObjuser->save()){
                    echo "<pre>"; print_r($transactionObjuser->getErrors());exit;
                }
				
				
				$moneyTransfertoObj = new MoneyTransfer;				
				$moneyTransfertoObj->from_user_id =3;				 
				$moneyTransfertoObj->to_user_id =$userObject->id;
				$moneyTransfertoObj->tranaction_id = $transactionObjuser->id;
				$moneyTransfertoObj->fund_type = 1; //
				$moneyTransfertoObj->comment =$_POST['paid_amount'].' to user';
				$moneyTransfertoObj->status =0;
				$moneyTransfertoObj->created_at = $createdtime;
				$moneyTransfertoObj->updated_at = $createdtime;				
				$moneyTransfertoObjsave = $moneyTransfertoObj->save();
				//print_r($moneyTransfertoObjsave); echo $moneyTransfertoObj->id; exit;
				 if(!$moneyTransfertoObj->save()){
                    echo "<pre>"; print_r($moneyTransfertoObj->getErrors());exit;
                }
				$moneyTransferadmObj = new MoneyTransfer;				
				$moneyTransferadmObj->from_user_id =3;				 
				$moneyTransferadmObj->to_user_id =1;
				$moneyTransferadmObj->tranaction_id = $transactionObjuser->id;
				$moneyTransferadmObj->fund_type = 1;
				$moneyTransferadmObj->comment =$percentage.'commission to user';
				$moneyTransferadmObj->status =0;
				$moneyTransferadmObj->created_at = $createdtime;
				$moneyTransferadmObj->updated_at = $createdtime;				
				$moneyTransferadmObjsave = $moneyTransferadmObj->save();
				//print_r($moneyTransferadmObjsave); echo $moneyTransferadmObj->id; exit;
				 if(!$moneyTransferadmObj->save()){
                    echo "<pre>"; print_r($moneyTransferadmObj->getErrors());exit;
                }
				$this->redirect(array('moneytransfer/confirm', 'transactioncode'=>$transactionObjuser->id,'actualamount'=>$actualamount));
				
			 }
			 else{			 
          //$adminId = Yii::app()->params['adminId'];
          $walletObject = Wallet::model()->findAllByAttributes(array('user_id' => 3));
          $this->render('transfer',array('walletObject'=>$walletObject));
		  
			 }
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
			// echo "<pre>"; print_r($_REQUEST);exit;
			 if(isset($_POST['confirm'])){
				 $userObject = User::model()->findByAttributes(array('id' =>1));
				 if($userObject->master_pin == $_POST['master_code']){
				$transactionObj = Transaction::model()->findByAttributes(array('id' => $_POST['transactioncode']));
				/* echo '<pre>';
				print_r($transactionObj);exit; 
				$walletRecvObj = Wallet::model()->findByAttributes(array('user_id' => $transactionObj->user_id,'type' => 2));
				$walletRecvObj->fund =$walletFromObj->fund + $transactionObj->paid_amount;
				$walletRecvObj->save(); */
				 $moneyTransferadmObj = MoneyTransfer::model()->findAllByAttributes(array('tranaction_id' => $_POST['transactioncode']));
				// echo '<pre>';print_r($moneyTransferadmObj);exit;
				 foreach ( $moneyTransferadmObj as  $moneyobj) {
					
					if($moneyobj->to_user_id == 1){
						/* for admin wallet add */
					$walletadmObj = Wallet::model()->findByAttributes(array('user_id' => $moneyobj->to_user_id,'type' => 2));
					$walletadmObj->fund =$walletadmObj->fund + ($transactionObj->used_rp - $transactionObj->paid_amount);
					$walletadmObj->status = 1;
					$walletadmObj->update();
					}
					else{
						/* for to user wallet add*/
					$walletSenderObj = Wallet::model()->findByAttributes(array('user_id' => $moneyobj->to_user_id,'type' => 2));
					$walletSenderObj->fund =$walletSenderObj->fund + $transactionObj->paid_amount;
					$walletSenderObj->status = 1;
					$walletSenderObj->update();
					}
					$moneyinside = MoneyTransfer::model()->findByAttributes(array('id' => $moneyobj->id));
					$moneyinside->status = 1;
					$moneyinside->update();
					}
					/* for from user wallet minus*/
					$walletRecvObj = Wallet::model()->findByAttributes(array('user_id' => $moneyobj->from_user_id,'type' => 2));
					$walletRecvObj->fund =$walletRecvObj->fund - $transactionObj->used_rp;
					$walletRecvObj->update();
					$this->redirect(array('moneytransfer/status', 'status'=>'Success'));
				 }
				 else{
					 
					 $this->redirect(array('moneytransfer/status', 'status'=>'Failure'));
					 
				}
			 }
			 $this->render('confirm');
        
		 }
		
		public function actionStatus(){
			
			 $this->render('status');
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
