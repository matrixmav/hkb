<?php

class ProfileController extends Controller
{
      public $layout='inner';
      
	public function actionIndex()
	{
               
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
				'actions'=>array('index','address','fetchstate','fetchcity','testimonial','updateprofile','documentverification','summery','dashboard'),
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
        
         /*
         * Function to update user address
         * 
         */
        
        public function actionAddress() {
            $model = new UserProfile;
            $error = "";
            $success = "";
            $profileObject = UserProfile::model()->findByAttributes(array('user_id' => Yii::app()->session['userid']));
            $userObject = User::model()->findByPK(array('id' => Yii::app()->session['userid'])); 
            if (isset($_POST['UserProfile'])) {
             if(count($_POST['UserProfile']) > 0)
             {
                if(md5($_POST['UserProfile']['master_pin'])== $userObject->master_pin)
               {
                $profileObject->address = $_POST['UserProfile']['address'];
                $profileObject->street = $_POST['UserProfile']['street'];
                $profileObject->city_id = $_POST['UserProfile']['city_id'];
                $profileObject->state_id = $_POST['UserProfile']['state_id'];
                $profileObject->country_id = $_POST['UserProfile']['country_id'];
                $profileObject->zip_code = $_POST['UserProfile']['zip_code'];

                $profileObject->updated_at = new CDbExpression('NOW()');
                $profileObject->update();
                $success .= "Address Updated Successfully";
               }else{
                $error .= "Incorrect master pin.";  
               }
             }else{
                 $error .= "Please fill required(*) marked fields.";
                 
             }
             }
         
            $countryObject = Country::model()->findAll();
            $cityObject = City::model()->findAll();
            $stateObject = State::model()->findAll();
            $profileObject = UserProfile::model()->findByAttributes(array('user_id' => Yii::app()->session['userid']));
            $this->render('/user/address', array('countryObject' => $countryObject,
                'cityObject' => $cityObject,'stateObject' => $stateObject,'profileObject' => $profileObject,'success' => $success,'error' => $error));
        }
        
         /*
         * Function to update user address
         * 
         */
        
        public function actionTestimonial() {
            $error = "";
            $success = "";
            $userObject = User::model()->findByPK(array('id' => Yii::app()->session['userid']));
            $profileObject = UserProfile::model()->findByAttributes(array('user_id' => Yii::app()->session['userid'])); 
          if (isset($_POST['UserProfile'])) {
             if($_POST['UserProfile']['testimonials']=='')
             {  
               $error .= "Please fill required(*) marked fields.";  
             }else{
            if(md5($_POST['UserProfile']['master_pin'])== $userObject->master_pin)
            { 
                
            $profileObject->testimonials = $_POST['UserProfile']['testimonials'];
            $profileObject->testimonial_status = '0';
            
            if ($profileObject->update()) {
                   /*$config['to'] = $userObject->email; 
                   $config['subject'] = 'New testimonial added.';
                    $config['body'] = 'Dear Admin , <br/> New testimonial added in mglobal site.Please approve.';
                    $test = mail($config['to'],$config['subject'],$config['body']);
                    CommonHelper::sendMail($config);*/
                    $success .= "Testimonial Updated Successfully.";   
              }
            }else{
             $error .= "Incorrect master pin.";     
            }
            }
            }
         
         $this->render('/user/testimonial', array('profileObject' => $profileObject,'success' => $success,'error' => $error));
        }
        
         /*
         * Function to update user address
         * 
         */
        
        public function actionUpdateProfile() {
            $error = "";
            $success = "";
           $userObject = User::model()->findByPK(array('id' => Yii::app()->session['userid'])); 
           $transactionObject = Transaction::model()->findByAttributes(array('user_id' => Yii::app()->session['userid']));
           $edit = "yes";
           if(!empty($transactionObject) && $transactionObject->status=='1') {
               $edit = "no";
           } 
          if (isset($_POST['UserProfile'])) {
             if($_POST['UserProfile']=='')
             {  
               $error .= "Please fill required(*) marked fields.";  
             }else{
                  
                 
             if(md5($_POST['UserProfile']['master_pin'])== $userObject->master_pin)
             {
            $userObject->full_name = $_POST['UserProfile']['full_name'];
            $userObject->email = $_POST['UserProfile']['email'];
            $userObject->phone = $_POST['UserProfile']['phone'];
            $userObject->date_of_birth = $_POST['UserProfile']['date_of_birth'];
            $userObject->skype_id = $_POST['UserProfile']['skype_id'];
            $userObject->facebook_id = $_POST['UserProfile']['facebook_id'];
            $userObject->twitter_id = $_POST['UserProfile']['twitter_id'];
            if ($userObject->update()) {
               $success .= "Profile Updated Successfully.";   
                }
             }else{
                $error .= "Incorrect master pin.";  
             }
            }
         }
         $this->render('/user/updateprofile', array('userObject' => $userObject,'success' => $success,'error' => $error,'edit' => $edit));
        }
        
        
         /*
         * Function to upload document for verification
         * 
         */
        
         public function actionDocumentVerification() {
            $error = "";
            $success = "";
                $userObject = UserProfile::model()->findByAttributes(array('user_id' => Yii::app()->session['userid']));
                $profileObject = User::model()->findByPK(array('id' => Yii::app()->session['userid']));
          if($_POST)
          { 
           $userObject->id_proof = time().$_FILES['id_proof']['name'];
           $userObject->address_proff = time().$_FILES['address_proof']['name']; 
            if($_FILES)
            {
             if(md5($_POST['UserProfile']['master_pin'])== $profileObject->master_pin)
             {   
            if($userObject->update())
            {   
	       $path = Yii::getPathOfAlias('webroot')."/uploads/verification-document/";
                BaseClass::uploadFile($_FILES['id_proof']['tmp_name'],$path,time().$_FILES['id_proof']['name']);
                BaseClass::uploadFile($_FILES['address_proof']['tmp_name'],$path,time().$_FILES['address_proof']['name']);
               $success = "Documents Updated Successfully";
            }
             }else{
               $error .= "Incorrect master pin.";  
             }
            }else{
              $error = "Please fill required(*) marked fields."; 
            }
          }
              
          $this->render('/user/verification', array('success' => $success,'error' => $error,'userObject'=>$userObject));
        }


    /*
         * To fetch state name according to country
         */
        public function actionFetchState()
        {
            
                $stateObject = State::model()->findAll(array('condition'=>'country_id='.$_REQUEST['country_id']));
                 
                $stateHTML = "<option value=''>Select State</option>";
                foreach($stateObject as $state) {
                   $stateHTML .= "<option value='".$state->id."'>".ucwords($state->name)."</option>"; 
                }
                echo $stateHTML;
             
        }
        
         /*
         * To fetch state name according to country
         */
        public function actionFetchCity()
        {
          $cityObject = City::model()->findAll(array('condition'=>'state_id='.$_REQUEST['state_id']));  
          $cityHTML = "<option value=''>Select City</option>";
          foreach($cityObject as $city) {
             $cityHTML .= "<option value='".$city->id."'>".ucwords($city->name)."</option>"; 
          }
          echo $cityHTML;
        }
        
                /*
         * This will load user dashboard
         */
        public  function actionDashboard()
        { 
            $model = "";
            $this->render('../user/dashboard',array(
			'model'=>$model,
		));
        }
         
        

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}