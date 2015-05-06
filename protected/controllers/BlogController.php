<?php

class BlogController extends Controller
{
   
	/**
	 * Declares class-based actions.
	 */
	public $title, $metadescription;
	public $fbOgTags = array();
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/blog/pages'
			// They can be accessed via: index.php?r=blog/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
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
				'actions'=>array('press','legales','termsprivacy','help','faq',
                                    'hotelextranet','label','allarticles','article','furniture','careers','affiliation'),
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
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex($action = '')
	{ 
           
	}
	
        /**
         * read wordpress - Press
         */
        public function actionPress(){  
        	$action = "";
        	$this->loadMetas($action);
        	$this->pageTitle = "All Press Article | Daystay hotels";
            $this->render('press');
        }
        
        /**
         * read wordpress - Legales
         */
        public function actionLegales(){  
            $this->render('legales');
        }
        
        public function actionCareers(){  
            $this->render('careers');
        }
        
        /**
         * read wordpress - TermsPrivacy
         */
        public function actionTermsPrivacy(){  
            $this->render('terms_privacy');
        }
        
        public function actionAffiliation(){  
            $this->render('affiliation');
        }
        
        /**
         * read wordpress - Help
         */
        public function actionHelp(){  
            $this->render('help');
        }
        
        /**
         * read wordpress - Faq
         */
        public function actionFaq(){  
            $this->render('faq');
        }
        
        /**
         * read wordpress - HotelExtranet
         */
        public function actionHotelExtranet(){  
            $this->render('hotel_extranet');
        }

        /**
	 *This is action label
	 */
	public function actionLabel()
	{
		$this->render('label');
	}
        
        /**
	 *This is action all Article
	 */
	public function actionAllArticles()
	{
		$action = "";
		$this->loadMetas($action);
		$this->pageTitle = "All Article | Daystay hotels";
		$this->render('all_articles');
	}
        
        /**
	 *This is action Article
	 */
	public function actionArticle()
	{ 
            if($_GET){ 
                $articleId = $_GET['articleId'];
                $this->render('articles',array('articleId'=>$articleId));
            }
	}
	
	/**
	 *This is action furniture
	 */
	public function actionFurniture()
	{
		$this->render('furniture');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	protected function loadMetas($action){
	
		$fbOgTags = array();
		$fbOgTags['title'] = "All Articles - Daystay";
		$fbOgTags['description'] = "Articles";
		$fbOgTags['image'] = "";
		$fbOgTags['site_name'] = "Daystay";
		$this->fbOgTags = $fbOgTags;
		//echo '<pre>';print_r($this->fbOgTags);exit;
	}
}