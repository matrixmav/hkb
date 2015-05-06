<?php

class AdminController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','changepassword'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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

	public function saveData($data){
		$result['status']="ERROR";
		$model = $data['model'];
		$params = $data['params'];
		$modelParams = $params;
		$model->attributes=$modelParams;
		if($model->validate()){
			$id = $model->id;
			// check the uniqueness if present error will generate.
			$addSql = ($id > 0)? " and id!=".$id : "";
			$email = $params['email_address'];
			$flag=$model::model()->find("email_address='$email' $addSql");
			if($flag){
				$result['status']="ERROR_NAME";
				$result['errorMessage'] = print_r("The user is already available", true);
			}else {
				if($model->save()){
					if(isset($modelParams['hotel_id'])){
						HotelAccess::model()->deleteAll('user_id='.$model->id);
						foreach($modelParams['hotel_id'] as $hotelId){
							$hotelAccess = HotelAccess::model()->find('hotel_id=:p1 and user_id=:p2',array(':p1'=>$hotelId,':p2'=>$model->id));
							if(!$hotelAccess)
								$hotelAccess = new HotelAccess;
							$hotelAccess->hotel_id = $hotelId;
							$hotelAccess->user_id = $model->id;
							$hotelAccess->status = 1;
							$hotelAccess->added_by = 1;
							$hotelAccess->save();
						}
					}
					$result['status']="SUCCESS";
					$result['AdminUser']['id']=$model->id;
				}
			}
		}else{
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminUser;
		$model->setScenario('hotelManager');
		
		if(isset($_REQUEST['AdminUser']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['AdminUser'];
			$data['params']['password'] = md5($data['params']['password']);
			$result=$this->saveData($data);
			echo json_encode($result);
			Yii::app()->end();
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
		$model->setScenario('hotelManager');
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if(isset($_REQUEST['AdminUser'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['AdminUser'];
			$result=$this->saveData($data);
			echo json_encode($result);
			Yii::app()->end();
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
		$model = $this->loadModel($id);
			$model->delete();
			HotelAccess::model()->deleteAll('user_id='.$id);
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $model = new AdminUser();
		$userId=Yii::app()->user->getState('user_id');
		$access = Yii::app()->user->getState('access');
		$pageSize = Yii::app()->params['defaultPageSize'];
		
		if($access=="manager"){
                    
                        $url = BaseClass::manager_redirect($userId);
                        $this->redirect($url);
                    
			$criteria=new CDbCriteria(array(
					'condition'=>'type="hotel" and id='.$userId,
			));
			$dataProvider=new CActiveDataProvider('AdminUser', array(
					'criteria'=>$criteria,
					'pagination' => array('pageSize' => $pageSize),
			));
		}else{
			$criteria=new CDbCriteria(array(
					'condition'=>'type="hotel"',
			));
			$dataProvider=new CActiveDataProvider('AdminUser', array(
					'criteria'=>$criteria,
					'pagination' => array('pageSize' => $pageSize),
			));
		}
		$search = ""; $selected = "";
		if(isset($_REQUEST['AdminUser'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['AdminUser']['search'])?$_REQUEST['AdminUser']['search']:"", $model, array('first_name','last_name','telephone','updated_at'), array(), isset($_REQUEST['AdminUser']['selected'])?$_REQUEST['AdminUser']['selected']:"");
			$search = $_REQUEST['Theme']['search'];
			$selected = $_REQUEST['Theme']['selected'];
		}
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model,
				'search'=>$search,
				'selected'=>$selected
		));
	}
        
        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AdminUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminUser']))
			$model->attributes=$_GET['AdminUser'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AdminUser the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AdminUser::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AdminUser $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionChangePassword(){
		
		$pk = Yii::app()->user->getState('user_id');
		$model= AdminUser::model()->findByPk($pk);
		if(isset($_REQUEST['AdminUser'])){
			
			if(md5($_REQUEST['AdminUser']['passwordOrig'])==$model->password){
				$model->password = md5($_REQUEST['AdminUser']['password']);
				$model->setScenario('changepassword');
				if($model->save())
					$result['status']="SUCCESS";
				else
					$result['errorMessage'] = print_r($model->getErrors(), true);
			}else{
				$result['errorMessage'] = "Old password did not match";
			}
			echo json_encode($result);
			Yii::app()->end();
		}
		$this->render('change_password',array(
				'model'=>$model,
		));
	}
}
