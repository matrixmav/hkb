<?php

class HotelController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/hotel';
	//public $layout='hotel';
	public $layout = 'main';
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
				'actions'=>array('index','view'),
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
	
	public function actionDetail()
	{
                if(isset($_REQUEST['slug']))
		{
			$slug = $_REQUEST['slug'];
		}else{
			$this->redirect('/');
		}
		$hoteldetails = Hotel::model()->findByAttributes(array('slug'=>$slug));
		if(empty($hoteldetails))
		{
			$this->redirect('/');
		}
		
		
		//Similar Hotels Start
		$cityid = $hoteldetails->city_id;
		$cityNobj = City::model()->findByPk($cityid);
		//get the latitude and longitude of the city
		$lattitude  =  $cityNobj->latitude;
		$longitude =  $cityNobj->longitude;
		
		$criteriahotel = new CDbCriteria();
		// call the storeprocedure get_distance
		$exp = new CDbExpression("get_distance($lattitude,$longitude, latitude, longitude) AS distance");
		$criteriahotel->alias = "h";
		$criteriahotel->select = "h.*, $exp";
		//$criteriahotel->addColumnCondition(array('h.status'=>1,'h.city_id'=>$model->search_id));
		$criteriahotel->addColumnCondition(array('h.status'=>1));
		$criteriahotel = $this->setFiltersCriteria($criteriahotel, $_REQUEST);
		
		// count the distance in mile
		$distanceMiles = Yii::app()->params['search']['distanceMiles'];
		foreach ($distanceMiles as $distanceMile) {
		$criteriahotel->having = "distance <= ".$distanceMile;
		$hotelsCount = Hotel::model()->count($criteriahotel);
		if($hotelsCount >= Yii::app()->params['search']['min_hotel_required']) {
		break;
		}
		}
		$allHotelData = Hotel::model()->findAll($criteriahotel);
		$criteriahotel->limit = 5;
				// set the default page limit as 0
				$criteriahotel->offset = 0;
				// set the oder you want to display the result.
				//$criteriahotel->order = 'id desc';
				$similarhotels = Hotel::model()->findAll($criteriahotel);
		//Similar Hotels End
				
				
		// Get All Rooms on Load Start
		$criteria = new CDbCriteria;
		$criteria->order='room_leastprice DESC';
		$getallrooms = Room::model()->findAllByAttributes(array("hotel_id"=>$hoteldetails->id));
		// Get All Rooms on Load End
		
 		//Get Description Start
		
		//Get Description End
				
		$this->render('detail', 
                        array('hoteldetails'=>$hoteldetails, 
                            'similarhotels'=>$similarhotels, 
                            'getallrooms'=>$getallrooms));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Hotel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hotel']))
		{
			$model->attributes=$_POST['Hotel'];
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

		if(isset($_POST['Hotel']))
		{
			$model->attributes=$_POST['Hotel'];
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
		$dataProvider=new CActiveDataProvider('Hotel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Hotel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Hotel']))
			$model->attributes=$_GET['Hotel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	public function actionRoomavailability()
	{
		$hotelid = $_REQUEST['hotelid'];
		$date = $_REQUEST['date'];
		$arrtime = $_REQUEST['arrtime'];
		if($arrtime == "")
		{
			$arrtime = "";
		}else{
			$arrtime = base64_decode($arrtime);
			$arrtime = $arrtime.":00";
		}
		$newDate = date("Y-m-d", strtotime($date));
		$image_time ="";
		if($arrtime !="")
		{
			$criteriaall = new CDbCriteria();
			$criteriaall->condition= "hotel_id=".$hotelid." AND (CONVERT('".$arrtime."', TIME) BETWEEN available_from AND available_till)";
			$getallrooms = Room::model()->findAll($criteriaall);
		}else {
			$getallrooms = Room::model()->findAllByAttributes(array("hotel_id"=>$hotelid));
		}
		$roomavailability = RoomAvailability::model()->findAllByAttributes(array("availability_date"=>$newDate));
		$i=0;
		//echo '<div id="availableroomblock" class="leftPart">';
	if(empty($getallrooms)){
			echo "No Rooms Available"; 
		}else{
			foreach ($getallrooms as $rooms)
			{
				foreach ($roomavailability as $availabilityroom){
					if(($rooms->id == $availabilityroom->room_id))
					{
						$fromprice = Room::model()->getRoomTariff($rooms->id,$newDate);
						//$roomprice = Room::model()->getRoomTariff($rooms->id);
						$hasroom = "one";
						$criteriaroom = new CDbCriteria();
						$criteriaroom->addColumnCondition(array('room_id'=>$availabilityroom->room_id, 'res_date'=>$newDate));
						$checkroomreservation = Reservation::model()->count($criteriaroom);
						$availability = RoomAvailability::model()->findByAttributes(array('room_id'=>$availabilityroom->room_id, 'availability_date'=>$newDate));
						$reservedrooms = $checkroomreservation;
						$allroomavailable = $availability->nb_rooms;
						$roomcount = $allroomavailable - $reservedrooms;
							$fromtime = BaseClass::breakDateFormate($rooms->available_from);
				              $tilltime = BaseClass::breakDateFormate($rooms->available_till); 
				               $explodefrom = explode(":",$fromtime);
				               $explodetill = explode(":",$tilltime);
						if($rooms->category == "sun"){$image_time = "icon1"; $defaultprice = $rooms->default_price;}elseif($rooms->category == "halfsun"){$image_time = "icon2";$defaultprice = $rooms->default_price;}elseif($rooms->category == "moon"){$image_time = "icon3";$defaultprice = $rooms->default_night_price;}
						if(($rooms->room_status == "open") || ($rooms->room_status == "free_sale")){ $roomclass=""; $roombutton = "BOOK NOW"; $mclass="";}elseif($rooms->room_status == "closed"){$roomclass="notAvailable";$roombutton = "sur demande"; $mclass="fade";}elseif($rooms->room_status == "request"){$roomclass="onRequest";$roombutton = "on request";$mclass="";}
						if($rooms->room_status == "request"){$orf = 1;}else{$orf = 0;}
						if($roomcount == 0)
						{
							$roomclass="notAvailable";
							$roombutton = "ON DEMAND";
							$href="#";
							$mclass = "fade";
						}else {
							$href=Yii::app()->createUrl('mobile/reservation/create',array('roomId'=>$rooms->id,'date'=>$newDate, 'hotelId'=>$rooms->hotel_id, 'arrtime'=>$arrtime,'orf'=>$orf));
						}
						$fromtime = BaseClass::convertDateFormate($rooms->available_from);
		  			  	$tilltime = BaseClass::convertDateFormate($rooms->available_till);
						
						$numberofrooms = RoomAvailability::model()->findByAttributes(array('room_id'=>$availabilityroom->room_id, 'availability_date'=>$newDate));
						$nightprice = $rooms->default_night_price;
						$dayprice = $rooms->default_price;
						if($rooms->default_price != 0){
							if($rooms->category == "sun" || $rooms->category == "halfsun")
							{
								//$nightprice = $rooms->default_price;
								//$dayprice = $rooms->default_discount_price;
								$negative = (($rooms->default_price - $rooms->default_discount_price)/$rooms->default_price)*100;
								$negative = number_format($negative);
								if($negative >=100)
								{
									$negative = 99;
								}
								if($negative < 10)
								{
									$negative = "0".$negative;
								}
							}else {
								$negative = (($rooms->default_night_price - $rooms->default_discount_night_price)/$rooms->default_night_price)*100;
								$negative = number_format($negative);
								if($negative >=100)
								{
									$negative = 99;
								}
								if($negative < 10)
								{
									$negative = "0".$negative;
								}
							}
						}else {
							$negative=0;
						}
						$condition = RoomInfo::model()->findByAttributes(array('room_id'=>$rooms->id));
						$roomoptions = RoomOptions::model()->findAllByAttributes(array('room_id'=>$rooms->id));
						if($rooms->category == "sun"){
                $image_time = "hotelsun.png"; 
               
              }elseif($rooms->category == "halfsun"){
                $image_time = "hotelhalfsun.png";
               
            }elseif($rooms->category == "moon"){ 
                $image_time = "hotelmoon.png";
            }
            if($explodefrom[1] !="00"){ 
            	$time = $explodefrom[1]; 
            }else
            {
            	$time = "";
            }

            if($rooms->category == "sun")
            {
              $fname = "DAY USE";
            }elseif ($rooms->category == "halfsun") {
              $fname = "LATE BREAK";
            }else
            {
              $fname = "NIGHT";
            }

            if($explodetill[1] !="00"){ $time1 = $explodetill[1]; }else{ $time1 = ""; }
						echo '<div class="searchResult '.$mclass.'" >
						      <div class="priceTimeWrap">        
						        <span class="time">
						          <img class="htype sun" src="'.Yii::app()->request->baseUrl.'/images/mobile/'.$image_time.'" />
						          <span>'.$explodefrom[0].'<sup>'.$time.'</sup>'.$explodefrom[2].' - '.$explodetill[0].'<sup>'.$time1.'</sup>'.$explodetill[2].'</span>
						        </span>
						        <div class="price">
						            <span class="amount">$'.$fromprice.'</span>
						            <span>$'.number_format($defaultprice).' per night</span>
						        </div>
						      </div>
						      <div class="clear"></div>


						
					      	<div class="eachResult">
					        	<div class="leftPart">
					           		<p class="discount">
            							<span class="price">
					          			-'.$negative.'<sup>%</sup>'.'
            								</span>
            								</p>
            			 	</div>
					        <div class="rightPart">            
					          <div class="hotelDetails">
					            <p class="title">
					            <span class="name">'.$fname.'</span><span class="service">'.$rooms->name.'<br></span></p>
					          </div>
					          <div class="clear"></div>
					          <a class="button statbook" href="'.$href.'">'.$roombutton.'</a>
					        </div>
					        <div class="clear"></div>
					      </div>';
						if((!empty($condition)) || (!empty($roomoptions))){
					     echo '<section id="accordion" class="moreInfo">
					        <h3>CONDITIONS &amp; OPTIONS</h3>
					        <div class="content">';
					          if(!empty($condition)){
					     	  echo '<p class="heading">CONDITIONS OF THE ROOM</p>
					          <p>Schedules of rooms can not be changed. All rooms are for 1 or 2 people. Cancellation must be registered on our website.</p>';
							  }
							  if(!empty($roomoptions)){
					          echo '<p class="heading">Options with the room</p>
					          <ul>';
					          		foreach ($roomoptions as $options){
					          			$equipment = Equipment::model()->findByPk($options->equipment_id);
					          			$getcurrenctsymbol = Currency::model()->findByPk($equipment->currency_id);
					            echo'<li><span class="text">'.$equipment->name.'</span> <span class="price">'.number_format($options->price).' '.$getcurrenctsymbol->symbol.'</span></li>';
					            }
					          		echo'</ul>';
					          		}
					       echo'</div>
					      </section> ';
						}
					  echo '</div>';
					}
			
				}
			}
			if(!isset($hasroom))
			{
				foreach ($getallrooms as $rooms)
				{
					  $fromtime = BaseClass::convertDateFormate($rooms->available_from);
		  			  $tilltime = BaseClass::convertDateFormate($rooms->available_till);
					$fromprice = Room::model()->getRoomTariff($rooms->id,$newDate);
				if($rooms->default_price != 0){
					if($rooms->category == "sun" || $rooms->category == "halfsun")
					{
						//$nightprice = $rooms->default_price;
						//$dayprice = $rooms->default_discount_price;
						$negative = (($rooms->default_price - $rooms->default_discount_price)/$rooms->default_price)*100;
						$negative = number_format($negative);
						if($negative >=100)
						{
							$negative = 99;
						}
						if($negative < 10)
						{
							$negative = "0".$negative;
						}
					}else {
						$negative = (($rooms->default_night_price - $rooms->default_discount_night_price)/$rooms->default_night_price)*100;
						$negative = number_format($negative);
						if($negative >=100)
						{
							$negative = 99;
						}
						if($negative < 10)
						{
							$negative = "0".$negative;
						}
					}
						}else {
							$negative=0;
						}
					if($rooms->category == "sun"){$image_time = "icon1"; $defaultprice = $rooms->default_price;}elseif($rooms->category == "halfsun"){$image_time = "icon2";$defaultprice = $rooms->default_price;}elseif($rooms->category == "moon"){$image_time = "icon3";$defaultprice = $rooms->default_night_price;}
					echo '<div class="searchResult fade">
					      <div class="eachResult">
					        <div class="leftPart">
					          <p class="discount"><span>-</span> '.$negative.'<sup>%</sup></p>
					          <ul>
					            <li class="'.$image_time.'"></li>
					          </ul>
					        </div>
					        <div class="rightPart">            
					          <div class="hotelDetails">
					            <p class="title"><span class="time">'.$fromtime." - ".$tilltime.'</span><span class="name">'.$rooms->name.'<br></span></p>
					            <p class="price"><span>$'.$fromprice.'</span><del>$'.$defaultprice.'</del>per night</p>
					          </div>
					          <div class="clear"></div>
					          <a class="button statbook" href="#">ON DEMAND</a>
					        </div>
					        <div class="clear"></div>
					      </div>       
					      <section id="accordion" class="moreInfo ui-accordion ui-widget ui-helper-reset" role="tablist">
					        <h3 class="ui-accordion-header ui-state-default ui-accordion-icons ui-corner-all" role="tab" id="ui-id-1" aria-controls="ui-id-2" aria-selected="false" aria-expanded="true" tabindex="0"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span><img src="/images/mobile/info-icon.png" class="infoicon">CONDITIONS &amp; OPTIONS</h3>
					        <div class="content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;" id="ui-id-2" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="true">
					          <p class="heading">CONDITIONS DE LA CHAMBRE</p>
					          <p>Les horaires des chambres ne peuvent pas être modifiés. Toutes les chambres sont pour 1 ou 2 personnes. Une annulation doit obligatoirement être enregistrée sur notre site.</p>
					
					          <p class="heading">Options proposées avec la chambre</p>
					          <ul>
					            <li><span class="text">1 bouteille de Champagne Laurent Perrier</span> <span class="price">65 €</span></li>
					            <li><span class="text">1 bouteille de Champagne Laurent Perrier Rosé</span>  <span class="price">85 €</span></li>
					            <li><span class="text">½ bouteille de Champagne Laurent Perrier</span>  <span class="price">30 €</span></li>
					            <li><span class="text">Coffret "Your Love Box"</span>  <span class="price">30 €</span></li>
					            </ul>
					        </div>
					        <span class="shadowLine ui-accordion-header ui-state-default ui-corner-all ui-accordion-icons" role="tab" id="ui-id-3" aria-selected="false" aria-expanded="false" tabindex="-1"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span></span>
					      </section>  
					    </div>';
					 
				}
			}
		}
		
		 //echo "</div>";
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Hotel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Hotel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Hotel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='hotel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	} 
	public function setFiltersCriteria($criteria, $data) {
		////Array ( [add_search] => 1 [term] => New York City [uniId] => 15 [type] => 2 [chk_dt] => 12/24/2014
		//[chk_time] => 11:00 [chk_dur] => 4h [chk_star] => 4 [chk_amenity] => 5 [chk_pref] => Array ( [0] => 1 [1] => 2 ) )
	
	
		if(isset($data['add_search']))
		{
			$criteria->join.=" JOIN tbl_room rm on rm.hotel_id=h.id";
			$criteria->join.=" JOIN tbl_room_availability rv on rv.room_id=rm.id";
	
			if (isset($data['chk_dt']) && !empty($data['chk_dt'])) {
				$chk_date = date("Y-m-d",strtotime($data['chk_dt'])) ;
				//$criteria->join.=" JOIN tbl_room rm on rm.hotel_id=h.id";
				//$criteria->join.=" JOIN tbl_room_availability rv on rv.room_id=rm.id and rv.availability_date='".$chk_date."'";
				$criteria->addCondition("rv.availability_date='".$chk_date."'");
				//$criteria->select.=",rm.id, rv.id, rm.name as hotelroomname, ";
			}
			//$hrs = '2h';
			//echo (int)$hrs;
			if (isset($data['chk_time']) && !empty($data['chk_time'])){
				$starttime = strtotime($data['chk_time']);
				$st = date('H:i:s',$starttime);
				if(isset($data['chk_dur']) && !empty($data['chk_dur'])){
					$duration = 60*60*$data['chk_dur'];
					$endtime = date('H:i:s',$starttime+$duration);
					$criteria->addCondition("rm.available_from >= '".$st."' and rm.available_till <= '".$endtime."'");
				}else{
					$criteria->addCondition("rm.available_from >= '".$st."'");
				}
			}
			if (isset($data['chk_dur']) && !empty($data['chk_dur']) ) {
				//SELECT HOUR(TIMEDIFF(`available_from`, `available_till`)) from tbl_room where `id` =1
				$hrs = (int)$data['chk_dur'];
				$criteria->addCondition("HOUR(TIMEDIFF(rm.available_from,rm.available_till)) >= ".$hrs);
				 
			}
	
			if (isset($data['chk_star']) && !empty($data['chk_star'])) {
				$criteria->addCondition("h.star_rating >= ".$data['chk_star']);
			}
			if (isset($data['chk_amenity']) && !empty($data['chk_amenity'])) {
				$criteria->join.=" JOIN tbl_room_options rp on rp.room_id=rm.id";
			}
			if (isset($data['chk_pref']) && !empty($data['chk_pref'])) {
				$criteria->join.=" JOIN tbl_hotel_theme ht on ht.hotel_id=h.id";
				$themes = implode(",", $data['chk_pref']);
				$criteria->addCondition("ht.theme_id IN ($themes)");
			}
	
			$criteria->group = 'h.id';
		}
	
		return $criteria;
	}
}
