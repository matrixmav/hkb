<?php

class AccessCategoryController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','list','delete','adminuser','admindelete','activate'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
		$model=new AccessCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AccessCategory']))
		{
			$model->attributes=$_POST['AccessCategory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionAdminuser()
        {
            $connection = Yii::app()->db;
            $result['status']="ERROR";
            $err = 0;
            
            if(!$_POST['adminuser_id'])
            {
                // First check if the same email address exists or not
                $emodel = AdminUser::model()->find("email_address='".$_POST['emailadd']."'");

                if($emodel!=NULL)
                {
                    $err = 1;
                    $result['msg'] ="Email Address already exists.";
                }
                else
                {
                                                
                    $aduser = new AdminUser();
                    $aduser->first_name = $_POST['firstname'];
                    $aduser->last_name = $_POST['lastname'];
                    $aduser->telephone = $_POST['mobno'];
                    $aduser->email_address = $_POST['emailadd'];
                    
                    if($_POST['pass'])
                        $aduser->password = md5($_POST['pass']);
                    else
                        $aduser->password = md5('password');
                    
                    $aduser->type = 'dayuse';
                    $aduser->user_icon = $_POST['iconId'];
                    $aduser->added_at = date("Y-m-d H:i:s",strtotime("now"));
                    $aduser->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                    $aduser->save(FALSE);
                    $adminuser_id = $aduser->id;
                }
            }
            else
            {
                $adminuser_id = $_POST['adminuser_id'];
                
                // First check if the same email address exists or not
                $emodel = AdminUser::model()->find("email_address='".$_POST['emailadd']."' and id!=".$adminuser_id);

                if($emodel!=NULL)
                {
                    $err = 1;
                    $result['msg'] ="Email Address already exists.";
                }
                else 
                {
                    $aduser = AdminUser::model()->findByPk($adminuser_id);
                    $aduser->first_name = $_POST['firstname'];
                    $aduser->last_name = $_POST['lastname'];
                    $aduser->telephone = $_POST['mobno'];
                    $aduser->email_address = $_POST['emailadd'];
                    if($_POST['pass'])
                        $aduser->password = md5($_POST['pass']);
                    $aduser->type = 'dayuse';
                    $aduser->user_icon = $_POST['iconId'];
                    $aduser->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                    $aduser->save(FALSE);
                }
            }
            
            if($err==0)
            {
               // Delete the previous portal and category access
               AduserCataccess::model()->deleteAll("aduser_id=".$adminuser_id);
               AduserPortalaccess::model()->deleteAll("aduser_id=".$adminuser_id);
               
               //Add the portal access
               $paccess = new AduserPortalaccess();
               $paccess->portal_id = $_POST['portId'] ;
               $paccess->aduser_id = $adminuser_id;
               $paccess->save(FALSE);

               
               //Add the category access
               $cataccess = new AduserCataccess();
               $cataccess->category_id = $_POST['catId'];
               $cataccess->aduser_id = $adminuser_id;   
               $cataccess->save(FALSE);
               
               $result['status']="SUCCESS";
            }
            
            echo json_encode($result);
            Yii::app()->end();
            
        }

        /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
            $result['status']="ERROR";
                                    
            if(!$_POST['category_id'])
            {
                $acategory = new AccessCategory();
                $acategory->name = $_POST['category'];
                $acategory->country_id = $_POST['country_id']  ; //default USA
                $acategory->added_at = date("Y-m-d H:i:s",strtotime("now"));
                $acategory->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                $acategory->save();
                $category_id = $acategory->id;
            }
            else 
            {
                $category_id = $_POST['category_id'];
                
                $cat = AccessCategory::model()->findByPk($category_id);
                $cat->name = $_POST['category'];
                $cat->save();
                
                // Delete the previous section access
                SectionAccess::model()->deleteAll("category_id=".$category_id);
            }
            
            $notin = array('country_id','category','sub','category_id');
                       
            foreach ($_POST as $ky=>$secId)
            {
                if(!in_array($ky, $notin))
                {
                    $saccess = new SectionAccess();
                    $saccess->category_id = $category_id;
                    $saccess->section_id = $secId;
                    $saccess->access_mode = 4; // 4 represents all
                    $saccess->added_at = date("Y-m-d H:i:s",strtotime("now"));
                    $saccess->updated_at = date("Y-m-d H:i:s",strtotime("now"));
                    $saccess->save();
                }
            }
            
            $result['status']="SUCCESS";
            echo json_encode($result);
            Yii::app()->end();
	}

        /**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
            $category_id = (isset($_GET['catId'])) ? $_GET['catId'] : 0;
            
            $cat = AccessCategory::model()->findByPk($category_id);
            $cat->delete();
            
            $this->redirect(array('accessCategory/index'));
	}
        
        public function actionAdmindelete()
	{
            $adminid = (isset($_GET['auid'])) ? $_GET['auid'] : 0;
            
            $admin = AdminUser::model()->findByPk($adminid);
            $admin->delete();
            
            $this->redirect(array('accessCategory/list'));
	}   

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $pageSize = (isset($_GET['pageSize'])) ? $_GET['pageSize'] : Yii::app()->params['defaultPageSize'];
                $category_id = (isset($_GET['catId'])) ? $_GET['catId'] : 0;
                
                $secIds = array();
                $category_name ="";
                
                if($category_id!=0)
                {
                    $ecat_model=AccessCategory::model()->findByPk($category_id);
                    $category_name = $ecat_model->name;
                    
                    $emodel = SectionAccess::model()->findAll("category_id=".$category_id);
                    if(count($emodel))
                    {
                        foreach ($emodel as $ky=>$eval)  
                            array_push ($secIds, $eval->section_id);
                    }
                }
                
                $model = new AccessCategory('search');
                $model->unsetAttributes();  // clear any default values
		$dataProvider = $model->search();
                
                $rmodel= AdminSection::model()->findAll(array("condition"=>"parent_section_id=0","order"=>"show_order"));                
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model,
                                'pageSize'=>$pageSize,
                                'rmodel'=>$rmodel,
                                'secIds'=>$secIds,
                                'category_id'=>$category_id,
                                'category_name' => $category_name
                                
		));
	}
        
        

        public function actionList()
        {
            //http://dayuse.dev/admin/accessCategory/list?auid=8
            
            $pageSize = (isset($_GET['pageSize'])) ? $_GET['pageSize'] : Yii::app()->params['defaultPageSize'];
            $adminuser_id = (isset($_GET['auid'])) ? $_GET['auid'] : 0;
            $data=array();
            
            $aduser = NULL;
            $portacc = $catacc = array();

            $aduser = AdminUser::model()->findByPk($adminuser_id);
            $portaccess = AduserPortalaccess::model()->findAll("aduser_id=".$adminuser_id);
            if($portaccess!=NULL)
            {
                foreach ($portaccess as $ky=>$port)
                    array_push ($portacc, $port->portal_id);
            }
            $cataccess = AduserCataccess::model()->findAll("aduser_id=".$adminuser_id);
            if($cataccess!=NULL)
            {
                foreach ($cataccess as $ky=>$cat)
                    array_push ($catacc, $cat->category_id);
            }
            
            $acc_cat = AccessCategory::model()->findAll();
            $portal = Portal::model()->findAll();
            
            $model = new AdminUser();
            $model->unsetAttributes();  // clear any default values
            
            $criteria=new CDbCriteria(array('condition'=>'type="dayuse"'));
            $dataProvider=new CActiveDataProvider('AdminUser', array(
					'criteria'=>$criteria,
					'pagination' => array('pageSize' => $pageSize),
			));
            $this->render('aduser',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model,
                                'pageSize'=>$pageSize,
                                'acc_cat'=>$acc_cat,
                                'portal'=>$portal,
                                'adminuser_id'=>$adminuser_id,
                                'catacc'=>$catacc,
                                'portacc'=>$portacc,
                                'aduser'=>$aduser
            
		));
        }
        
        public function getFullname($data,$row)
        {
            echo $data->first_name.' '.$data->last_name;
        }

        public function getCatname($data,$row)
        {
            $adminId = $data->id;
            
            $cat_model = AduserCataccess::model()->find("aduser_id=".$adminId);
            if($cat_model!=NULL)
            {
                $category_id = $cat_model->category_id;

                $ecat_model=AccessCategory::model()->findByPk($category_id);
                echo $ecat_model->name;
            }
            else 
                echo '';
        }
        
        public function getStatus($data,$row)
        {
            $url = Yii::app()->createUrl('admin/accessCategory/activate', array('aid' => $data->id,'status'=>$data->status));
                    
            if($data->status ==1)
                echo '<a href="'.$url.'">Active</a>';
            else
                echo '<a href="'.$url.'">Inactive</a>';
        }
        
        public function actionActivate()
        {
             $admin_id = (isset($_GET['aid'])) ? $_GET['aid'] : 0;
             $status = (isset($_GET['status'])) ? $_GET['status'] : 0;
             
             if($admin_id!=0)
             {
                $nwstatus = ($status==0)? 1:0;
                $aduser = AdminUser::model()->findByPk($admin_id);
                $aduser->status = $nwstatus;
                $aduser->save(FALSE);
             }
             $this->redirect(array('accessCategory/list'));
        }

        /**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AccessCategory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AccessCategory']))
			$model->attributes=$_GET['AccessCategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AccessCategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AccessCategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AccessCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='access-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
