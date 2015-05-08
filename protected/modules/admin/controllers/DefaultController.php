<?php

class DefaultController extends Controller
{
	public $title;
	public $m_str_title;
	
        public function init() {
            $timing = date('hms');
            Yii::app()->session['timestamp'] = $timing;
        }

        public function actionIndex()
	{       
            //$this->render('index');
            $this->actionLogin();
	}

	/*
	 *  Admin Login form 
	 */
	public function actionLogin() {

		if(Yii::app()->session['userid']){ 
                    $this->redirect("/admin/dashboard");
		}else{
			$model=new LoginForm('Admin');
                        
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='LoginForm') { echo "cool";exit;
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
					// collect user input data
			if(isset($_POST['LoginForm'])) {
				$model->attributes = $_POST['LoginForm'];
				//$flag=$model->login();
				if($model->login()) {
					echo 1;
					Yii::app()->end();
					//return true;
				}else {
					//echo $flag;
					echo 0;
					Yii::app()->end();
					//return false;
				}
			}
			// display the login form
			$this->m_str_title =yii::t('admin','admin_default_loginpage_title');
			$this->layout = 'login';
			$this->render('index',array('model'=>$model));
		}
	}
        
        public function actionDashboard(){
            echo "dream";exit;  
        }
        
        public function actionAdminLogin(){ 
            if($_POST){
                $model = new User;
		$error = "";
		$username = $_POST['LoginForm']['username'];
		$password =  $_POST['LoginForm']['password'];

		if((!empty($username)) && (!empty($password))) {
                    $getUserObject = User::model()->findByAttributes(array('name'=>$username));
                    //$getcustomerid = Customer::model()->findAll('content LIKE :telephone', array(':telephone'=>"%$telephone%"));
                    if(!empty($getUserObject)){
                        if(($getUserObject->password == md5($password))) {
                            $identity = new UserIdentity($username,$password);
                            if($identity->adminAuthenticate())
                            Yii::app()->user->login($identity);
                            Yii::app()->session['userid'] = $getUserObject->id;
                            echo "1";
                        } else {
                            echo "0";
                        }
                    }
		}
            }
        }

	/*
	 *  Manager Login form
	 */
	public function actionManagerLogin() {
                                          
		if(Yii::app()->user->getstate('user_id')){
			$url = BaseClass::manager_redirect(Yii::app()->user->getstate('user_id'));
                        $this->redirect($url);
		}else{
			$model=new LoginForm('Admin');
	
			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='LoginForm') {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
			// collect user input data
			if(isset($_POST['LoginForm'])) {
				$model->attributes = $_POST['LoginForm'];
				//$flag=$model->login();
				$access = "manager";
				if($model->login($access)) {
                                        echo 1;
					Yii::app()->end();
					//return true;
				}else {
					//echo $flag;
					echo 0;
					Yii::app()->end();
					//return false;
				}
			}
			// display the login form
			$this->m_str_title =yii::t('admin','admin_default_loginpage_title');
			//$this->layout = 'login';
			$this->render('managerlogin',array('model'=>$model));
		}
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
                
            if(Yii::app()->user->getstate('user_id'))
            {
                $aduser = AdminUser::model()->findByPk(Yii::app()->user->getstate('user_id'));
                $aduser->login_status = 0;
                $aduser->last_logged_out = date("Y-m-d H:i:s",strtotime("now"));
                $aduser->save(FALSE);
            }
            
            Yii::app()->user->logout();		
            $this->redirect(Yii::app()->params->logoutUrl);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionManagerLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->params->managerlogoutUrl);
	}
	
	public function actionValidateuser()
	{
		if((isset($_REQUEST['validatetel'])) && (isset($_REQUEST['validateemail'])))
		{
			$customeremail = Customer::model()->findByAttributes(array('email_address'=>$_REQUEST['validateemail']));
			$customertel = Customer::model()->findByAttributes(array('telephone'=>$_REQUEST['validatetel']));
			if((!empty($customeremail)) || (!empty($customertel)))
			{
				echo "present";
			}
		}
	
	}
        
        public function actionForgotpassword()
	{
		$baseurl = Yii::app()->getBaseUrl(true);
		if(empty(Yii::app()->session['userid'])){
			if((isset($_REQUEST['useremail'])) && (isset($_REQUEST['userphone'])))
			{
				$userdetails = AdminUser::model()->findByAttributes(array('email_address'=>$_REQUEST['useremail'], 'telephone'=>$_REQUEST['userphone']));
				if(empty($userdetails))
				{
					echo Yii::t('translation','Email and Telephone Does Not Match');
				}else {
					$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
					srand((double)microtime()*1000000);
					$i = 0;
					$pass = '' ;
						
					while ($i <= 7) {
						$num = rand() % 33;
						$tmp = substr($chars, $num, 1);
						$pass = $pass . $tmp;
						$i++;
					}
	
					//$userdetails = Customer::model()->findByPk($userdetails->id);
					$verificationMail['to'] = $userdetails->email_address;
					$verificationMail['subject'] = Yii::t('front_end','Dayuse_Authentication_Code');
					$verificationMail['body'] = $this->renderPartial('//mail/forgotpassword_authcode',
							array('userdetails' => $userdetails,
									'pass'=>$pass,
									'baseurl'=>$baseurl), true);
					$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
					//var_dump($result);exit;
					$result = CommonHelper::sendMail($verificationMail);
					if($result)
					{
						$userdetails->password = $pass;
						$userdetails->save(false);
						echo Yii::t('front_end','Please_check_you_mail_for_the_validation_code');
					}
				}
			}elseif(isset($_REQUEST['validationcode'])){
				$userdetails = AdminUser::model()->findByAttributes(array('password'=>$_REQUEST['validationcode']));
				if(empty($userdetails))
				{
					echo Yii::t('front_end','Validation_code_does_not_match');
				}else{
					$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
					srand((double)microtime()*1000000);
					$i = 0;
					$pass = '' ;
						
					while ($i <= 7) {
						$num = rand() % 33;
						$tmp = substr($chars, $num, 1);
						$pass = $pass . $tmp;
						$i++;
					}
					
					$verificationMail['to'] = $userdetails->email_address;
					$verificationMail['subject'] = Yii::t('front_end','Dayuse_account_password');
					$verificationMail['body'] = $this->renderPartial('//mail/forgotpassword_newpassword',
							array('userdetails' => $userdetails,
									'pass'=>$pass,
									'baseurl'=>$baseurl), true);
					$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
					$result = CommonHelper::sendMail($verificationMail);
	
					if($result)
					{
						$userdetails->password = md5($pass);
						$userdetails->save(false);
						echo Yii::t('front_end','new_password');
					}
				}
			}else{
				$this->render('forgotpassword');
			}
		}else{
			$this->redirect('/');
		}
	
	}
    public function actionCheckSessionTime() { 
        $timing = date('hms');
        if (($timing - Yii::app()->session['timestamp']) > 300) { //subtract new timestamp from the old one 
            $this->actionLogout();
        } else {
            Yii::app()->session['timestamp'] = $timing; //set new timestamp
        }
    }

}