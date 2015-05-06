<?php

/**
 * SearchForm class.
 * SearchForm is the data structure for keeping search form data.
 */
class SearchForm extends CFormModel {

	public $search_keyword;
	public $search_id;
	public $search_type;
	public $date;
	public $arrival_time;
	public $stay_duration;
	public $budget;
	public $rating;
	public $equipment;
	public $theme;
	public $district;
    public $latitude;
    public $longitude;
    public $order;
    public $page = 0;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that will receive user inputs.
        return array(
            array('search_keyword, search_id, search_type, date, arrival_time, stay_duration, budget, rating, equipment, theme, district, latitude, longitude, order, page', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'search_keyword' => "Search Keyword",
        	"search_id" => "Search Id",
            "search_type" => "Search Type",
        	"date" => "Date",
        	"arrival_time" => "Arrival Time",
        	"stay_duration" => "Stay Duration",
        	"budget" => "Budget",
        	"rating" => "Rating",
        	"equipment" => "Equipment",
        	"theme" => "Theme",
        	"district" => "District",
        	'latitude' => 'Latitude',
        	'longitude' => 'Longitude',            
        	'order' => 'Order',
        	'page' => 'Page',
        );
    }

    public function getArrivalTimeArray() {
    	$startTime = YII::app()->params['searcharrivalTime']['startTime'];
        
        $endTime = YII::app()->params['searcharrivalTime']['endTime'];
        $duration = YII::app()->params['arrivalTime']['duration'];

        $start = strtotime($startTime);
        $end = strtotime($endTime);

        return array('start'=>$start,'end'=>$end,'duration'=>$duration);
        //return YII::app()->params['searcharrivalTime'];
    }
    
    public function getDurationLength() {
    	return array(
    			'2' => "2 H",
    			'4' => "4 H",
    			'6' => "6 H",
    			'8' => "8 H",
    			'nuit' => "NUIT",
    	);
    }
    
    public function getBudgetArray() {
    	return array(
    			'1' => 'Less than 100',
    			'2' => '100-150',
    			'3' => '150 and more'
    	);
    }
    
    public function setBudgetArray() {
    	return array(
    			'1' => 'Less than 100$',
    			'2' => '100$ to 150$',
    			'3' => 'more than $150'
    	);
    }
    
    public function getStarRatings() {
    	return array(
    			'1' => 1,
    			'2' => 2,
    			'3' => 3,
    			'4' => 4,
    			'5' => 5,
    	);
    }
    
    public function getEquipmentOptions() {
    	
    	$criteriaequip = new CDbCriteria();
    	$criteriaequip->select = 'id,name';
    	$criteriaequip->addColumnCondition(array('t.status'=>1));
    	$criteriaequip->addColumnCondition(array('t.hotel_id'=>0));
    	//$criteriaequip->addColumnCondition(array('t.type'=>'hotel'));
        $criteriaequip->addColumnCondition(array('t.searchable_type'=>1));        
    	$criteriaequip->order="t.type ASC";

    	$equipdata = Equipment::model()->findAll($criteriaequip);
    	
    	return $equipdata;
        //return Equipment::model()->findAll('hotel_id="0" and type="hotel"',array('order'=>'show_order asc'));        
    }
    
    public function getRoomOptions() {
    	
    	$criteriaequip = new CDbCriteria();
    	$criteriaequip->select = 'id,name';
    	$criteriaequip->addColumnCondition(array('t.status'=>1));
    	$criteriaequip->addColumnCondition(array('t.hotel_id'=>0));
    	$criteriaequip->addColumnCondition(array('t.type'=>'room'));
        $criteriaequip->addColumnCondition(array('t.searchable_type'=>1));        
    	$criteriaequip->order="show_order ASC";

    	$equipdata = Equipment::model()->findAll($criteriaequip);
    	
    	return $equipdata;
        //return Equipment::model()->findAll('hotel_id="0" and type="hotel"',array('order'=>'show_order asc'));        
    }
    
    public function getThemeOptions() {
    	return Theme::model()->findAll();
    }
    
    public function getDistrictOptions($cityId,$srcType) {
        $arealist = array();
        /*if($srcType==2)
        {
            $arealist = Area::model()->findAll('city_id = '.$cityId);
        }*/
    	return $arealist;
    }
    
    public function sortOptions() {
        return array(
            '1' => 'Relevance',
            '2' => 'Price',
            '3' => 'Distance',
            '4' => "Promotion",
        );
    }
}