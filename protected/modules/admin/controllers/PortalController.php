<?php

class PortalController extends Controller
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
		$modelParams = $params['Portal'];
		$model->attributes=$modelParams;
		if($model->status==''){
			$model->status = 1;
		}
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		
		$checkportal = Portal::model()->findByAttributes(array('slug'=>$params['Portal']['slug']));
		
		/* if(empty($checkportal)){ */
			if($model->validate()){
                            
                            //check the validation for uniqueness
                            $portal_id       = $model->id;
                            $addSql    = ($portal_id > 0)? " and id!=".$portal_id : "";
                            $portalName = $params['Portal']['name'];
                            $flag=$model::model()->find("name='$portalName' $addSql");
                            if($flag){
                                $result['errorMessage'] = print_r("The portal is already available", true);
                            }else{
                            
				if($model->save()){
					$portal_id = $model->id;
					$result['status']="SUCCESS";
					$result['portal']['id']=$portal_id;
					if(isset($params['PortalContact'])){
						foreach($params['PortalContact'] as $country_id=>$telephone){
							$criteria = new CDbCriteria;
							$criteria->addCondition("portal_id='$portal_id'");
							$criteria->addCondition("country_id='$country_id'");
							$portalContact = PortalContact::model()->find($criteria);
							if(empty($portalContact)){
								$portalContact = new PortalContact;
								$portalContact->portal_id = $portal_id;
								$portalContact->country_id = $country_id;
								$portalContact->added_at = date("Y-m-d H:i:s",strtotime("now"));
							}
							$portalContact->telephone = $telephone;
							$portalContact->updated_at = date("Y-m-d H:i:s",strtotime("now"));
							if($portalContact->validate()){
								$portalContact->save();
							}else{
								$result['errorMessage'] = print_r($portalContact->getErrors(), true);
							}
						}
					}
				}
                            }
			}else{
				//echo '<pre>';print_r($model->getErrors());exit;
				$result['errorMessage'] = print_r($model->getErrors(), true);
			}
		/* }else{
			$result['errorMessage'] = print_r("The portal is already available", true);
		} */
		
		return $result;
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Portal;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Portal']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST;
				$slug = $data['params']['Portal']['slug'];
			if(!$data['params']['Portal']['slug'])
				$slug = $data['params']['Portal']['name'];
			$data['params']['Portal']['slug']= BaseClass::Slugunique($model,$slug,0);
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

		if(isset($_REQUEST['Portal'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST;
				$slug = $data['params']['Portal']['slug'];
			if(!$data['params']['Portal']['slug'])
				$slug = $data['params']['Portal']['name'];                        
			$data['params']['Portal']['slug']= BaseClass::Slugunique($model,$slug,$id);
			
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
		$model=new Portal('search');
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
		$search = ""; $selected = "";
		if(isset($_REQUEST['Portal'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['Portal']['search'])?$_REQUEST['Portal']['search']:"", $model, array('name','url','updated_at'), array(), isset($_REQUEST['Portal']['selected'])?$_REQUEST['Portal']['selected']:"");
			$search = $_REQUEST['Portal']['search'];
			$selected = $_REQUEST['Portal']['selected'];
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
		$model=new Portal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Portal']))
			$model->attributes=$_GET['Portal'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Portal the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Portal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Portal $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='portal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
