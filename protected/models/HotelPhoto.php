<?php

/**
 * This is the model class for table "tbl_hotel_photo".
 *
 * The followings are the available columns in table 'tbl_hotel_photo':
 * @property integer $id
 * @property integer $hotel_id
 * @property string $name
 * @property integer $position
 * @property integer $is_featured
 * @property integer $is_slider
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Hotel $hotel
 * @property PhotoPortal[] $photoPortals
 */
class HotelPhoto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hotel_photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, position', 'required'),
			array('hotel_id, position, is_featured, is_slider, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id, name, position, is_featured, is_slider, status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),
			'photoPortals' => array(self::HAS_MANY, 'PhotoPortal', 'photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hotel_id' => 'Hotel',
			'name' => 'Name',
			'position' => 'Position',
			'is_featured' => 'Is Featured',
			'is_slider' => 'Is Slider',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('is_featured',$this->is_featured);
		$criteria->compare('is_slider',$this->is_slider);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HotelPhoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getHotelPhoto($condition, $limit = '3') {
            return $model = self::model ()->findAll ( array (
                            "condition" => $condition, "limit" => "$limit"  
            ) );
	}
        
        public function getHotelSliderImage($limit = '3') {
            return $model = self::model ()->findAll ( array (
                            "condition" => 'is_featured = 1 AND is_slider = 1',
                            "order" => "id DESC",
                            "limit" => $limit  
            ) );
	}
        
        /**
         * Get Single Hotel photo object
         * 
         * @param int $hotelId
         * @return Objecct
         */
        public function getHotelFeaturedPhoto($hotelId, $folderName) {
            $hotelPhotoCondition = array('hotel_id'=>$hotelId,'is_featured' => 1);
            $hotelPhotoObject = self::model()->findByAttributes($hotelPhotoCondition);
            if(!empty($hotelPhotoObject)){
                return Yii::app()->params['imagePath']['hotel'].$hotelId."/".$folderName."/".$hotelPhotoObject->name;
            } else {
                $hotelPhotoObject = self::model()->findByAttributes(array('hotel_id' => $hotelId));
                if($hotelPhotoObject)
                    return Yii::app()->params['imagePath']['hotel'].$hotelId."/".$folderName."/".$hotelPhotoObject->name;
                else
                    return "";
            }
        }
        
}
