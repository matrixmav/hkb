<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='user';

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

				'actions'=>array('index','view','registration','isuserexisted','forgetpassword','login','changepassword','404','success','loginregistration','dashboard'),
 
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
        
        /* User Login Strat Here */
        public function actionLogin(){ 
            $error = "";

            // collect user input data
            if(isset($_POST['name']) && isset($_POST['password'])){

                $model = new User;
                $error = "";
                $username =  $_POST['name'];
                $password =  $_POST['password'];
                $masterkey = $_POST['masterkey'];

                if((!empty($username)) && (!empty($password))  && (!empty($masterkey))) {
                    $getUserObject = User::model()->findByAttributes(array('name'=>$username,'status'=>1));
                    if(!empty($getUserObject)){
                        $flagPassword ='';
                        $flagMaster ='';

                        if($getUserObject->password == md5($password)) { // Check Password
                            $flagPassword = 'password';                                    
                        }
                        if($getUserObject->master_pin == md5($masterkey)){ // Check master key
                            $flagMaster = 'masterkey';
                        }

                        if($flagPassword == 'password' && $flagMaster == 'masterkey' ){
                            $identity = new UserIdentity($username,$password);                                                                               
                            if($identity->userAuthenticate())
                            Yii::app()->user->login($identity);
                            Yii::app()->session['userid'] = $getUserObject->id;
                            echo "1"; 
                            if(Yii::app()->session['package_id']!='') {
                                $this->redirect("/package/domainsearch");  
                            } else {
                                $this->redirect("/order/list");
                            }
                        }else {
                           // echo "0"; 
                            $error = "<h1>Invalid Information</h1>"; 
                        }
                    }else{
                    $error = "<h1>Invalid User Name</h1>"; 
                    }
                }

            }
                $this->render("login",array("msg"=>$error));
 }
        
        /* User Registration Strat Here */
        public function actionRegistration(){
            
            if($_POST){              
                   
               //echo substr($_POST['name'], 0, 4).substr($_POST['y'], 2, 2).$_POST['m'].$_POST['d']  ; die;
                $masterPin = mt_rand(100000,999999);
                $model = new User;
                $model->attributes = $_POST;
                $model->sponsor_id = substr($_POST['name'], 0, 4).substr($_POST['y'], 2, 2).$_POST['m'].$_POST['d'] ;
                $model->password = BaseClass::md5Encryption($_POST['password']);  
                $model->master_pin = md5($masterPin);
                $model->date_of_birth = $_POST['y']."-".$_POST['m']."-".$_POST['d'];
                $model->user_sponsor_id = $_POST['sponsor_id'];
                $userObject = User::model()->findByAttributes(array('sponsor_id' => $_POST['sponsor_id'] ,'position' => $_POST['position']));
                
                if(count($userObject) > 1 ){
                    
                }else{
                  //$model->sponsor_id = $_POST['sponsor_id']; 
                }
                             
                $rand= rand (date('YmdHis'),5); // For the activation link
                $model->activation_key = $rand ;
                               
                
                if(!$model->save(false)){
                    echo "<pre>"; print_r($model->getErrors());exit;
                }
                
                $modelUserProfile = new UserProfile();
                $modelUserProfile->user_id = $model->id ;
                $modelUserProfile->referral_banner_id = 1 ;
                $modelUserProfile->save(false);
                
                /* Geneology */
                $userObjectId = User::model()->findByAttributes(array('sponsor_id' => $_POST['sponsor_id'] ));
                //echo 
                $modelGenealogy = new Genealogy();
                $modelGenealogy->parent = $userObjectId->id; 
                $modelGenealogy->user_id = $model->id ; 
                $modelGenealogy->sponsor_user_id = $userObjectId->id;                 
                $modelGenealogy->position = $_POST['position'];                 
                $modelGenealogy->save(false); 
                
                /*  For Genealogy Data */
                
                /*$modelGenealogy = new Genealogy();
                $modelGenealogy->user_id = $model->id ; 
                $modelGenealogy->sponsor_user_id = $_POST['sponsor_id'] ; 
                $modelGenealogy->position = $_POST['position'] ; 
                $modelGenealogy->save(); */
                
//                $config['to'] = $model->email; 
//                $config['subject'] = 'Registration Confirmation' ;
//                $config['body'] = 'Congratulations! You have been registered successfully on our site '.
//                        '<strong>Your Master Pin:</strong>'.$masterPin.'<br/><br/>'.
//                        '<strong>Please click the link below to activate your account:</strong><br/><br/>'.
//                        Yii::app()->request->baseUrl.'/user/confirmAction?activation_key='.$rand;
//                var_dump($config);
//                CommonHelper::sendMail($config);
                $this->redirect('login');
            }
            $spnId = "";
            if($_GET){
                $spnId = $_GET['spid'];
            }
            $countryObject = Country::model()->findAll();
            $this->render('registration',array('countryObject'=>$countryObject,'spnId'=>$spnId));
        }

        /* User Forget Password Strat Here */
        public function actionForgetPassword(){
            $msg = "";
            if(isset($_POST['email']) && $_POST['email'] !='' ){
                $email = $_POST['email'];
                $getUserObject = User::model()->findByAttributes(array('email'=>$email));                
                if(count($getUserObject) == 1 ){
                    $userObject = new User;                    
                    $userObject = User::model()->findByPk($getUserObject->id);
                    $forgetKey = base64_encode($getUserObject->name."--".$getUserObject->date_of_birth);   
                    $userObject->forget_key = $forgetKey ; 
                    $userObject->forget_status = 1 ; 
                    $userObject->update();
                    $msg = "<p class='success'>Please check your email to activate your account</p>";                    
                    if(!$userObject->update(false)){
                        echo "<pre>"; print_r($model->getErrors());exit;
                    } 
                    
//                    $config['to'] =  $email; 
//                    $config['subject'] = 'Password reset On HKbase' ;
//                    $config['body'] = 'Youre receiving this e-mail because you requested a password reset for your user account .  '.                            
//                            '<strong>Please go to the following page and choose a new password:</strong><br/><br/>'.
//                            Yii::app()->request->baseUrl.'/user/confirmAction?activation_key='.$forgetKey;
//                    var_dump($config);
//                    $test = mail($config['to'],$config['subject'],$config['body']);
//                    echo "<pre>"; print_r($test);exit;
//                    CommonHelper::sendMail($config);
                    
                }else{
                    $msg = "<p class='error'>Please Enter Your Valid Email Address.</p>";
                }                
            }    
            $this->render('forgetpassword',array('msg' => $msg));
        }
        
        /* User Forget Password Submit Form Strat Here */
        public function actionChangePassword(){
            if(isset($_POST['password']) && isset($_POST['confirm_password'])){                                   
                $msg = '';
                $getUserObject = new User;
                $getUserObject = User::model()->findByAttributes(array('forget_key'=> $_POST['userId'] )); 
                if($_POST['password']== $_POST['confirm_password'] ){ //for checking password matching                    
                  
                    $userObject = User::model()->findByPk($getUserObject->id);
                    $userObject->forget_key =  '' ;
                    $userObject->forget_status =  0 ;
                    $userObject->password = md5($_POST['password']);
                    $userObject->update();
                    $msg = "<p class='success'>Your password has been changed successfully</p>";
                    $this->render('success',array('msg' => $msg)); 
                }
            }            
                
            if(isset($_GET['id'])){                                                     
                $decodeId =  $_GET['id'];
                $getUserObject = new User;
                $getUserObject = User::model()->findByAttributes(array('forget_key'=>$decodeId ));                                
                
                if(count($getUserObject) > 1 ){
                   $this->render('changepassword',array('userId' => $_GET['id'])); 
                }else{                   
                    $this->render('404'); 
                }                                       
            }              
            
            
        }
        
        public function actionIsUserExisted(){
            if($_POST){
                $userObject = User::model()->findByAttributes(array('name' => $_POST['username']));
                if(count($userObject) > 0){
                    echo "1"; exit;
                } else {
                    echo "0"; exit;
                }
            }
        }
        
       public function actionloginregistration()
       {
           $spnId = Yii::app()->params['adminSpnId'];
           Yii::app()->session['package_id'] = (!empty($_GET)) ? $_GET['package_id'] : "";
            
            $countryObject = Country::model()->findAll();
//            echo "<pre>";print_r($countryObject);exit;
            $this->render('login-registration',array('countryObject'=>$countryObject,'spnId'=>$spnId));
       }
        
        /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id){
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
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        


        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
