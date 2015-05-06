<?php

class EquipmentController extends Controller
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
		//	'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view','orderupdate','create','update','admin','delete'),
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


	public function saveData($data,$id=0){
		$result['status']="ERROR";
	
		$model = $data['model'];
		$params = $data['params'];
		$modelParams = $params;
		$model->attributes=$modelParams;
		$model->base_type=0;//Equipment
		if($id == 0) {
			$model->added_at = date("Y-m-d H:i:s");
		}
		$model->updated_at = date("Y-m-d H:i:s");
		if($model->validate()){
			$addSql = ($id > 0)? " and id!=".$id : "";
			$name = $modelParams['name'];
			$type = $modelParams['type'];
			$flag=$model::model()->find("name='$name' $addSql and type='$type' and base_type = 0 and id != $id");
			if($flag)
				$result['status']="NAME-ERROR";
			else{
				if($model->save()){
					$equipment_id = $model->id;
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
		$model=new Equipment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Equipment']))
		{
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Equipment'];
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
		$model = $this->loadModel($id);
		if($model->status == 1)
			$model->status =0;
		else
			$model->status = 1;
		$model->save();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_REQUEST['Equipment'])){
			$data['model'] = $model;
			$data['params'] = $_REQUEST['Equipment'];
			$result=$this->saveData($data,$id);
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
	public function actionDelete($id,$type)
	{
		$model = $this->loadModel($id);
		if($model->status == 1)
			$model->status =0;
		else
			$model->status = 1;
		$model->save();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('Equipment/index/type/'.$type));
	}	
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($type="room")
	{
		$model = new Equipment();
		$addRoomSearch = "";$addHotelSearch = "";
		if(isset($_REQUEST['Equipment']['name'])){
			$model->attributes=$_REQUEST['Equipment'];
			$name = $_REQUEST['Equipment']['name'];
			if($type=="room")
				$addRoomSearch = " and name like '%$name%'";
			elseif($type=="hotel")
				$addHotelSearch = " and name like '%$name%'";
		}
		$pageSize = Yii::app()->params['defaultPageSize'];
		$modelRoom=new CActiveDataProvider('Equipment',array(
				'sort'=>array(
						'defaultOrder'=>'show_order ASC',
				),
				'criteria'=>array(
        					'condition'=>"base_type = 0 and hotel_id = 0 and type = 'room' $addRoomSearch"
 				),
				'pagination' => array('pageSize' => $pageSize),
		));
		$modelHotel=new CActiveDataProvider('Equipment',array(
				'sort'=>array(
						'defaultOrder'=>'show_order ASC',
				),
				'criteria'=>array(
						'condition'=>"base_type = 0 and hotel_id = 0 and type = 'hotel' $addHotelSearch"
				),
				'pagination' => array('pageSize' => $pageSize),
		
		));
	
		$dataProvider=new CActiveDataProvider('Equipment',array(
			'pagination' => array('pageSize' => $pageSize),		
		));
		if($type=="room") 
		$this->render('index',array(
			'dataHotel'=>$modelHotel,
			'dataRoom'=>$modelRoom,
			'model'=>$model,
			'type'=>$type
		));
		else 
		$this->render('_hotelindex',array(
				'dataHotel'=>$modelHotel,
				'dataRoom'=>$modelRoom,
				'model'=>$model,
				'type'=>$type
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Equipment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Equipment']))
			$model->attributes=$_GET['Equipment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        /**
         * Update possition
         */
        public function actionOrderUpdate() {
            if($_REQUEST){
            	$searchIds = explode(",",$_REQUEST['searchId']);
            	if($searchIds){
            		Equipment::model()->updateAll(array("searchable_type"=>0),"type=:p1",array(":p1"=>$_REQUEST['type']));
	            	foreach($searchIds as $searchId){
	            		$equipmentSObject = Equipment::model()->findByPk($searchId);
	            		$equipmentSObject->searchable_type = 1;
	            		$equipmentSObject->save();
	            	}
            	}
                $arrayEquipmentPosition = explode(",",$_REQUEST['orderId']);
                $equipmentKey= 0;
                foreach($arrayEquipmentPosition as $equipmentPositionId){
                    $equipmentKey++;
                    $equipmentObject = Equipment::model()->findByPk($equipmentPositionId);
                    $equipmentObject->show_order = $equipmentKey;
                    $equipmentObject->save();
                }
                $result['status']="SUCCESS";
                echo json_encode($result);
            }
        }
        

        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Equipment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Equipment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Equipment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	protected function searchCheckbox($data,$row)
	{ 	
		$checked="";
		if($data->searchable_type=="1")
			$checked = "checked";
		echo "<input $checked value='$data->id' id='$data->id' class='searchable' type='checkbox' name='searchable_type'>";
	}
}
