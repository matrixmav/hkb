<?php

class DayuseBenefitsController extends Controller
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
				'actions'=>array('index','view','dropzoneupload','deletebenifit'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','dropzoneupload','deletebenifit'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DayuseBenefits;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DayuseBenefits']))
		{
			$model->attributes=$_POST['DayuseBenefits'];
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

		if(isset($_POST['DayuseBenefits']))
		{
			$model->attributes=$_POST['DayuseBenefits'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
        
        public function actionDeleteBenifit($id){
            
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
		$dataProvider=new CActiveDataProvider('DayuseBenefits');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DayuseBenefits('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DayuseBenefits']))
			$model->attributes=$_GET['DayuseBenefits'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DayuseBenefits the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DayuseBenefits::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DayuseBenefits $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='dayuse-benefits-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionDropzoneUpload($type){ echo "<pre>"; print_r($_POST);//exit;
		set_time_limit(0);
		ini_set('memory_limit', '2048M');
		$folder= Yii::app()->params->imagePath['hoteldropzone'];// folder for uploaded files
		$idPath = "dayuseBenefits/";
		if($type=='image'){
			$sourceImageName = 	basename( $_FILES["file"]["name"]);
			$sourceImageType =$_FILES["file"]["type"];
			$temp = explode("/", $sourceImageType) ;
			$targetName = CommonHelper::generateNewNameOfImage($sourceImageName);
			$targetImagePath = $folder .$idPath. $targetName;
			$inputpath = $folder .$idPath; 
			if (!is_dir($inputpath) && !mkdir($inputpath,'0777',true)){
				die("Error creating folder $inputpath");
			}
//			chmod($inputpath, 0777);
			//chmod($targetImagePath, 0777);
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetImagePath)) {
				$options = Yii::app()->params['thumbnails']['dayuseBenifits'];
				CommonHelper::generateCropImage($inputpath, $targetName, $inputpath, $targetName, $options);
                                $dayuseBenefits = new DayuseBenefits();
				$dayuseBenefits->benefit_img = $targetName;
                                $dayuseBenefits->benefit_img_page =  $_POST['page_name'];
                                $dayuseBenefits->created_at = new CDbExpression('NOW()');
                                $dayuseBenefits->updated_at = new CDbExpression('NOW()');
				if($dayuseBenefits->save()){
					$result['filename']=$targetName;//GETTING FILE NAME
					$result['result']="success";
					echo json_encode($result);						
				}else{
					$result['result']="failure";
                                        echo "<pre>";print_r($dayuseBenefits->getErrors());exit;
					echo json_encode($result);
				}
			}else {
				$result['result']="failure";
				echo json_encode($result);
			}
		}else{
			header("HTTP/1.1 415 Unsupported Media Type");
		}
		Yii::app()->end();
	}
}
