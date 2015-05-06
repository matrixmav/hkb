<?php

class GroupController extends Controller
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
				'actions'=>array('index','view','chainupdate'),
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
                    $group_id = $model->id;
                    // check the uniqueness if present error will generate.
                    $addSql = ($group_id > 0)? " and id!=".$group_id : "";                    
                    $groupName = $params['name'];
                    $flag=$model::model()->find("name='$groupName' $addSql");
                    if($flag){
                        $result['status']="ERROR_NAME";
                        $result['errorMessage'] = print_r("The group is already available", true);
                    }else {
			if($model->save()){
				
				$result['status']="SUCCESS";
				$result['group']['id']=$group_id;
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
		$model=new Group;
		if(isset($_REQUEST['Group']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Group'];
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

		if(isset($_REQUEST['Group'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Group'];
			$result=$this->saveData($data);
			echo json_encode($result);
			Yii::app()->end();
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Chain Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionChainupdate($id)
	{
		$model=$this->loadModel($_REQUEST['id']);
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                $pageSize = Yii::app()->params['defaultPageSize'];
		if(isset($_REQUEST['Group'])){
                    if(!empty($_REQUEST['clieldId'])){
                        $groupModel = $this->loadModel($_REQUEST['clieldId']);
                    } else {
                        $groupModel = new Group;
                    }
                    $groupModel['parent_id'] = $_REQUEST['id'];
                    $groupModel['name'] = $_REQUEST['Group']['name'];
                    $result = $groupModel->save();
		}
                $chainListObject = "";
                if($_REQUEST['id']){
                    $criteria = new CDbCriteria(array(
                                            'condition'=>'parent_id = '.$_REQUEST['id'],
                            ));
                    $dataProvider=new CActiveDataProvider('Group', 
                            array(
                                'criteria'=>$criteria,
                                'pagination' => array('pageSize' => $pageSize),
                            ));
                }
                $childObject = '';
                if(!empty($_REQUEST['childId'])){
                    $clieldId = $_REQUEST['childId'];
                    $childObject = Group::model()->findByPk($clieldId);
                    
                }
		$this->render('chainupdate',array(
                    'model'=>$model,
                    'chainListObject'=>$chainListObject,
                    'childObject'=>$childObject,
                    'dataProvider'=>$dataProvider
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
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{ 
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		$pageSize = Yii::app()->params['defaultPageSize'];
		$criteria=new CDbCriteria(array(
				'condition'=>'parent_id=0',
		));
		$dataProvider=new CActiveDataProvider('Group', array(
				'criteria'=>$criteria,
				'pagination' => array('pageSize' => $pageSize),
		));
		if(isset($_REQUEST['Group'])){
			$model->attributes=$_REQUEST['Group'];
			$criteria=new CDbCriteria(array(
						'condition'=>'name like "%'.$_REQUEST['Group']['name'].'%"',
				));
	    	$dataProvider=new CActiveDataProvider('Group', array(
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Group('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Group']))
			$model->attributes=$_GET['Group'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Group the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Group::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Group $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
