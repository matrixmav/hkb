<?php

class AreaController extends Controller
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
				'actions'=>array('index','view', 'actioncityArea'),
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
			array('allow',  // deny all users
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
		$model=new Area;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if($_POST)
		{
			if(isset($_POST['cityId'])){
				if (isset($_POST['button2'])) {
					AreaCity::model()->deleteAll("area_id='" .$_POST['areaId']. "' and city_id='".$_POST['cityId']."'");
				}else{
					//echo '<pre>'; print_r($_POST);exit();
					$cityArea = new AreaCity;
					$cityArea->area_id = $_POST['areaId'];
					$cityArea->city_id = $_POST['cityId'];
					$cityArea->save();			
					
			}
			$this->redirect(array('area/create','id'=>$_POST['areaId']));
			}
			$checkDuplicateArea  = Area::model()->findByAttributes(array('name'=>$_POST['name']));
			if (!empty($checkDuplicateArea)) {
				$this->redirect(array('area/create','id'=>$checkDuplicateArea->id));
				exit();
			}

			$model = new Area ;
			$model->name = $_POST['name'];
			$model->slug =strtolower(str_replace(' ','-',$_POST['name']));
			$model->added_at = new CDbExpression('NOW()');
			$model->updated_at = new CDbExpression('NOW()');
		 	$checkduplication = Area::model()->findByAttributes(array('name'=>$model->name));
			if(empty($checkduplication)){
			 	$model->save();
			 	$this->redirect(array('area/create','id'=>$model->id));
			 }else{
			 	echo 'duplication';
			 }
			 $cityArea = new cityArea;
			$cityArea->area_id = $_POST['areaId'];
			$cityArea->city_id = $_POST['cityId'];
			$cityArea->save();
			$this->redirect(array('area/create','id'=>$_POST['areaId']));
			 
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
		
		if(isset($_REQUEST['Area'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Area'];
			$citypar['param'] = $_REQUEST['City'];
			$slug = $data['params']['slug'];
			if(!$data['params']['slug'])
				$slug = $data['params']['name'];
			$data['params']['slug']= BaseClass::Slugunique($model,$slug,$id);
				
			$result=$this->saveData($data,$citypar);
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
		
		// $model=new Area('search');
		$model=new AreaCity('search');
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
		$search = ""; $selected = "";
		if(isset($_REQUEST['Area'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['Area']['search'])?$_REQUEST['Area']['search']:"", $model, array('name','url','updated_at'), array(), isset($_REQUEST['Area']['selected'])?$_REQUEST['Area']['selected']:"");
			$search = $_REQUEST['Area']['search'];
			$selected = $_REQUEST['Area']['selected'];
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
		$model=new Area('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Area']))
			$model->attributes=$_GET['Area'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function saveData($data,$citypar){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$citypar = $citypar['param'];
		$model->attributes=$params;
		//$model->filter = implode("#", $params['filter']);
		if($model->status==''){
			$model->status = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->added_at==''){
			$model->added_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->updated_at==''){
			$model->updated_at = date("Y-m-d H:i:s",strtotime("now"));
		}
		if($model->validate()){
			
				if($model->save()){
					$result['status']="SUCCESS";
					if(isset($citypar['update']))
					{
						
						$areamodel = AreaCity::model()->findByAttributes(array('area_id'=>$model->id));
						$areamodel->area_id = $model->id;
						$areamodel->city_id = $citypar['cityid'];
						$areamodel->save(false);
					}else{
						$areamodel = new AreaCity;
						$areamodel->area_id = $model->id;
						$areamodel->city_id = $citypar['cityid'];
						$areamodel->save(false);
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
	 * @return Area the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Area::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Area $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='area-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionCitydrop()
	{
		if(isset($_POST['citylike']))
		{
			$countryid = $_POST['countryid'];
			$citylike = $_POST['citylike'];
			$criteria = new CDbCriteria;
			$criteria->condition = "status=1 AND country_id=2 AND name like '%$citylike%' ";
			$criteria->order = 'name ASC';
			$criteria->limit = 10;
			$cities=City::model()->findAll($criteria);
			if(!empty($cities)){
			echo "<ul style='height:200px; overflow:auto;'>";
			foreach($cities as $city)
			{
				echo "<li><a class='anchorcls' id='".$city->id."'>".$city->name."</a></li>";
			}
			echo "</ul>";
			}else{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No match found";
			}
		}
			
	}
	protected function getcity($data,$row)
	{
		 $getcityid = AreaCity::model()->findByAttributes(array('area_id'=>$data->id));
		$criteria = new CDbCriteria;
		$criteria = new CDbCriteria();
		$criteria->condition = 'id=:id';
		$criteria->params = array(':id'=>$getcityid['city_id']);
		$model = City::model()->find($criteria);
		// return $model['name'];
		return 1;
	}

	protected function getcity1($data,$row)
	{
		$Criteria = new CDbCriteria();
	 	$area=AreaCity::model()->with('city')->findByPk($data->id);	 	
		return $area->city['name'];
	}

	protected function getarea($data,$row)
	{
		
	 	$Criteria = new CDbCriteria();
	 	$area=AreaCity::model()->with('area')->findByPk($data->id);	 	
		return $area->area['name'];
	}
}
