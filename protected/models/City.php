<?php

/**
 * This is the model class for table "tbl_city".
 *
 * The followings are the available columns in table 'tbl_city':
 * @property integer $id
 * @property string $slug
 * @property integer $state_id
 * @property integer $country_id
 * @property string $latitude
 * @property string $longitude
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 * @property integer $is_big
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property State $state
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,slug,latitude, longitude', 'required','except'=>'addhotelcount'),
			array('state_id, country_id, status, is_big', 'numerical', 'integerOnly'=>true),
			array('image', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png'),
			array('slug', 'length', 'max'=>100),
			array('latitude, longitude', 'length', 'max'=>20),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('id, slug, state_id, country_id, image,latitude, longitude, status, added_at, updated_at, is_big', 'safe', 'on'=>'addhotelcount'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, state_id, country_id, image,latitude, longitude, status, added_at, updated_at, is_big', 'safe', 'on'=>'search'),
			
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'slug' => 'Slug',
			'state_id' => 'State',
			'country_id' => 'Country',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'status' => 'Status',
			'added_at' => 'Added At',
			'updated_at' => 'Updated At',
			'is_big' => 'Is Big',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$pageSize = Yii::app()->params['defaultPageSize'];
		
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('is_big',$this->is_big);
		$criteria->order = "name asc";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => $pageSize),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getCityByName($condition) {
            return $model = self::model ()->findByAttributes($condition);
	}
        
        public function getCityAndHotelCountById($cityId){ 
            $cityObject =  City::model()->findByPk($cityId);
            $neighourhoodHotelsCount = Hotel::model()->count(array('condition' => 'city_id=:cityId AND status = 1', 
                 'params'=>array(':cityId' => $cityId)));
            return array('cityName' => $cityObject->name,
                'hotelCount' => $neighourhoodHotelsCount);
            
        }
        
        public function getCity($limit = 8){
            return $cityObject =  City::model()->findAll(array('order' => 'hotel_count desc', 'limit' => $limit));
        }
        
        public function getUrl() {
            	//return Yii::app()->createUrl('/search/index', array("term"=>$this->name,"type"=>2,"uniId"=>$this->id));
            return Yii::app()->createUrl('/search/index', array("search_widget_type"=>1,"SearchForm[search_keyword]"=>$this->name,"SearchForm[search_id]"=>$this->id,"SearchForm[search_type]"=>2));
            //return "#";
            //search_widget_type=1&SearchForm[search_keyword]=New+York+(NY)&SearchForm[search_id]=17081&SearchForm[search_type]=2
        }
        public function getTopCityByStateId($stateId , $cityId, $limit = 8){
            return $model = City::model ()->findAll ( array (
                            "condition" => ('state_id = '.$stateId . ' AND id != '. $cityId), 
                            "order" => "hotel_count DESC",
                            "limit" => $limit 
            ) );
        }
        
        public static function getAllCity($criteria="") {
        	return self::model ()->findAll($criteria);
        }
}

