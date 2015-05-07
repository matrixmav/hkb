<?php

class SearchController extends Controller
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
						'actions'=>array('index','filter','create','citylist','getdistance',
                                                    'getneighbourhood'),
						'users'=>array('@'),
				),				
				array('allow',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	public function actionCreate()
	{
                if(isset($_REQUEST['Search'])){
                    //Aligned with the Frontend SearchController
                    if($_REQUEST['selectedCityId']!='')
                    {
                        $cityId = $_REQUEST['selectedCityId'];
                        $search = $_REQUEST['Search'];
                        
                        $city = City::model()->findByPk($cityId);
                        
                        if($city){
                            
                            $areacrit = $exp = $areaname = "";
                            $addgeo = TRUE;
                            
                            //If area is selected then choose hotels only on the cities added in the area
                            if(isset($search['area'])) 
                            {
                                if($search['area']!=0)
                                {
                                    $array_area = array();
                                    $areacity = AreaCity::model()->findAll("area_id=".$search['area']);
                                    if(!empty($areacity))
                                    {
                                        $areaname = $areacity['0']->area->name;
                                        foreach ($areacity as $ar):
                                            array_push($array_area, $ar->city_id);
                                        endforeach;
                                        $arimp = implode(",", $array_area);
                                        $areacrit = " h.city_id in (".$arimp.") and ";
                                        $addgeo = FALSE;
                                    }
                                }
                            }
                            
                            if($addgeo)
                            {
                                $data = array();
                                $data['latitude']=$city->latitude;
                                $data['longitude']=$city->longitude;
                                
                                $exp =",";
                                $exp .= new CDbExpression("get_distance($city->latitude,$city->longitude, latitude, longitude) AS distance");                                
                            }
                            
                            $criteriahotel = new CDbCriteria();
                            $criteriahotel->alias = "h";                
                            $criteriahotel->select = "h.* ".$exp;
                            $criteriahotel->join=" JOIN tbl_hotel_portal hp on hp.hotel_id=h.id";
                            $criteriahotel->condition = $areacrit."hp.status =1 and h.status=1 and hp.portal_id=".$search['portal'];
                            $criteriahotel = $this->setFiltersCriteria($criteriahotel, $search);
                            
                            if($addgeo)
                            {
                                // count the distance in mile
                                $distanceMiles = Yii::app()->params['search']['distanceMiles'];
                                foreach ($distanceMiles as $distanceMile) {
                                    $criteriahotel->having = "distance <= ".$distanceMile;
                                    $hotelsCount = Hotel::model()->count($criteriahotel);
                                    if($hotelsCount >= Yii::app()->params['search']['min_hotel_required']) {
                                            break;
                                    }
                                }
                                $criteriahotel->order = "distance ASC";
                            }
                            $criteriahotel->together = true;
                            $allHotelData = Hotel::model()->findAll($criteriahotel);
                            
                            $chkTime=(isset($search['chk_time']))? $search['chk_time'] : "";
                            $min = isset($search['min'])?$search['min']:"";
                            $max = isset($search['max'])?$search['max']:"";
                            $this->render('searchlist',array('selectedCityId'=>$cityId,'city_name'=>$city->name,'model'=>$allHotelData,'portal'=>$search['portal'],'date'=>$search['date'],'max'=>$max,'min'=>$min,'chkTime'=>$chkTime,'usersearch'=>$search,'areaname'=>$areaname));
                            Yii::app()->end();
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('danger', "Please select the city from the option list");
			$this->render('create');
			Yii::app()->end();
                    }
		}
		$this->render('create');
	}
	
        public function setFiltersCriteria($criteria, $search) {
            
		$roomJoined = false;
		$roomAvailabilityJoined = false;
		$budgetJoined = false;
                
                //Date
                $isToday = 0;
		if(isset($search['date']) && !empty($search['date'])) {
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
				if(!$roomAvailabilityJoined) {
					$criteria->join.=" JOIN tbl_room_availability ra on rm.id=ra.room_id";
					$roomAvailabilityJoined = true;
				}
			}
			$roomJoined = true;
			$searchDate = date("Y-m-d",strtotime($search['date']));
			$criteria->addCondition("ra.availability_date LIKE '".$searchDate."%'");
                        
                        //Check if the date is selected is today's date or not
                        $isToday = ($searchDate == date('Y-m-d'))? 1 : 0;
		}
                
                //Budget
		if((isset($search['min']) && !empty($search['min'])) || (isset($search['max']) && !empty($search['max']))) {
			if(!$roomJoined) {
				$criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
				$roomJoined = true;
				if(!$budgetJoined) {
					$criteria->join.=" JOIN tbl_room_tariff rt on rm.id=rt.room_id";
					$budgetJoined = true;
				}
			}
                        else
                        {
                            if(!$budgetJoined) {
					$criteria->join.=" JOIN tbl_room_tariff rt on rm.id=rt.room_id";
					$budgetJoined = true;
				}
                        }
                        
			if(isset($search['date']) && !empty($search['date'])) {
				$searchDate = date("Y-m-d",strtotime($search['date']));
				$criteria->addCondition("rt.tariff_date='".$searchDate."'");
			}
                        if(isset($search['min']) && !empty($search['min']))
                        {
                            $criteria->addCondition("rt.price >= ".$search['min']);
                        }
                        if(isset($search['max']) && !empty($search['max']))
                        {
                            $criteria->addCondition("rt.price <= ".$search['max']);
                        }
                       
                }
                
                //Amenities
		if(isset($search['option']) && !empty($search['option'])) {
                    $equipStr = trim(implode(",", $search['option']),','); 
                    $criteria->join.=" JOIN tbl_hotel_equipment he on h.id=he.hotel_id";
                    $criteria->addCondition("he.equipment_id IN ($equipStr)");
                    /*
                    if(!$roomJoined) {
                        $criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
                        $roomJoined = true;
                    }
                    $equipStr = trim(implode(",", $search['option']),','); 
                    $criteria->join.=" JOIN tbl_room_options rp on rp.room_id=rm.id";
                    $criteria->addCondition("rp.equipment_id IN ($equipStr)");*/
		}
                
                //Arrival
                if(isset($search['chk_time']) && !empty($search['chk_time'])) {
                    if($search['chk_time']!="ARRIVAL TIME")
                    {
                    // The room should be avaialable before or on the arrival time
                        if(!$roomJoined) {
                                    $criteria->join.=" JOIN tbl_room rm on h.id=rm.hotel_id";
                                    $roomJoined = true;
                            }
                            
                        $reqFrom = date("H:i:s",strtotime($search['chk_time']));
                        $criteria->addCondition("rm.available_from <='".$reqFrom."'");
                        $criteria->addCondition("rm.available_till >'".$reqFrom."'");
                        
                        if($isToday)
                            $criteria->addCondition("TIMEDIFF(rm.available_till, DATE_FORMAT(NOW(),'%H:%i:%s'))>2");
                    }
                }  
                
                
                
                $criteria->group = 'h.id';
		
		return $criteria;
        }
	public function actionIndex()
	{
		$model = new Reservation();
		$dataProvider = new CActiveDataProvider('Reservation',array(
				'criteria'=>array(
						'with'=>array('customer','room','room.hotel'),
				),
		));
		$search = ""; $selected = "";
		if(isset($_REQUEST['Reservation'])){
			$dataProvider = CommonHelper::search(isset($_REQUEST['Reservation']['search'])?$_REQUEST['Reservation']['search']:"", $model, array('concat(customer.first_name," ",customer.last_name)','customer.email_address','t.nb_reservation','hotel.name','room.name','t.res_date'), array('customer','room','room.hotel'), isset($_REQUEST['Reservation']['selected'])?$_REQUEST['Reservation']['selected']:"");
			$search = $_REQUEST['Reservation']['search'];
			$selected = $_REQUEST['Reservation']['selected'];
		}
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model,
				'search'=>$search,
				'selected'=>$selected
		));
	}
	
	public function actionFilter()
	{ 		
		if(isset($_REQUEST['Search'])){
			$search = $_REQUEST['Search'];
			$min = isset($search['min'])?$search['min']:"";$max = isset($search['max'])?$search['max']:"";$chkTime=isset($search['chk_time'])?$search['chk_time']:"";
				
			$city = City::model()->find('t.name="'.$search['destination'].'" or t.slug="'.$search['destination'].'"');
                        $moonCondition = "";
                        $category ="";
                        $secMoonCondition = '';
                        if(!empty($_REQUEST['moon'])){
                            $category = 'moon';
                            $moonCondition = " and rm.category='moon'";
                            $secMoonCondition = "and roomAvailabilities.category = 'moon'";
                        }
			if($city){ 
				$data['latitude']=$city->latitude;
				$data['longitude']=$city->longitude;
				$st ="";
				if (isset($search['chk_time']) && !empty($search['chk_time'])){
					$starttime = strtotime($search['chk_time']);
					$st = "rm.available_from >= '".date('H:i:s',$starttime)."' and";
				}
				$data['condition']=$st." hp.portal_id=".$search['portal']." and rv.room_status<>'closed' and rv.availability_date='".$search['date']." '$moonCondition";
				$model = SearchController::actionGetDistance($data);
				//$model = Hotel::model()->with('hotelPortals','rooms.roomAvailabilities')->findAll('t.city_id='.$city->id." and hotelPortals.portal_id=".$search['portal']." and roomAvailabilities.room_status<>'closed' and roomAvailabilities.availability_date='".$search['date']."'");
			}else{ 
				$model = Hotel::model()->with('hotelPortals','rooms.roomAvailabilities','rooms')->findAll('t.name="'.$search['destination'].'" or t.slug="'.$search['destination'].'"'." and hotelPortals.portal_id=".$search['portal']." and roomAvailabilities.room_status<>'closed' and roomAvailabilities.availability_date='".$search['date'].'"'.$secMoonCondition);
			}
			if(!$model){
				Yii::app()->user->setFlash('danger', "No result found");
			}
			$this->render('searchlist',array('model'=>$model,'destination'=>$search['destination'],'portal'=>$search['portal'],'date'=>$search['date'],'min'=>$min,'max'=>$max,'chkTime'=>$chkTime,'nightFlag'=>$category));
			Yii::app()->end();
		}
		$this->render('create',array('nightFlag'=>''));
	}
	
	protected function gridDataColumn($data,$row)
	{ 
		switch ($data->reservation_status) {
			case "0":
				echo "In Progress";
				break;
		    case "1":
		        echo "Confirmed";
		        break;
		    case "2":
		        echo "Waiting For Confirmation";
		        break;
		    case "3":
		        echo "Cancelled By User";
		        break;
	        case "4":
	        	echo "Cancelled By Hotel";
	        	break;
        	case "5":
        		echo "No Show";
        		break;
		    default:
		        echo "In Progress";
		}
	}
	
	public function actionCityList($term=null){
		$finaldata = array();
		if($term){
			$criteriacity = new CDbCriteria();
            $criteriacity->select = 'id, name, slug, latitude, longitude';
            $criteriacity->addColumnCondition(array('t.status'=>1));
            $criteriacity->addSearchCondition('t.slug',$term); 
            $criteriacity->addSearchCondition('t.name',$term,true,'OR');
            $citydata = City::model()->with('state')->findAll($criteriacity);
           	 $i = 0;
            foreach ($citydata as $ctd){ 
            	$stateName = isset($ctd->state->code)?" (".$ctd->state->code.")":"";
	            $finaldata[$i]['id']= $ctd->id;
	            $finaldata[$i]['value']= $ctd->name.$stateName;
	            $finaldata[$i]['level']= $ctd->slug;
            	$i++;
            }
		}
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode($finaldata);
		Yii::app()->end();
	}
	
	public function actionHotelList($term = null, $hotelStatus = null){
		$access = Yii::app()->user->getState('access');
		$hotelStatus = isset($hotelStatus) ? $hotelStatus : 1;
		$finaldata = array();
		if($term){
			$criteriahotel = new CDbCriteria();
			$criteriahotel->select = 'id, name,slug';
			$criteriahotel->addSearchCondition('slug', $term);
			$criteriahotel->addSearchCondition('name', $term, true, 'OR');
			$criteriahotel->addSearchCondition('status', $hotelStatus);

        	//Manager can search only his hotel access list
            if($access=='manager') {
				$Allowed_hids = Yii::app()->user->getState('AccHotels');
                $criteriahotel->addInCondition('id',$Allowed_hids);
			}
			$hoteldata = Hotel::model()->findAll($criteriahotel);
			$i = 0;
			foreach ($hoteldata as $ctd){
				$finaldata[$i]['id']= $ctd->id;
				$finaldata[$i]['value']= $ctd->name;
				$finaldata[$i]['level']= $ctd->slug;
				$i++;
			}                        
		}
		header('Content-type: application/json');
		echo CJavaScript::jsonEncode($finaldata);
		Yii::app()->end();
	}
	
	public function actionGetDistance($data){
		
		$latitude  =  $data['latitude'];
		$longitude =  $data['longitude'];
		$condition =  $data['condition'];
		
		$criteriahotel = new CDbCriteria();
		
			$exp = new CDbExpression("get_distance($latitude,$longitude, latitude, longitude) AS distance");
			$criteriahotel->alias = "h";
			$criteriahotel->select = "h.*, $exp";
			$criteriahotel->addColumnCondition(array('h.status'=>1));
			$criteriahotel->addCondition($condition);
			$criteriahotel->join.=" inner join tbl_room rm on rm.hotel_id=h.id inner join tbl_room_availability rv on rv.room_id=rm.id inner join tbl_hotel_portal hp on hp.hotel_id=h.id";
			$criteriahotel->group = "h.id";
		 	// count the distance in mile
            $distanceMiles = Yii::app()->params['search']['distanceMiles'];
            foreach ($distanceMiles as $distanceMile) {
            	$criteriahotel->having = "distance <= ".$distanceMile;
            	$hotelsCount = Hotel::model()->count($criteriahotel);
            	if($hotelsCount >= Yii::app()->params['search']['min_hotel_required']) {
            		break;
            	}
            }
           
            return $hoteldata = Hotel::model()->findAll($criteriahotel);
	}
        
        public function actionGetNeighbourhood(){
            if($_POST['id']){
                $portalObject = AreaCity::model()->findAll('city_id = '.$_POST['id']);
                $options = array();
                if(count($portalObject) > 0) {
                	$options[] = "<option value='0'>-</option>";
                    foreach($portalObject as $portal){
                        if(!empty($portal->area)){
                            $options[] = "<option value='".$portal->area->id."'>".$portal->area->name."</option>";
                        }
                    }
                    $optionList = "";
                    if(!empty($options)){
                        $optionList = (implode("", $options));
                    }
                    $optionHtmlLink = "<select name='Search[area]' class='form-control select2me'>".$optionList."</select> <span for='Search[portal]' class='help-block'></span>";
                    header('Content-type: application/json');
                    echo CJavaScript::jsonEncode($optionHtmlLink);
                    Yii::app()->end();
                } else {
                    echo "";exit;
                }
            }
        }
}