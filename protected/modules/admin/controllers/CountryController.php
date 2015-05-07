<?php

class CountryController extends Controller
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
				'actions'=>array('index','view', 'update'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','status'),
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
		$model=new Country;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Country']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Country'];
			$slug = $data['params']['slug'];
			$name = $data['params']['name'];
			if(!$data['params']['slug'])
			$slug = $data['params']['name'];
			$data['params']['slug']= BaseClass::Slugunique($model,$slug,0);
			$checkduplication = Country::model()->findByAttributes(array('name'=>$name));
			if(empty($checkduplication)){
			$result=$this->saveData($data);
			echo json_encode($result);
			Yii::app()->end();
			}else{
				$result['errorMessage'] = print_r("The country is already available", true);
			}
			
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
				
		if(($_POST)){				
			
			$criteria = new CDbCriteria();
			$criteria->condition = 'id=:id';
			$criteria->params = array(':id'=>$id);
			$model = Country::model()->find($criteria);
			$model->name = $_POST['name'];
			$model->slug = $_POST['slug'];
			$model->country_code= $_POST['country_code'];
			$model->flag_name = $_POST['flag_name'];
			$model->status = $_POST['status'];
			$model->update();
			$this->redirect('index');			
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
		$model=new Country('search');
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
		//echo '<pre>'; print_r($dataProvider);exit();
		$search = ""; $selected = "";
		if(isset($_REQUEST['Country'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['Country']['search'])?$_REQUEST['Country']['search']:"", $model, array('name','slug','iso_code','updated_at'), array(), isset($_REQUEST['Country']['selected'])?$_REQUEST['Country']['selected']:"");
			$search = $_REQUEST['Country']['search'];
			$selected = $_REQUEST['Country']['selected'];
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
		$model=new Country('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Country']))
			$model->attributes=$_GET['Country'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function saveData($data){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$model->attributes=$params;
		//$model->filter = implode("#", $params['filter']);
		if($model->status==''){
			$model->status = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->validate()){
                    $country_id = $model->id;
                    $addSql = ($country_id > 0)? " and id!=".$country_id : "";
                    $name = $params['name'];
                    $flag=$model::model()->find("name='$name' $addSql");
                    if($flag){
                            $result['status']="NAME-ERROR";
                            $result['errorMessage'] = print_r('The country is already available', true);
                    }else{
			if($model->save()){
				$result['status']="SUCCESS";
			}
                    }
		}else{
			//echo '<pre>';print_r($model->getErrors());exit;
			$result['errorMessage'] = print_r($model->getErrors(), true);
		}
		return $result;
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Country the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Country::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Country $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='country-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
