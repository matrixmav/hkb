<?php

class ClientController extends Controller
{
	/**
	 *  using two-column layout. See 'protected/views/layouts/column2.php'.
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
				'actions'=>array('index','view','edit','createexcel','deleteclient',
                                    'readcitylist'),
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
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        public function actionReadCityList(){
            if(!empty($_POST['countryId'])){
                $cityId = 0;
//                if($_POST['clientId']){
//                    $clientObject = Client::model()->findByPk($_POST['clientId']);
//                    $cityId = $clientObject->city_id;
//                }
                $cityListObject = City::model()->findAll('country_id = ' . $_POST['countryId'] ." limit 100");
                $cityListDropdown = $this->renderPartial('cityList', 
                    array('cityListObject' => $cityListObject,'cityId'=>$cityId), true);
                if(count($cityListObject)>0){
                    echo json_encode($cityListDropdown);
                } else {
                    echo json_encode(1);
                }
                Yii::app()->end();
            }
            echo "<pre>"; print_r();exit;
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
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model = new Client;
		$type = NULL;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
  
		if(isset($_REQUEST['Client']))
		{       
                        $clientId = 10000;                        
			$model->attributes=$_REQUEST['Client'];
                        $model->city = $_REQUEST['Client']['city'];
                        if(!empty($_REQUEST['Client']['cityName'])){
                            $cityArray = explode("_",$_REQUEST['Client']['cityName']);
                            if(count($cityArray)>0){
                                $model->city_id = $cityArray['0'];
                                $model->city = $cityArray['1'];
                            }
                        }
                        $model->client_no = '411'.$_REQUEST['Client']['country_id']*$clientId;

                        $model->added_at = new CDbExpression('NOW()');
                        $model->updated_at = new CDbExpression('NOW()');
                        $email = $_REQUEST['Client']['email_add'];
                        $checkduplicationemail = Client::model()->findByAttributes(array('email_add'=>$email));
			if((empty($checkduplicationemail))){
                            $result=$model->save();
                            $model->client_no = '411'.$_REQUEST['Client']['country_id']*$clientId+$model->id;
                            $model->save();
                            echo json_encode($result);  
                            Yii::app()->end();
			}else{
				$result['errorMessage'] = print_r("The clients is already available", true);
			}
			
		}
                

		$this->render('create',array(
			'model'=>$model,
		));
	}

        public function actionEdit(){
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
            
            if(!empty($_POST))
            { 
                $model=$this->loadModel($_POST['Client']['id']);
                $model->attributes=$_POST['Client'];
                $model->city = $_REQUEST['Client']['city'];
                if(!empty($_REQUEST['Client']['cityName'])){
                    $cityArray = explode("_",$_REQUEST['Client']['cityName']);
                    if(count($cityArray)>0){
                        $model->city_id = $cityArray['0'];
                        $model->city = $cityArray['1'];
                    }
                }
                if($model->save()){
                    echo json_encode(1);  
                    Yii::app()->end();
                    exit;
                }
            } else {
                $model=$this->loadModel($_GET['clientId']);
                $this->render('edit',array(
                    'model'=>$model,
                ));
            }
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

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

        public function actionDeleteClient(){
            if(!empty($_GET['clientId'])){
                $this->loadModel($_GET['clientId'])->delete();
                $this->redirect("/admin/client");
            }
	
        }

        /**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Client the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
