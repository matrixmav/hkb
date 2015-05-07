<?php

class CustomerController extends Controller
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
				'actions'=>array('index','view','blacklist'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','status'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Customer;
		$type = NULL;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_REQUEST['Customer']))
		{
			//echo '<pre>'; print_r($_REQUEST);exit();
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Customer'];
			$countryCode = $data['params']['country_id'];
			$telephone = $data['params']['telephone'];
			$email = $data['params']['email_address'];
			$checkduplicationtelephone = Customer::model()->findByAttributes(array('telephone'=>$telephone));
			$checkduplicationemail = Customer::model()->findByAttributes(array('email_address'=>$email));
			if((empty($checkduplicationtelephone))&&(empty($checkduplicationemail))){
				//print_r($data['params']);
				
				$result=$this->saveData($data);
			echo json_encode($result);
			Yii::app()->end();
			}else{
				$result['errorMessage'] = print_r("The Customer is already available", true);
			}
			
		}
	if($type=="blacklist")
		$view="_blackform";
	else 
		$view="create";
	
	$this->render($view,array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$type)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Customer'])){ 
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Customer'];
			$telephone = $data['params']['telephone'];
			$email = $data['params']['email_address'];			
			$addSql = ($id > 0)? " and id!=".$id : "";

                        $checkduplicationtelephone = Customer::model()->findByAttributes(array('telephone'=>$telephone),
                                                    array('condition' => 'id != '. $id));
			$checkduplicationemail = Customer::model()->findByAttributes(array('email_address'=>$email),
                                array('condition' => 'id != '. $id));
			if((empty($checkduplicationtelephone))&&(empty($checkduplicationemail))){
				$result=$this->saveData($data);
				echo json_encode($result);
				Yii::app()->end();
			}else{
				echo $result['errorMessage'] = print_r("The Customer is already available", true);
                                exit;
			}			
		}
		if($type=="blacklist")
			$view="_blackform";
		else
			$view="update";
		$this->render($view,array(
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
	public function actionStatus($id)
	{
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
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{ 
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search(1);	
		$pageSize = Yii::app()->params['defaultPageSize'];
		
		if(isset($_REQUEST['Customer'])){
			$model->attributes=$_REQUEST['Customer'];
			$criteria=new CDbCriteria(array(
						'condition'=>'first_name like "%'.$_REQUEST['Customer']['first_name'].'%" OR telephone like "%'.$_REQUEST['Customer']['first_name'].'%" OR email_address like "%'.$_REQUEST['Customer']['first_name'].'%" and status=1',
				));
	    	$dataProvider=new CActiveDataProvider('Customer', array(
						'criteria'=>$criteria,
	    				'pagination' => array('pageSize' => $pageSize),
				));	    	
		}
		$this->render('index',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists all Blacklisted.
	 */
	public function actionBlacklist()
	{
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		$pageSize = Yii::app()->params['defaultPageSize'];
		
		$criteria=new CDbCriteria(array(
				'condition'=>'status = 2',
		));
		$dataProvider = Customer::customerData($criteria);
		if(isset($_REQUEST['Customer'])){
			$model->attributes=$_REQUEST['Customer'];
			$criteria=new CDbCriteria(array(
					'condition'=>'first_name like "%'.$_REQUEST['Customer']['first_name'].'%" OR telephone like "%'.$_REQUEST['Customer']['first_name'].'%" OR email_address like "%'.$_REQUEST['Customer']['first_name'].'%" and status=2',
			));
			$dataProvider=new CActiveDataProvider('Customer', array(
					'criteria'=>$criteria,
					'pagination' => array('pageSize' => $pageSize),
			));
		}
		$this->render('blacklist',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function saveData($data){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$model->attributes=$params;
		//$model->filter = implode("#", $params['filter']);
		if($model->status==''){
			$model->status = 1;
		}
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->origin_id==''){
			$model->added_at = null;
		}
		if($model->is_subscribed==''){
			$model->added_at = 0;
		}
		if($model->auth_code==''){
			$model->added_at = null;
		}
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->updated_at==''){
			$model->updated_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		$model->password = md5($model->password);
		if($model->validate()){
				if($model->save()){
					$result['status']="SUCCESS";
				}
			
		}else{
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Customer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	protected function gridDataColumn($data,$row)
     {
     if($data->telephone{0}==0){
     		$data->telephone = substr($data->telephone, 1);
     	}
     	if($data->country_id!=0)
     		return '+'.$data->country->country_code.$data->telephone;
     	else
     		 return '+'.$data->telephone;     	
    }    
}
