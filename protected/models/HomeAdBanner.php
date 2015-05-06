<?php

/**
 * This is the model class for table "{{home_ad_banner}}".
 *
 * The followings are the available columns in table '{{home_ad_banner}}':
 * @property integer $id
 * @property string $banner
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $ad_page
 * @property string $ad_pos
 * @property string $created_at
 * @property string $updated_at
 */
class HomeAdBanner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{home_ad_banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, state_id, country_id', 'numerical', 'integerOnly'=>true),
			array('banner', 'length', 'max'=>255),
			array('created_at, updated_at, ad_page, ad_pos', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, banner, city_id, state_id, country_id, ad_page, ad_pos, created_at, updated_at', 'safe', 'on'=>'search'),
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
				'city' => array(self::BELONGS_TO, 'City', 'city_id'),
				'state' => array(self::BELONGS_TO, 'State', 'state_id'),
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
			'banner' => 'Banner',
			'city_id' => 'City',
			'state_id' => 'State',
			'country_id' => 'Country',
			'ad_page' => 'Ad Page',
			'ad_pos' => 'Ad Pos',
			'created_at' => 'Created At',
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
		$criteria->compare('banner',$this->banner,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('ad_page',$this->ad_page,true);
		$criteria->compare('ad_pos',$this->ad_pos,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HomeAdBanner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
