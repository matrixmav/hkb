<?php

class SiteController extends Controller
{
    public $layout = 'main';
    /**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
                                'actions'=>array('index','reservation','loadmore'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    /**
     * 
     */
    public function actionIndex() { 
        
        $cityName = 'new-york'; //TODO: get from geo location
        $stateName = 'new-york';
        $countryName = 'USA';
        if(!empty($_REQUEST['cityName'])){
            $cityName = $_REQUEST['cityName']; //TODO: get from geo location
        }

        $hotelModel = Hotel::model();
        $cityModel = City::model();

        $condition = array("slug" => $cityName);
        //read geo location city
        $cityObject = $cityModel->getCityByName($condition);
        // get top 4 cities with the hotel count
        $cityListObject = $cityModel->getCity(4);
        if ($cityObject) { 
            $hotelLimit = 3; //
            $cityId = $cityObject->id;
            $cityCondition = 'city_id = ' . $cityId;
            $featuredHotelIdforState = FeaturedHotel::model()->getFeaturedHotelListId($cityCondition);

            $hotelObject = $hotelModel->readHotel($featuredHotelIdforState, $hotelLimit);
            if(!empty($featuredHotelIdforState)){
                $otherHotelCondition = "id NOT IN (" . implode(',', $featuredHotelIdforState) . ") AND status = 1";
                $otherHotelObject = $hotelModel->findAll(array('condition' => $otherHotelCondition, 'limit' => $hotelLimit));
                $hotelObject = array_merge($hotelObject, $otherHotelObject);
            } else {
                $cityHotelCondition = "is_new = 1  AND status = 1 AND city_id =". $cityId;
                //read geo location city
                $hotelObject = $hotelModel->readHotelWithCondition($cityHotelCondition, $hotelLimit);
            }

            $this->render('index', array( 
                    'hotelObject'=>$hotelObject,
                    'cityListObject'=>$cityListObject)); //080 25721933
        }
    }
    
    public function actionReservation() {
        echo "cool";exit;
    }
    
    /**
     * load more hotels
     */
    public function actionLoadMore(){ 
        if($_REQUEST){
            $offset = $_REQUEST['offset'];
            $limit = $_REQUEST['limit'];
            $hotelObject = Hotel::model()->findAll(array('condition'=>'status = 1','limit' => $limit, 'offset' => $offset));
            $readMoreHotel = $this->renderPartial('hotel', 
                    array('hotelObject' => $hotelObject,true));
            print_r($readMoreHotel);exit;
        }
    }

}