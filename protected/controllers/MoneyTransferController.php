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
				'actions'=>array('index','view','list','transfer','autocomplete','confirm','status','userexists','fund'),
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
		$userid=3;		 
		$adminid=1;			
			 if(isset($_POST['transfer'])){
				 $percentage = ($_POST['paid_amount'])/100;
				 $actualamount = ($_POST['paid_amount'] + $percentage);
				 $createdtime = new CDbExpression('NOW()');
				 $userObject = User::model()->findByAttributes(array('name' => $_POST['username']));
				if(empty($userObject))
				{
					$this->redirect(array('moneytransfer/status', 'status'=>'U'));
				}	
				$transactionObjuser = new Transaction;
				$transactionObjuser->user_id = $userObject->id;
				$transactionObjuser->mode =$_POST['transactiontype'];
				$transactionObjuser->gateway_id=1;
				$transactionObjuser->actual_amount =$actualamount;
				$transactionObjuser->paid_amount = $_POST['paid_amount'];
				$transactionObjuser->total_rp = $_POST['total_rp'];
				$transactionObjuser->used_rp = $actualamount;
				$transactionObjuser->status =0;
				$transactionObjuser->created_at = $createdtime;
				$transactionObjuser->updated_at = $createdtime;
				if(!$transactionObjuser->save()){
                    echo "<pre>"; print_r($transactionObjuser->getErrors());exit;
                }
				$transactionObjuser2 = new Transaction;
				$transactionObjuser2->user_id = $adminid;
				$transactionObjuser2->mode =$_POST['transactiontype'];
				$transactionObjuser2->gateway_id=1;
				$transactionObjuser2->actual_amount =$actualamount;
				$transactionObjuser2->paid_amount = $percentage;
				$transactionObjuser2->total_rp = $_POST['total_rp'];
				$transactionObjuser2->used_rp = $actualamount;
				$transactionObjuser2->status =0;
				$transactionObjuser2->created_at = $createdtime;
				$transactionObjuser2->updated_at = $createdtime;
				if(!$transactionObjuser2->save()){
                    echo "<pre>"; print_r($transactionObjuser2->getErrors());exit;
                }						
				
				$moneyTransfertoObj = new MoneyTransfer;				
				$moneyTransfertoObj->from_user_id =$userid;				 
				$moneyTransfertoObj->to_user_id = $userObject->id;
				$moneyTransfertoObj->transaction_id = $transactionObjuser->id;
				$moneyTransfertoObj->fund_type = $_POST['transactiontype'];
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
				$moneyTransferadmObj->from_user_id =$userid;				 
				$moneyTransferadmObj->to_user_id = $adminid;
				$moneyTransferadmObj->transaction_id = $transactionObjuser2->id;
				$moneyTransferadmObj->fund_type = $_POST['transactiontype'];
				$moneyTransferadmObj->comment =$percentage.'commission to admin';
				$moneyTransferadmObj->status =0;
				$moneyTransferadmObj->created_at = $createdtime;
				$moneyTransferadmObj->updated_at = $createdtime;				
				$moneyTransferadmObjsave = $moneyTransferadmObj->save();
				//print_r($moneyTransferadmObjsave); echo $moneyTransferadmObj->id; exit;
				 if(!$moneyTransferadmObj->save()){
                    echo "<pre>"; print_r($moneyTransferadmObj->getErrors());exit;
                }
				$this->redirect(array('moneytransfer/confirm', 'tu'=>base64_encode($transactionObjuser->id), 'ta'=>base64_encode($transactionObjuser2->id),'a'=>base64_encode($actualamount)));
				
			 }
			 else{			 
          //$adminId = Yii::app()->params['adminId'];
          $walletObject = Wallet::model()->findAllByAttributes(array('user_id' => $userid));
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
			 $createdtime = new CDbExpression('NOW()');
			// echo "<pre>"; print_r($_REQUEST);exit;
			 if(isset($_POST['confirm'])){
				 $userObject = User::model()->findByAttributes(array('id' =>1));
				 if($userObject->master_pin == md5($_POST['master_code'])){
				$transactionObj = Transaction::model()->findByAttributes(array('id' => $_POST['tu']));
			
				 $moneyobj = MoneyTransfer::model()->findByAttributes(array('transaction_id' => $_POST['tu']));
				// echo '<pre>';print_r($moneyTransferadmObj);exit;
									
						/* for admin wallet add */
					$walletadmObj = Wallet::model()->findByAttributes(array('user_id' => $moneyobj->to_user_id,'type' => $transactionObj->mode));
					if(empty($walletadmObj))						
					{
					$awalletSenderObj = new Wallet;
					$awalletSenderObj->type = $transactionObj->mode;
					$awalletSenderObj->user_id = $moneyobj->to_user_id;
					$awalletSenderObj->fund =($transactionObj->actual_amount);
					$awalletSenderObj->status = 1;
					$awalletSenderObj->created_at = $createdtime;
					$awalletSenderObj->updated_at = $createdtime;	
						if(!$awalletSenderObj->save()){
						echo "<pre>"; print_r($awalletSenderObj->getErrors());exit;
						}	
					}
					else{					
					$walletadmObj->fund =($walletadmObj->fund) +($transactionObj->actual_amount);
					$walletadmObj->user_id = $moneyobj->to_user_id;
					$walletadmObj->status = 1;
                    $walletadmObj->save();
					}
					$moneyobj->status = 1;                                        
					$moneyobj->update();
					
				$transaction2Obj = Transaction::model()->findByAttributes(array('id' => $_POST['ta']));
			
				 $money2obj = MoneyTransfer::model()->findByAttributes(array('transaction_id' => $_POST['ta']));
					$walletSenderObj = Wallet::model()->findByAttributes(array('user_id' => $money2obj->to_user_id,'type' => $transaction2Obj->mode));	
					if(empty($walletSenderObj))						
					{
					$twalletSenderObj = new Wallet;
					$twalletSenderObj->user_id = $money2obj->to_user_id;
					$twalletSenderObj->type = $transaction2Obj->mode;
					$twalletSenderObj->fund =($transaction2Obj->paid_amount);
					$twalletSenderObj->status = 1;
					$twalletSenderObj->created_at = $createdtime;
					$twalletSenderObj->updated_at = $createdtime;	
						if(!$twalletSenderObj->save()){
							echo "<pre>"; print_r($twalletSenderObj->getErrors());exit;
						}
					}
					else{
						/* for to user wallet add*/
					
					$walletSenderObj->fund =($walletSenderObj->fund) + ($transaction2Obj->paid_amount);
					$walletSenderObj->status = 1;                                        
					$walletSenderObj->update();
					}
					
					$money2obj->status = 1;                                        
					$money2obj->update();
					
					/* for from user wallet minus*/
					$walletRecvObj = Wallet::model()->findByAttributes(array('user_id' => $moneyobj->from_user_id,'type' => $transactionObj->mode));
					$walletRecvObj->fund =($walletRecvObj->fund) - ($transactionObj->actual_amount);
                                        $walletRecvObj->update();
                                        //exit();
					$this->redirect(array('moneytransfer/status', 'status'=>'S'));
				 }
				 else{
					 
					 $this->redirect(array('moneytransfer/status', 'status'=>'F'));
					 
				}
			 }
			 $this->render('confirm');
        
		 }
		
		public function actionStatus(){
			
			 $this->render('status');
        }
		public function actionFund(){
			
			if(isset($_POST['addfund'])){
				 $createdtime = new CDbExpression('NOW()');
				 $userObject = User::model()->findByAttributes(array('name' => $_POST['username']));
				if(empty($userObject))
				{
					$this->redirect(array('moneytransfer/status', 'status'=>'U'));
				}	
				$walletSenderObj = Wallet::model()->findByAttributes(array('user_id' => $userObject->id,'type' => $_POST['transactiontype']));	
					if(empty($walletSenderObj))						
					{
					$awalletSenderObj = new Wallet;
					$awalletSenderObj->type = $_POST['transactiontype'];
					$awalletSenderObj->user_id = $userObject->id;
					$awalletSenderObj->fund =$_POST['paid_amount'];
					$awalletSenderObj->status = 1;
					$awalletSenderObj->created_at = $createdtime;
					$awalletSenderObj->updated_at = $createdtime;	
						if(!$awalletSenderObj->save()){
						echo "<pre>"; print_r($awalletSenderObj->getErrors());exit;
						}	
					}
					
					else{
						/* for to user wallet add*/
					
					$walletSenderObj->fund =($walletSenderObj->fund)+($_POST['paid_amount']);
					$walletSenderObj->status = 1;                                        
					$walletSenderObj->update();
					}
					$this->redirect(array('../wallet/list'));
					
			}
			 $this->render('fund');
        }
		public function actionUserExists(){
			 $userObject = User::model()->findByAttributes(array('name' => $_GET['u']));
				if(empty($userObject))
				{
					echo 'notexists';
				}	
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
