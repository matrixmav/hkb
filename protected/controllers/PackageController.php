<?php

class PackageController extends Controller
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
				'actions'=>array('index','view','domainsearch','availabledomain','checkout','domainadd','productcart','couponapply','loaddomain','orderadd'),
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
         * Coupon Code Apply
         * Verify coupon code is valid or not
         */ 
        
        function actionCouponApply()
        {
             $response ='';
            $percentage = 10;
            $couponObject = Coupon::model()->findByAttributes(array('status'=>'1'));
            $packageObject = Package::model()->findByPK(Yii::app()->session['package_id']);
           if($couponObject->coupon_code==$_REQUEST['coupon_code'])
           {
              Yii::app()->session['coupon_code'] =  $_REQUEST['coupon_code'];
              
               $packageamount = $packageObject->amount;
               $discountedAmount = $packageObject->amount * $percentage / 100 + Yii::app()->session['amount'];
               $discountAmountfinal = $packageamount - $discountedAmount;
               $response .=  $discountAmountfinal."_".$discountedAmount;
           }else{
               $response .= 0 ;
           }
           echo $response;
           }
           
        /*
         * payement proceed
         * Add order details to database
         */   
           function actionOrderAdd()
        {
               
             $createdDate = date("Y-m-d");
             $transactionObject = new Transaction;
              
             $transactionObject1 = Transaction::model()->findByAttributes(array('user_id'=>Yii::app()->session['userid']));
              
             if(count($transactionObject1) > 0)
             { 
                 
                    $transactionObject1->mode = 'paypal';
                    $transactionObject1->actual_amount = $_REQUEST['totalAmount'];
                    $transactionObject1->paid_amount = $_REQUEST['totalAmount'];
                    $transactionObject1->total_rp = 0;
                    $transactionObject1->used_rp = 0;
                    $transactionObject1->status = 0;
                    $transactionObject1->gateway_id = 1;
                    $transactionObject1->updated_at = new CDbExpression('NOW()');
                    $transactionObject1->update(); 
             }else{
                    $transactionObject->user_id = Yii::app()->session['userid'];
                    $transactionObject->mode = 'paypal';
                    $transactionObject->actual_amount = $_REQUEST['totalAmount'];
                    $transactionObject->paid_amount = $_REQUEST['totalAmount'];
                    $transactionObject->total_rp = 0;
                    $transactionObject->used_rp = 0;
                    $transactionObject->status = 0;
                    $transactionObject->gateway_id = 1;
                    $transactionObject->created_at = new CDbExpression('NOW()');
                    $transactionObject->save(false);
                    
             }   
              $transactionID = $transactionObject->id;
             
             if($transactionID !='')
             {
             Yii::app()->session['transaction_id'] = $transactionObject->id;
             }else{
             Yii::app()->session['transaction_id'] = $transactionObject1->id;    
             }
             //$transactionObject->used_rp = 0;
             $orderObject = new Order;
             $orderObject1 = Order::model()->findByAttributes(array('user_id'=>Yii::app()->session['userid']));
             
             if(count($orderObject1) > 0)
             { 
                    $orderObject1->user_id = Yii::app()->session['userid'];
                    $orderObject1->package_id = Yii::app()->session['package_id'];
                    $orderObject1->domain = Yii::app()->session['domain'];
                    $orderObject1->transaction_id = Yii::app()->session['transaction_id'];
                    $orderObject1->status = 1;
                    $orderObject1->start_date = new CDbExpression('NOW()');
                    $orderObject1->end_date = new CDbExpression('NOW()');
                    $orderObject1->updated_at = new CDbExpression('NOW()');
                    $orderObject1->update(); 
             }else{
                    $orderObject->user_id = Yii::app()->session['userid'];
                    $orderObject->package_id = Yii::app()->session['package_id'];
                    $orderObject->domain = Yii::app()->session['domain'];
                    $orderObject->transaction_id = Yii::app()->session['transaction_id'];
                    $orderObject->status = 1;
                    $orderObject->start_date = new CDbExpression('NOW()');
                    $orderObject->end_date = new CDbExpression('NOW()');
                    $orderObject->created_at = new CDbExpression('NOW()');
                    $orderObject->save(false);
             }       
             
             echo 1;
            
          }
            
        
         
        
        public function actionDomainAdd()
        {
          
          Yii::app()->session['domain'] = $_REQUEST['domain'];  
          if($_REQUEST['amount'] >= 10)
          {
              Yii::app()->session['amount'] = $_REQUEST['amount'] - 10;
          }else{
              
             Yii::app()->session['amount'] = ""; 
          }
          echo  Yii::app()->session['domain'].'_'.Yii::app()->session['amount'];         
        
        }
        
         /**
         * Display search domain page 
         */
        
        public function actionDomainSearch()
        {
         //Yii::app()->session['package_id'] = $_REQUEST['package_id'];     
        
        $Package_id = Yii::app()->session['package_id'];
        if($Package_id!='')
        {
        $packageObject = Package::model()->findByPK($Package_id);
        
        $rightbar = '<div id="dca_cart" class="cart-wrapper">
            <div class="cart-header"><span class="ico-cart"></span>My Shopping Cart</div>
            <ul id="domainList" class="cartList cart-list">';
            if($Package_id=='')
            {
            $rightbar .= '<li class="empty">Your cart is empty :(</li>';
            }else{    
            $rightbar .= '<li class="cart-item">
            
            <span class="domaintxt">';
            $rightbar .= $packageObject["name"];
            /*if($add)
            {
            $rightbar .= '</span><br> Domain : ';
            }*/
            //$rightbar .= $_REQUEST['domain'];    
            $rightbar .='<div id="domainTaken">';
            if(Yii::app()->session['domain']!='')
            {
            $rightbar .=  Yii::app()->session['domain'];
            }
            $rightbar .='</div>
            </li>';
            }
            
            $rightbar .='</ul>
             </form>';
            if(Yii::app()->session['amount'] !='')
            {
            $rightbar .='<div class="amountWrapper">
            Total Amount:<br>
            <div class="cart-total">
            <span id="total_curr">
            <span id="total"><span class="WebRupee"></span>$<span id="tottal">';
            $rightbar .= Yii::app()->session['amount'];
            
            $rightbar .='</span></span>&nbsp;
            </span><br>
            <span class="discounted_price">
            <span id="discounted-total" class="hide"><span class="WebRupee">Rs.</span> 0</span>
            </span>
            </div>
            </div>';
           }
            $rightbar .='<div class="cart-btn-wrapper">
            <button id="checkout" class="btn-flat-green btn-orange" onclick="RedirectCart();">Checkout</button>
            </div>
            </div>';
             $domainTakenArray = array('nidhisati.com', 'ram.net', 'sumeet.com', 'suryaasati.com');
             $AllDomainArray = array('com', 'net', 'co.in', 'co.uk', 'org');
             $userEnteredDomain = Yii::app()->session['domain'];
            $UserDomainPart = explode('.', $userEnteredDomain);
                
                
               // $pos = array_search($UserDomainPart[1], $AllDomainArray);
                //unset($AllDomainArray[$pos]);
                
                //$SuggestedDomain = "<div>Oops!Domain you entered not available.Please choose some other.</div><br/>";
                 $SuggestedDomain = "";  
                foreach ($AllDomainArray as $alldomain) {
                    $domainName = "'".$UserDomainPart[0].".". $alldomain."'";
                    $domainNameF = $UserDomainPart[0].".". $alldomain;
                  
                   $SuggestedDomain .= '<div class="secondary-result">
                            <div class="secondaryDomain resultDomain-wrapper">
                                 <div class="domain-wrapper cart2">
                                    <p class="domainName">'.$UserDomainPart[0] . "." . $alldomain .'</p>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <div class="slashprice cart1"><span class="WebRupee">Rs.</span> 819</div>
                                   </span>
                                      <input type="hidden" name="domain" id="domain" value="'.$UserDomainPart[0] . "." . $alldomain .'">
                                       <input type="hidden" name="amount" id="amount" value="5">';
                  if (in_array($domainNameF, $domainTakenArray)){
                    
                                   $SuggestedDomain .= '<span class="select-domain btn-flat-green">N/A</span>';
                   }else{
                    
                     
                  $SuggestedDomain .= '<button class="add-to-cart select-domain btn-flat-green" id="test"  onclick="DomainAdd('.$domainName.');"  type="button">Add</button>';  
                }                  
                 $SuggestedDomain .= '</div></div>'; 


              //$SuggestedDomain .= "<a href='".Yii::app()->baseUrl."checkout?domain_id=1'>" . $UserDomainPart[0] . "." . $alldomain . "</a><br/>";
                }
                
             
             
            
         $this->render('domainsearch',array(
			'rightbar'=>$rightbar,
                        'suggestedDomain'=>$SuggestedDomain,
		));
        }else{
           $this->render('domainsearchError'); 
        }
        }
        
        
        
        
         /**
         * Display search domain page 
         * Search Domain wether it is available or not
         */
        public function actionAvailableDomain() {
            Yii::app()->session['package_id'] = $_REQUEST['package_id'];
            $domainTakenArray = array('nidhisati.com', 'ram.net', 'sumeet.com', 'suryaasati.com');
            $AllDomainArray = array('com', 'net', 'co.in', 'co.uk', 'org');
            $userEnteredDomain = $_REQUEST['domain'];
                $UserDomainPart = explode('.', $userEnteredDomain);
                if (in_array($userEnteredDomain, $domainTakenArray)) {
                $pos = array_search($UserDomainPart[1], $AllDomainArray);
                unset($AllDomainArray[$pos]);
                //$SuggestedDomain = "<div>Oops!Domain you entered not available.Please choose some other.</div><br/>";
                $SuggestedDomain =  '<div class="secondary-result">
                            <div class="secondaryDomain resultDomain-wrapper">
                                <div class="domain-wrapper ">
                                    <div class="domainName">'.$UserDomainPart[0].'.com</div>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <s class="slashprice"><span class="WebRupee">Rs.</span> 819</s>
                                   </span>
                                   <span class="select-domain btn-flat-green">N/A</span>
                              </div>
                        </div>';    
                foreach ($AllDomainArray as $alldomain) {
                    $domainName = "'".$UserDomainPart[0].".". $alldomain."'";
                     
                $SuggestedDomain .= '<div class="secondary-result">
                            <div class="secondaryDomain resultDomain-wrapper">
                                 <div class="domain-wrapper cart2">
                                    <p class="domainName">'.$UserDomainPart[0] . "." . $alldomain .'</p>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <div class="slashprice cart1"><span class="WebRupee">Rs.</span> 819</div>
                                   </span>
                                   <input type="hidden" name="domain" id="domain" value="'.$UserDomainPart[0] . "." . $alldomain .'">
                                       <input type="hidden" name="amount" id="amount" value="5">
                                    <button class="add-to-cart select-domain btn-flat-green" id="test"  onclick="DomainAdd('.$domainName.');"  type="button">Add</button>
                              </div>
                        </div>'; 


              //$SuggestedDomain .= "<a href='".Yii::app()->baseUrl."checkout?domain_id=1'>" . $UserDomainPart[0] . "." . $alldomain . "</a><br/>";
                }
                
            } else {
                $domainNameF = "'".$UserDomainPart[0].".com'";
                  $SuggestedDomain = '<div class="secondary-result cart2">
                            <div class="secondaryDomain resultDomain-wrapper">
                                <div class="domain-wrapper cart2">
                                    <p class="domainName">'.$UserDomainPart[0] .'.com</p>
                                    <div class="website-promo orange">Get a free DIY for 6 months.<br>Use Coupon: WEBSITE199</div>
                                 </div>
                                 <span class="pricing-wrp">
                                   <strong><span class="WebRupee">Rs.</span> 199</strong>/YR<br>
                                    <div class="slashprice cart1"><span class="WebRupee">Rs.</span> 819</div>
                                   </span>
                                   <input type="hidden" name="domain" id="domain1" value="'.$UserDomainPart[0].'.com">
                                   <input type="hidden" name="amount" id="amount" value="15">
                                   <button class="add-to-cart select-domain btn-flat-green" onclick="DomainAdd('.$domainNameF.');"  type="button">Add</button>
                                    
                              </div>
                        </div> ';
                          foreach ($AllDomainArray as $alldomain) {
                    //$SuggestedDomain .= "<a href='".Yii::app()->baseUrl."checkout?domain_id=1'>" . $UserDomainPart[0] . "." . $alldomain . "</a><br/>";
                 }
            }
            echo $SuggestedDomain;
            
        }
        
 
      public function actionCheckOut(){
            Yii::app()->session['domain_id'] = $_GET['domain_id'];
            $packageObject = Package::model()->findByPK(Yii::app()->session['package_id']);
           
            $this->render('checkout',array(
			'packageObject'=>$packageObject,
		));
            
        }
        
         public function actionProductCart()
        {
            $package_id = Yii::app()->session['package_id'];
            $packageObject = Package::model()->findByPK($package_id);
            $this->render('cart',array(
			'packageObject'=>$packageObject,
		));
	  
            
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
		$model=new Package;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Package']))
		{
			$model->attributes=$_POST['Package'];
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

		if(isset($_POST['Package']))
		{
			$model->attributes=$_POST['Package'];
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
		$dataProvider=new CActiveDataProvider('Package');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Package('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Package']))
			$model->attributes=$_GET['Package'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Package the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Package::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Package $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='package-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
         
}
