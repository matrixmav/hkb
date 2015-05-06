<?php

class ThemeController extends Controller
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
//			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
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
                    $theme_id = $model->id;
                    // check the uniqueness if present error will generate.
                    $addSql = ($theme_id > 0)? " and id!=".$theme_id : "";                    
                    $themeName = $params['name'];
                    $flag=$model::model()->find("name='$themeName' $addSql");
                    if($flag){
                        $result['status']="ERROR_NAME";
                        $result['errorMessage'] = print_r("The theme is already available", true);
                    }else {
			if($model->save()){
				
				$result['status']="SUCCESS";
				$result['theme']['id']=$theme_id;
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
		$model=new Theme;
		if(isset($_REQUEST['Theme']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Theme'];
			$slug = $data['params']['slug'];
			if(!$data['params']['slug'])
				$slug = $data['params']['name'];
			$data['params']['slug']= BaseClass::Slugunique($model,$slug,0);
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Theme'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Theme'];
			$slug = $data['params']['slug'];
			if(!$data['params']['slug'])
				$slug = $data['params']['name'];
			$data['params']['slug']= BaseClass::Slugunique($model,$slug,$id);
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
		$model=new Theme('search');
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
		$search = ""; $selected = "";
		if(isset($_REQUEST['Theme'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['Theme']['search'])?$_REQUEST['Theme']['search']:"", $model, array('name','updated_at'), array(), isset($_REQUEST['Theme']['selected'])?$_REQUEST['Theme']['selected']:"");
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
		$model=new Theme('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Theme']))
			$model->attributes=$_GET['Theme'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Theme the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Theme::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Theme $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='theme-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
