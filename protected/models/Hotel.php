<?php

/**
 * This is the model class for table "tbl_hotel".
 *
 * The followings are the available columns in table 'tbl_hotel':
 * @property integer $id
 * @property string $name
 * @property string $simple_name
 * @property string $slug
 * @property string $timezone
 * @property integer $group_id
 * @property integer $star_rating
 * @property string $address
 * @property string $postal_code
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $longitude
 * @property string $latitude
 * @property integer $language_id
 * @property string $website
 * @property string $telephone
 * @property string $fax
 * @property string $com_con_info
 * @property integer $default_currency_id
 * @property double $day_commission
 * @property double $night_commission
 * @property double $addon_commission
 * @property integer $is_new
 * @property integer $is_feature
 * @property string $feature_till_date
 * @property double $room_leastprice
 * @property string $comment
 * @property integer $status
 * @property integer $reminder_block
 * @property integer contract_status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblCity $city
 * @property TblState $state
 * @property TblCountry $country
 * @property TblGroup $group
 * @property TblLanguage $language
 * @property TblHotelAdministrative[] $tblHotelAdministratives
 * @property TblHotelContent[] $tblHotelContents
 * @property TblHotelCurrency[] $tblHotelCurrencies
 * @property TblHotelEmail[] $tblHotelEmails
 * @property TblHotelEquipment[] $tblHotelEquipments
 * @property TblHotelPhoto[] $tblHotelPhotos
 * @property TblHotelPortal[] $tblHotelPortals
 * @property TblHotelTheme[] $tblHotelThemes
 */
class Hotel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hotel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
			//array('name, slug, timezone, star_rating, address, postal_code, longitude, latitude, website, telephone, fax, com_con_info, default_currency_id, day_commission, night_commission, addon_commission, is_new, is_feature, feature_till_date, room_leastprice, comment, added_at, updated_at', 'required'),
			array('status,city_id,timezone,name,address', 'required'),
			array('group_id, star_rating, city_id, district_id, state_id, country_id, language_id, default_currency_id, is_new, is_feature,is_top, status', 'numerical', 'integerOnly'=>true),
			array('day_commission, night_commission, addon_commission,contract_status', 'numerical'),
			array('name,simple_name,slug, timezone', 'length', 'max'=>150),
			array('postal_code', 'length', 'max'=>10),
			array('longitude, latitude', 'length', 'max'=>20),
			array('website', 'length', 'max'=>120),
			array('telephone, fax', 'length', 'max'=>15),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('auth_dec', 'safe'),					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name,simple_name, slug, timezone, group_id, star_rating, address, postal_code, city_id, district_id, state_id, country_id, longitude, latitude, language_id, website, telephone, fax, com_con_info, default_currency_id, day_commission, night_commission, addon_commission, is_new, is_feature,is_top,best_deal,feature_till_date, room_leastprice,comment, status,reminder_block,contract_status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'language' => array(self::BELONGS_TO, 'Language', 'language_id'),
			'hotelAdministratives' => array(self::HAS_MANY, 'HotelAdministrative', 'hotel_id'),
			'hotelContents' => array(self::HAS_MANY, 'HotelContent', 'hotel_id'),
			'hotelCurrencies' => array(self::HAS_MANY, 'HotelCurrency', 'hotel_id'),
			'hotelEmails' => array(self::HAS_MANY, 'HotelEmail', 'hotel_id'),
			'hotelEquipments' => array(self::HAS_MANY, 'HotelEquipment', 'hotel_id'),
			'hotelPhotos' => array(self::HAS_MANY, 'HotelPhoto', 'hotel_id'),
			'hotelPortals' => array(self::HAS_MANY, 'HotelPortal', 'hotel_id'),
			'hotelThemes' => array(self::HAS_MANY, 'HotelTheme', 'hotel_id'),
                        'rooms' => array(self::HAS_MANY, 'Room', 'hotel_id'),
			'hotelAccess'=>array(self::HAS_MANY, 'HotelAccess', 'hotel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
                        'simple_name'=>'Simple Name',
			'slug' => 'Slug',
			'timezone' => 'Timezone',
			'group_id' => 'Group',
			'star_rating' => 'Star Rating',
			'address' => 'Address',
			'postal_code' => 'Postal Code',
			'city_id' => 'City',
			'district_id' => 'District',
			'state_id' => 'State',
			'country_id' => 'Country',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'language_id' => 'Language',
			'website' => 'Website',
			'telephone' => 'Telephone',
			'fax' => 'Fax',
			'com_con_info' => 'Com Con Info',
			'default_currency_id' => 'Default Currency',
			'day_commission' => 'Day Commission',
			'night_commission' => 'Night Commission',
			'addon_commission' => 'Addon Commission',
			'is_new' => 'Is New',
			'is_feature' => 'Is Feature',
			'is_top' => 'Is Top',
			'best_deal' => 'Best Deal',
			'feature_till_date' => 'Feature Till Date',
			'room_leastprice' => 'Room Leastprice',
			'comment' => 'Comment',
			'status' => 'Status',
                        'contract_status' =>'Contract Status',
			'added_at' => 'Added At',
			'updated_at' => 'Updated At'
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
	public function search($pageSize=50)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
                $criteria->compare('simple_name',$this->simple_name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('timezone',$this->timezone,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('star_rating',$this->star_rating);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('com_con_info',$this->com_con_info,true);
		$criteria->compare('default_currency_id',$this->default_currency_id);
		$criteria->compare('day_commission',$this->day_commission);
		$criteria->compare('night_commission',$this->night_commission);
		$criteria->compare('addon_commission',$this->addon_commission);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('is_feature',$this->is_feature);
		$criteria->compare('is_top',$this->is_top);
		$criteria->compare('best_deal',$this->best_deal);
		$criteria->compare('feature_till_date',$this->feature_till_date,true);
		$criteria->compare('room_leastprice',$this->room_leastprice);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status);
                $criteria->compare('contract_status',$this->contract_status);                
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->order = "updated_at desc";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => $pageSize),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Hotel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function readHotel($featuredHotelIdforState, $orderBy = 'id' ,$limit = 6){
                $criteriaFeaturedHotelforState = new CDbCriteria;
                $criteriaFeaturedHotelforState->addInCondition("id" , $featuredHotelIdforState);
                $criteriaFeaturedHotelforState->addCondition("status = 1");
                $criteriaFeaturedHotelforState->limit = $limit;
                $criteriaFeaturedHotelforState->order = $orderBy;
                return $hotelObject = Hotel::model()->findAll($criteriaFeaturedHotelforState);
        }
        
        public function readHotelWithCondition($condition, $order = 'id' ,$limit = 6){
                return $model = self::model ()->findAll ( array (
                            "condition" => $condition, 
                            "order" => $order." DESC",
                            "limit" => $limit 
            ) );
        }
        
        public function getUrl() {
            	return Yii::app()->createUrl('hotel/detail', array("slug"=>$this->slug));
        }
        public function getMobileUrl() {
            	return Yii::app()->createUrl('mobile/hotel/detail', array("slug"=>$this->slug));
        }
        public function getHotelRating($hotelid){
        	$hotel = Hotel::model()->findByPk($hotelid);
        	$rating = "";
        	if($hotel->star_rating ==1)
        	{
        		$rating = "one";
        	}elseif($hotel->star_rating ==2){
        		$rating = "two";
        	}elseif($hotel->star_rating ==3){
        		$rating = "three";
        	}elseif($hotel->star_rating ==4){
        		$rating = "four";
        	}elseif($hotel->star_rating ==5){
        		$rating = "five";
        	}
        	return $rating;
        }
        
        public static function getHotelName($id){
        	$model = self::model()->findByPk($id);
        	return isset($model->name)?$model->name:"";
        }
        
        public static function getAllHotel($criteria="",$pageSize=""){
        	return new CActiveDataProvider('Hotel', array(
				'criteria'=>$criteria,
        		'sort'=>array(
		            'attributes'=>array(
		                'city.name'=>array(
		                    'asc'=>'city.name ASC',
		                    'desc'=>'city.name DESC',
		                ),
		                '*',
		            ),
		        ),
				'pagination' => array('pageSize' => $pageSize),
			));
        }

}
