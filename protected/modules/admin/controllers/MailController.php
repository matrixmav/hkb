<?php

class MailController extends Controller
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
				'actions'=>array('index','view','reply','compose','sent'),
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

        /**
	 * Lists all models.
	 */
	public function actionIndex()
	{  
            $pageSize= 10;
            $dataProvider = new CActiveDataProvider('Mail', array(
                        'criteria'=>array('condition' => 'to_user_id = 1','order'=>'updated_at DESC'),
                        'pagination' => array('pageSize' => $pageSize)));
            
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
	}
        /**
	 * Lists all models.
	 */
	public function actionSent()
	{  
            $pageSize= 10;
            $dataProvider = new CActiveDataProvider('Mail', array(
                        'criteria'=>array('condition' => 'from_user_id = 1','order'=>'updated_at DESC'),
                        'pagination' => array('pageSize' => $pageSize)));
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
	}
        public function actionCompose(){ 
            if($_POST){  
                $emailArray = $_POST['to_email'];
                foreach ($emailArray as $email){
                    $userObject = User::model()->findByAttributes(array('email'=>$email));
                    if(empty($userObject)){
                        $this->render('compose',array('error'=>'User Does Not Exist'));
                    }
//                    $customerName = $userObject->full_name;
//                    $emailId = $email;
//                    $emailBoday['to'] = $emailId;
//                    $emailBoday['subject'] = $_POST['email_subject'];
//
//                    $emailBoday['body'] = $_POST['email_body'];
//                    $emailBoday['from'] = Yii::app()->params['hkbAdminEmail'];
//                    $result = CommonHelper::sendMail($emailBoday);
                    if($result){ 
                        $mailObject = new Mail();
                        $mailObject->to_user_id = $userObject->id;
                        $mailObject->from_user_id = Yii::app()->params['adminId'];
                        $mailObject->subject = $_POST['email_subject'];
                        $mailObject->message = $_POST['email_body'];
                        $mailObject->created_at = new CDbExpression('NOW()');
                        $mailObject->updated_at = new CDbExpression('NOW()');
                        $mailObject->save(false);
                    } else {
                        $this->render('compose',array('error'=>'Sent Failed. Please try Again!!!.'));
                    }
                }
                $this->redirect('admin/mail');
            }
            $this->render('compose',array('error'=>''));
        }
        public function actionReply(){ 
            if($_GET){
                $mailObject = Mail::model()->findByPk($_REQUEST['id']);
                $this->render('compose',array('error'=>'','mailObject'=>$mailObject));
            }
        }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{ 
            if($id){ 
                $mailObject = Mail::model()->findByPk($id);
                $mailObject->status = 1;
                $mailObject->save(false);
		$this->render('view',array(
			'mailObject'=>$mailObject,
		));
            }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Mail;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mail']))
		{
			$model->attributes=$_POST['Mail'];
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

		if(isset($_POST['Mail']))
		{
			$model->attributes=$_POST['Mail'];
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

	

        /**
     * Get the reservation status
     * 
     * @param type $data 
     * @param type $row
     */
    public function convertDate($data, $row) {
        echo date("d M Y g:i A", strtotime($data->updated_at));
    }
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mail']))
			$model->attributes=$_GET['Mail'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
