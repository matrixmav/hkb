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
				'actions'=>array('index','address','fetchstate','fetchcity','testimonial','updateprofile','documentverification'),
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
            if (isset($_POST['UserProfile'])) {
             if(count($_POST['UserProfile']) > 0)
             {
                $profileObject = UserProfile::model()->findByAttributes(array('user_id' => '1'));
                $profileObject->address = $_POST['UserProfile']['address'];
                $profileObject->street = $_POST['UserProfile']['street'];
                $profileObject->city_id = $_POST['UserProfile']['city_id'];
                $profileObject->state_id = $_POST['UserProfile']['state_id'];
                $profileObject->country_id = $_POST['UserProfile']['country_id'];
                $profileObject->zip_code = $_POST['UserProfile']['zip_code'];

                $profileObject->updated_at = new CDbExpression('NOW()');
                $profileObject->update();
                $success .= "Address Updated Successfully";
                }
             else{
                 $error .= "Please fill required(*) marked fields.";
                 
             }
            }
            $countryObject = Country::model()->findAll();
            $cityObject = City::model()->findAll();
            $stateObject = State::model()->findAll();
            $profileObject = UserProfile::model()->findByAttributes(array('user_id' => '1'));
            $this->render('../user/address', array('countryObject' => $countryObject,
                'cityObject' => $cityObject,'stateObject' => $stateObject,'profileObject' => $profileObject,'success' => $success,'error' => $error));
        }
        
         /*
         * Function to update user address
         * 
         */
        
        public function actionTestimonial() {
            $error = "";
            $success = "";
           $profileObject = UserProfile::model()->findByAttributes(array('user_id' => '1')); 
          if (isset($_POST['UserProfile'])) {
             if($_POST['UserProfile']['testimonials']=='')
             {  
               $error .= "Please fill required(*) marked fields.";  
             }else{
           $profileObject->testimonials = $_POST['UserProfile']['testimonials'];
            if ($profileObject->update()) {
               $success .= "Testimonial Updated Successfully.";   
                }
            }
         }
         $this->render('../user/testimonial', array('profileObject' => $profileObject,'success' => $success,'error' => $error));
        }
        
         /*
         * Function to update user address
         * 
         */
        
        public function actionUpdateProfile() {
            $error = "";
            $success = "";
           $profileObject = UserProfile::model()->findByAttributes(array('user_id' => '1')); 
          if (isset($_POST['UserProfile'])) {
             if($_POST['UserProfile']['testimonials']=='')
             {  
               $error .= "Please fill required(*) marked fields.";  
             }else{
           $profileObject->testimonials = $_POST['UserProfile']['testimonials'];
            if ($profileObject->update()) {
               $success .= "Testimonial Updated Successfully.";   
                }
            }
         }
         $this->render('../user/updateprofile', array('profileObject' => $profileObject,'success' => $success,'error' => $error));
        }
        
        
         /*
         * Function to upload document for verification
         * 
         */
        
        public function actionDocumentVerification() {
            $error = "";
            $success = "";
          $model = UserProfile::model()->findByAttributes(array('user_id' => '1')); 
          if($_POST)
          {
            var_dump($_FILES); 
          $model->id_proof = CUploadedFile::getInstance($model,'id_proof');
          //$model->address_proff = CUploadedFile::getInstance($model,'address_proff');
          $model->id_proof = time().$_FILES['id_proof']['name'];
          //$model->address_proof = time().$_FILES['address_proof']['name'];
          if($model->update())
            {
              $path = Yii::getPathOfAlias('webroot')."/images/uploads/";
              $model->id_proof->saveAs($path . $model->id_proof);
              
              //$model->id_proof->saveAs(Yii::app()->basePath.'/../images/'.$model->id_proof);
              //$model->address_proof->saveAs(Yii::app()->basePath.'/../images/'.$model->address_proof);
              $this->redirect(array('profile/documentverification'));
            }
          }
           
         $this->render('../user/verification', array('success' => $success,'error' => $error));
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