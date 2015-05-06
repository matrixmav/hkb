<?php

/**
 * This is the model class for table "tbl_country".
 *
 * The followings are the available columns in table 'tbl_country':
 * @property integer $id
 * @property string $slug
 * @property string $iso_code
 * @property string $flag_name
 * @property string $country_code
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property PortalContact[] $portalContacts
 * @property State[] $states
 */
class Country extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,slug, iso_code', 'required'),
			array('status', 'numerical','country_code', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>100),
			array('iso_code', 'length', 'max'=>4),
			array('flag_name', 'length', 'max'=>20),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, slug, iso_code,country_code,flag_name, status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'cities' => array(self::HAS_MANY, 'City', 'country_id'),
			'portalContacts' => array(self::HAS_MANY, 'PortalContact', 'country_id'),
			'states' => array(self::HAS_MANY, 'State', 'country_id'),
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
			'iso_code' => 'Iso Code',
                        'country_code' => 'Country Code',
			'flag_name' => 'Flag Name',
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
		$criteria->compare('iso_code',$this->iso_code,true);
                $criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('flag_name',$this->flag_name,true);
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
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getCountryByName($condition) {
            return $model = self::model ()->findByAttributes($condition);
	}
	
	public static function getAllCountry($criteria="") {
		return self::model ()->findAll($criteria);
	}
}
