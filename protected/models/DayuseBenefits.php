<?php

/**
 * This is the model class for table "{{dayuse_benefits}}".
 *
 * The followings are the available columns in table '{{dayuse_benefits}}':
 * @property integer $id
 * @property string $benefit_img
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $benefit_img_page
 * @property string $created_at
 * @property string $updated_at
 */
class DayuseBenefits extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dayuse_benefits}}';
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
			array('benefit_img', 'length', 'max'=>255),
			array('benefit_img_page', 'length', 'max'=>12),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, benefit_img, city_id, state_id, country_id, benefit_img_page, created_at, updated_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'benefit_img' => 'Benefit Img',
			'city_id' => 'City',
			'state_id' => 'State',
			'country_id' => 'Country',
			'benefit_img_page' => 'Benefit Img Page',
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
		$criteria->compare('benefit_img',$this->benefit_img,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('benefit_img_page',$this->benefit_img_page,true);
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
	 * @return DayuseBenefits the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
