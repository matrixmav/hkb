<?php

class HomeBannerController extends Controller
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
				'actions'=>array('index','view','DropzoneUpload'),
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
		$model=$this->loadModel($id);
		if(isset($_REQUEST['HomeBanner'])){
				$model->attributes = $_POST['HomeBanner'];
				$model->country_id= isset($_POST['selectCountry'])?$_POST['HomeBanner']['country_id']:"";
				$model->state_id= isset($_POST['selectState'])?$_POST['HomeBanner']['state_id']:"";
				$model->city_id= isset($_POST['selectCity'])?$_POST['HomeBanner']['city_id']:"";
				
			if($model->save()){
				$result['status']="SUCCESS";
			}else{
				$result['errorMessage'] = print_r($model->getErrors(), true);
			}
			echo json_encode($result);
			Yii::app()->end();
		}
			
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new HomeBanner;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['HomeBanner']))
		{
			$model->attributes=$_POST['HomeBanner'];
			if($model->save()){
				$result['status']="SUCCESS";
			}else{
				$result['errorMessage'] = print_r($model->getErrors(), true);
			}
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

		if(isset($_REQUEST['HomeBanner'])){
			$model->attributes = $_POST['HomeBanner'];
			$model->country_id= isset($_POST['selectCountry'])?$_POST['HomeBanner']['country_id']:"";
			$model->state_id= isset($_POST['selectState'])?$_POST['HomeBanner']['state_id']:"";
			$model->city_id= isset($_POST['selectCity'])?$_POST['HomeBanner']['city_id']:"";
		
			if($model->save()){
				$result['status']="SUCCESS";
			}else{
				$result['errorMessage'] = print_r($model->getErrors(), true);
			}
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
         * 
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
		$model = new HomeBanner();
		$model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
		$search = ""; $selected = "";
                
		if(isset($_REQUEST['HomeBanner'])){ 
			$dataProvider = CommonHelper::search(isset($_REQUEST['HomeBanner']['search'])?$_REQUEST['HomeBanner']['search']:"", $model, array('t.banner','city.slug','state.slug','country.slug'), array('city','state','country'), isset($_REQUEST['HomeBanner']['selected'])?$_REQUEST['HomeBanner']['selected']:"");
			$search = $_REQUEST['HomeBanner']['search'];
			$selected = $_REQUEST['HomeBanner']['selected'];
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
		$model=new HomeBanner('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HomeBanner']))
			$model->attributes=$_GET['HomeBanner'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return HomeBanner the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=HomeBanner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param HomeBanner $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='home-banner-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionDropzoneUpload($id=""){
		set_time_limit(0);
		ini_set('memory_limit', '2048M');
			
		$folder=Yii::app()->params->imagePath['homeBanner'];// folder for uploaded files
		$sourceImageName = 	basename( $_FILES["file"]["name"]);
		$sourceImageType =$_FILES["file"]["type"];
		$temp = explode("/", $sourceImageType) ;
		$targetName = CommonHelper::generateNewNameOfImage($sourceImageName);
			
		$targetImagePath = $folder.$targetName;
		
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetImagePath)) {
			chmod($targetImagePath, 0777);
			$options = Yii::app()->params['thumbnails']['homepageSlider'];
			$locationFolders = Yii::app()->params->imagePath['homepageSliderPath'];
			CommonHelper::generateCropImage($folder, $targetName, $folder, $targetName, $options);
			foreach($locationFolders as $locationFolder){
				$cpSrc = $_SERVER['DOCUMENT_ROOT'].'/'.$folder."1280_646/".$targetName;
				$cpDes = $_SERVER['DOCUMENT_ROOT'].'/'.$folder."/".$locationFolder."/".$targetName;
				copy($cpSrc, $cpDes);
				chmod($cpDes, 0777);
			}
			$result['result']="success";
			$result['filename']=$targetName;
			echo json_encode($result);			
		}else {
			$result['result']="failure";
			echo json_encode($result);
		}
		Yii::app()->end();
	}
	
	protected function gridImagePopup($data,$row)
	{ 	
		$bigImagefolder=Yii::app()->params->imagePath['homePageSlider'];// folder with uploaded files
		echo "<a data-toggle='modal' href='#zoom_$data->id'>$data->banner</a>".'<div class="modal fade" id="zoom_'.$data->id.'" tabindex="-1" role="basic" aria-hidden="true">
					<div class="modal-dialog" style="width:675px;">
						<div class="modal-content">
							<div class="modal-body" style="width: 675px;overflow: auto;height: 500px;padding: 0;">
								 <img src="'.$bigImagefolder.$data->banner.'">
										 </div>
						</div>
					</div>
				</div>';
	}
	
}
