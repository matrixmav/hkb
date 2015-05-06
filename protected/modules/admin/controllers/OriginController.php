<?php

class OriginController extends Controller
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
                    $equipment_id = $model->id;
                    $addSql = ($equipment_id > 0)? " and id!=".$equipment_id : "";
                    $name = $modelParams['name'];                    
                    $flag=$model::model()->find("name='$name' $addSql");
                    if($flag){
                            $result['status']="NAME-ERROR";
                            $result['errorMessage'] = print_r('The origin is already available', true);
                    }else{
			if($model->save()){
				
				$result['status']="SUCCESS";
				$result['equipment']['id']=$equipment_id;
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
		$model=new Origin;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Origin']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Origin'];
			
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

		if(isset($_REQUEST['Origin'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Origin'];
			
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
		$originPortals = OriginPortal::model()->findAll('origin_id='.$id);
		if($model->status == 1){
			$model->status =0;
			foreach ($originPortals as $originPortal){
				$originPortal->status=0;
				$originPortal->save();
			}
			
		}else{
			$model->status = 1;
			foreach ($originPortals as $originPortal){
				$originPortal->status=1;
				$originPortal->save();
			}
		}
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
		$model=new Origin;
		
		$criteria ="";
		if(isset($_REQUEST['Origin'])){
			$model->attributes = $_REQUEST['Origin'];
			$criteria=new CDbCriteria(array(
					'condition'=>'name like "%'.$_REQUEST['Origin']['name'].'%" OR slug like "%'.$_REQUEST['Origin']['name'].'%"',
			));
		}
		$modelOrigin = Origin::model()->findAll($criteria);
		
		$originarr = array();
		foreach($modelOrigin as $o)
		{
			$originarr[$o->id] = $o->attributes;
		}
		
		$modelPortal = Portal::model()->findAll();
		$portalarr = array();
		foreach($modelPortal as $t)
		{
			$portalarr[$t->id] = $t->attributes;
		}
		if(isset($_REQUEST['yt0']) && !(isset($_REQUEST['Origine_Portal']))){
			$result['status']="NO-RECORD";
			$result['errorMessage'] = print_r('All Portals left Blank', true);
			echo json_encode($result);
			Yii::app()->end();
		}
		if(isset($_REQUEST['Origine_Portal'])){
			if(count($modelPortal)!=count($_REQUEST['Origine_Portal'])){
				$result['status'] = "EMPTY";
				echo json_encode($result);
				Yii::app()->end();
			}
			OriginPortal::model()->deleteAll();
			foreach($originarr as $ori){
				foreach($_REQUEST['Origine_Portal'] as $key=>$portal){
					if(in_array($ori['id'], $portal)){
						$originPortal = new OriginPortal;
						$originPortal->origin_id=$ori['id'];
						$originPortal->portal_id=$key;
						if($originPortal->save())
							$result['status']="SUCCESS";
						else 
							$result['errorMessage'] ="ERROR";
						
					}
				}
			}
			echo json_encode($result);
			Yii::app()->end();
		}
		
		$originPortals = OriginPortal::model()->findAll();
		$originPort =array();
		foreach($originPortals as $originPortal){
			$originPort[$originPortal->origin_id][] = $originPortal->portal_id;
		}
				
		$this->render('index',array(
			'origins'=>$originarr,
			'portals'=>$portalarr,
			'model'=>$model,
			'originPort'=>$originPort,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Origin('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Origin']))
			$model->attributes=$_GET['Origin'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Origin the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Origin::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param Origin $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='origin-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
