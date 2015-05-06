<?php
class CustomerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perfborm access control for CRUD operations
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
				'actions'=>array('index','view','login','signup','forgotpassword','myaccount','myhotels','myreservations','cancelreservation','validateuser','cancelconfirm'),
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
		$model=new Customer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
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

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
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
		$dataProvider=new CActiveDataProvider('Customer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Customer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Customer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Customer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Customer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionLogin()
	{
		
		$model = new Customer;
		$error = "";
		$telephone = Yii::app()->request->getPost('telephone');
		$password =  Yii::app()->request->getPost('password');
		if( $telephone{0} == 0 ) {
				$telephone = substr($telephone, 1);
			}

		if((!empty($telephone)) && (!empty($password)))
		{
			$getcustomerid = Customer::model()->findByAttributes(array('telephone'=>$telephone));
			//$getcustomerid = Customer::model()->findAll('content LIKE :telephone', array(':telephone'=>"%$telephone%"));
			if(empty($getcustomerid)){
				echo "nomatch";
			}else{
				if(($getcustomerid->password == md5($password)))
				{
					$identity=new UserIdentity($telephone,$password);
					if($identity->customerAuthenticate())
					Yii::app()->user->login($identity);
					Yii::app()->session['userid'] = $getcustomerid->id;
					echo "match";
				}else
				{
					echo "nomatch";
				}
			}
		}
	}
	public function actionSignup()
	{
		$model = new Customer;
		$baseurl = Yii::app()->getBaseUrl(true);
		if(isset($_POST['Customer']))
		{
			//var_dump($_POST['Customer']);
			$model->attributes = $_POST['Customer'];
			$model->country_id = $_POST['Customer']['country_id'];
			$model->origin_id = null;
			$model->password = md5($_POST['Customer']['password']);
			$model->is_subscribed = 1;
			$model->status = 1;
			$model->added_at =date("Y-m-d H:i:s",strtotime("now"));
			$model->updated_at =date("Y-m-d H:i:s",strtotime("now"));
			$customeremail = Customer::model()->findByAttributes(array('email_address'=>$model->email_address));
			if( $model->telephone{0} == 0 ) {
				$model->telephone = substr($model->telephone, 1);
			}
			$customertel = Customer::model()->findByAttributes(array('telephone'=>$model->telephone));						
			//var_dump($customertel);die;
			if((empty($customeremail)) && (empty($customertel)))
			{
                            if($model->save(false))
                            {
                                //Yii::app()->session['userid'] = $model->id;

                                $userdetails = Customer::model()->findByPk($model->id);
                                $baseurl = Yii::app()->getBaseUrl(true);
                                $verificationMail['to'] = $userdetails->email_address;
                                $verificationMail['subject'] = 'DayStay- Account';
                                $verificationMail['body'] = $this->renderPartial('/mail/signup_success',
                                                array('userdetails' => $userdetails,
                                                                'baseurl'=>$baseurl), true);
                                $verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
                                CommonHelper::sendMail($verificationMail);
                                $telephone = $userdetails->telephone;
                                $password = $_POST['Customer']['password'];
                                $identity=new UserIdentity($telephone,$password);
                                if($identity->customerAuthenticate())
                                        Yii::app()->user->login($identity);
                                Yii::app()->session['userid'] = $userdetails->id;
                                $this->redirect('myaccount');
                                $model = new Customer;
                            }
			}
		}
			$this->render('login',array('model'=>$model));
		
		
		
	}
	public function actionForgotpassword()
	{
		$baseurl = Yii::app()->getBaseUrl(true);
		if(empty(Yii::app()->session['userid'])){
		if((isset($_REQUEST['useremail'])) && (isset($_REQUEST['userphone'])))
				{
					$userdetails = Customer::model()->findByAttributes(array('email_address'=>$_REQUEST['useremail'], 'telephone'=>$_REQUEST['userphone']));
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
						
						$userdetails = Customer::model()->findByPk($userdetails->id);
						$verificationMail['to'] = $userdetails->email_address;
						$verificationMail['subject'] = Yii::t('front_end','Dayuse_Authentication_Code');
						$verificationMail['body'] = $this->renderPartial('/mail/forgotpassword_authcode',
								array('userdetails' => $userdetails,
										'pass'=>$pass,
										'baseurl'=>$baseurl), true);
						$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
						$result = CommonHelper::sendMail($verificationMail);
						if($result)
						{
							$userdetails->auth_code = $pass;
							$userdetails->save(false);
							echo Yii::t('front_end','Please_check_you_mail_for_the_validation_code');
						} 
					}
				}elseif(isset($_REQUEST['validationcode'])){
					$userdetails = Customer::model()->findByAttributes(array('auth_code'=>$_REQUEST['validationcode']));
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
						
						//$userdetails = Customer::model()->findByPk(Yii::app()->session['userid']);
						$verificationMail['to'] = $userdetails->email_address;
						$verificationMail['subject'] = Yii::t('front_end','Dayuse_account_password');
						$verificationMail['body'] = $this->renderPartial('/mail/forgotpassword_newpassword',
								array('userdetails' => $userdetails,
										'pass'=>$pass,
										'baseurl'=>$baseurl), true);
						$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
						$result = CommonHelper::sendMail($verificationMail);
						
						if($result)
						{
							$userdetails->password = md5($pass);
							$userdetails->auth_code = null;
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
	public function actionMyaccount()
	{
		$msg = "";
			if(isset(Yii::app()->session['userid']))
			{
				$userid = Yii::app()->session['userid'];
				$userdetails = Customer::model()->findByPk($userid);
				if(isset($_POST['Customer']['id']))
				{
					$userdetails = Customer::model()->findByPk($userid);
					$userdetails->attributes = $_POST['Customer'];
					$userdetails->save();
				}
				
				if(isset($_POST['currentpassword']))
				{
					
					if(!empty($_POST['newpassword']))
					{
						
						if($userdetails->password == md5($_POST['currentpassword']))
						{
							
							$userdetails->password = md5($_POST['newpassword']);
							$userdetails->save(false);
							$msg = Yii::t('translation','Password Changed Successfully');
						}else {
							$msg = Yii::t('translation','Invalid Current Password');;
						}	
					}
				}
			}else {
				$this->render('//site/error404');
				
			}
			
			
		$this->render('myaccount', array('userdetails'=>$userdetails,'msg'=>$msg));
	}
	public function actionMyhotels()
	{
		if(isset(Yii::app()->session['userid']))
		{
		$datetoday = date('Y-m-d');
		$criteria=new CDbCriteria();
		$criteria->condition = "customer_id=".Yii::app()->session['userid'];
		$count=CustomerFav::model()->count($criteria);
		$pages=new MyPagination($count);
		
		// results per page
		$pages->pageSize=4;
		$pages->applyLimit($criteria);
		$models=CustomerFav::model()->findAll($criteria);
		
		$this->render('myhotels',array(
				'models' => $models,
				'pages' => $pages,
				'datetoday'=>$datetoday
		));
		}else {
			$this->render('//site/error404');
		}
	}


	public function actionMyreservations()
	{
		
		if(isset(Yii::app()->session['userid']))
		{
			$todaysdate = date('Y-m-d');
			$criteria=new CDbCriteria;
			$criteria->condition = "res_date < '".$todaysdate."' AND customer_id =".Yii::app()->session['userid']." AND reservation_status =1";
			//$criteria->params = [':date1' => $todaysdate];
	        $previousreservations = Reservation::model()->findAll($criteria);
			$criteria1=new CDbCriteria;
			$criteria1->condition = "res_date >= '".$todaysdate."' AND customer_id =".Yii::app()->session['userid']." AND reservation_status =1";
			//$criteria1->params = [':date1' => $todaysdate];
			$futurereservations = Reservation::model()->findAll($criteria1);
			$this->render('myreservations' , array('previousreservations'=>$previousreservations, 'futurereservations'=>$futurereservations));
		}else{
			$this->render('//site/error404');
		}
	}
	public function actionCancelconfirm()
	{
		$this->render('cancelconfirm');
	}
	public function actionCancelreservation()
	{
		$error = "";
		if((isset($_POST['reservationnumber'])) && (isset($_POST['customeremail'])))
		{
			$resnumber = $_POST['reservationnumber'];
			$email = $_POST['customeremail'];
			
			$customerdets = Customer::model()->findByAttributes(array('email_address'=>$email));
			if(!empty($customerdets)){
			$getreservation = Reservation::model()->findByAttributes(array('customer_id'=>$customerdets->id, 'nb_reservation'=>$resnumber));
			}else {
				$error = "Reservation number and email does not match";
			}
			if(!empty($getreservation))
			{
				$getreservation->reservation_status = 3;
				$getreservation->save(false);
				$userdetails = Customer::model()->findByPk($customerdets->id);
				$reservedroom = Reservation::model()->findByPk($getreservation->id);
				$roomdetails = Room::model()->findByPk($reservedroom->room_id);
				$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
				$baseurl = Yii::app()->getBaseUrl(true);
				$getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$resnumber));
				$equiprice = 0;
				
						foreach ($getreservationoptions as $reservationoption){
							$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
							$equiprice = $equiprice+$reservationoption->equipment_price;
						}
				
					$totalprice = $equiprice+$reservedroom->room_price;
					$resDate = date("d M. Y", strtotime($reservedroom->res_date));
					$arrival = date('h:i A', strtotime($reservedroom->arrival_time));
					$baseurl = Yii::app()->getBaseUrl(true);
					$verificationMail['to'] = $userdetails->email_address;
					$verificationMail['subject'] = 'Dayuse- Account';
					$verificationMail['body'] = $this->renderPartial('/mail/reservation_cancellation',
							array('userdetails' => $userdetails,
									'totalprice'=>$totalprice,
									'reservedroom'=>$reservedroom,
									'roomdetails'=>$roomdetails,
									'hoteldetails'=>$hoteldetails,
									'resDate'=>$resDate,
									'arrival'=>$arrival,
									'baseurl'=>$baseurl), true);
					$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
					$result = CommonHelper::sendMail($verificationMail);
				
				$this->redirect(Yii::app()->createUrl('customer/cancelconfirm'));
			}else {
				$error = "Reservation number and email does not match";
			}
		}
		/* if(isset(Yii::app()->session['userid']))
		{
			$userid = Yii::app()->session['userid'];
		}else{
			$userid = base64_decode($_GET['uid']);
		}
		if(isset($_GET['rid']))
		{
			$resid = base64_decode($_GET['rid']);
		}
		if((isset($resid)) && (isset($userid)))
		{
			$reservationid = $resid;
			$userdetails = Customer::model()->findByPk($userid);
			$reservedroom = Reservation::model()->findByPk($reservationid);
			$roomdetails = Room::model()->findByPk($reservedroom->room_id);
			$hoteldetails = Hotel::model()->findByPk($roomdetails->hotel_id);
			$reservedroom->reservation_status = 3;
			$reservedroom->save(false);
			$baseurl = Yii::app()->getBaseUrl(true);
			$getreservationoptions = ReservationOption::model()->findAllByAttributes(array('reservation_id'=>$reservationid));
			$equiprice = 0;
			if((empty($reservedroom)) || (empty($userdetails)))
			{
				$this->render('//site/error404');
			}else{
				
			if(empty($getreservationoptions)){
				//$this->render('//site/error404');
			}else{
				foreach ($getreservationoptions as $reservationoption){
					$equipment = Equipment::model()->findByPk($reservationoption->equipment_id);
					$equiprice = $equiprice+$reservationoption->equipment_price;
				}
			}
			$totalprice = $equiprice+$reservedroom->room_price;
			$resDate = date("d M. Y", strtotime($reservedroom->res_date));
			$arrival = date('h:i A', strtotime($reservedroom->arrival_time));
			$baseurl = Yii::app()->getBaseUrl(true);
			$verificationMail['to'] = $userdetails->email_address;
			$verificationMail['subject'] = 'Dayuse- Account';
			$verificationMail['body'] = $this->renderPartial('/mail/reservation_cancellation',
					array('userdetails' => $userdetails,
							'totalprice'=>$totalprice,
							'reservedroom'=>$reservedroom,
							'roomdetails'=>$roomdetails,
							'hoteldetails'=>$hoteldetails,
							'resDate'=>$resDate,
							'arrival'=>$arrival,
							'baseurl'=>$baseurl), true);
			$verificationMail['from'] = Yii::app()->params['dayuseInfoEmail'];
			$result = CommonHelper::sendMail($verifica tionMail); */
			
			$this->render('cancelreservation',array('error'=>$error));
		/* }
		}else {
			$this->render('//site/error404');
		} */
		
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
}