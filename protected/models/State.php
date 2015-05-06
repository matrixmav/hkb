<?php

/**
 * This is the model class for table "tbl_state".
 *
 * The followings are the available columns in table 'tbl_state':
 * @property integer $id
 * @property string $slug
 * @property integer $country_id
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property City[] $tblCities
 * @property Country $country
 */
class State extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,slug,latitude, longitude', 'required','except'=>'status'),
			array('country_id, status', 'numerical', 'integerOnly'=>true),
			array('image', 'file', 'allowEmpty'=>true, 'types'=>'jpg, gif, png'),
			array('slug', 'length', 'max'=>100),
			array('latitude, longitude', 'length', 'max'=>20),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('image,latitude, longitude', 'safe', 'on'=>'status'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, country_id,image,latitude, longitude, status,code, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'cities' => array(self::HAS_MANY, 'City', 'state_id'),
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
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
			'country_id' => 'Country',
			'status' => 'Status',
			'added_at' => 'Added At',
			'updated_at' => 'Updated At',
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
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => $pageSize),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return State the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getStateByName($condition) {
            return $model = self::model ()->findByAttributes($condition);
	}
        
//        public function getCityAndHotelCountById($cityId){ 
//            $cityObject =  City::model()->find($cityId);
//            $neighourhoodCondition = $cityObject->id;//TODO: need to change this city id
//            $neighourhoodHotelsCount = Hotel::model()->count($neighourhoodCondition);
//            return array('cityName' => $cityObject->slug,
//                'hotelCount' => $neighourhoodHotelsCount);
//            
//        }
        
    public function getCity($limit = 8){
            return $cityObject =  City::model()->findAll(array('order' => 'id desc', 'limit' => $limit));
    }
    
    public static function getAllState($criteria="") {
    	return $model = self::model ()->findAll($criteria);
    }
}
