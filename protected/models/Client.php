<?php

/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property string $id
 * @property string $name
 * @property string $client_no
 * @property string $address
 * @property string $postal_code
 * @property string $city
 * @property integer $country_id
 * @property string $email_add
 * @property integer $language_id
 * @property string $vat_no
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property ClientInvoice[] $clientInvoices
 */
class Client extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, client_no, address, postal_code, city, country_id, email_add, language_id, vat_no, added_at, updated_at', 'required'),
			array('country_id, language_id', 'numerical', 'integerOnly'=>true),
			array('name, email_add', 'length', 'max'=>150),
			array('client_no, vat_no', 'length', 'max'=>30),
			array('postal_code', 'length', 'max'=>15),
			array('city', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, client_no, address, postal_code, city,city_id, country_id, email_add, language_id, vat_no, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'clientInvoices' => array(self::HAS_MANY, 'ClientInvoice', 'client_id'),
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
			'client_no' => 'Client No',
			'address' => 'Address',
			'postal_code' => 'Postal Code',
			'city' => 'City',
			'country_id' => 'Country',
			'email_add' => 'Email ID',
			'language_id' => 'Language',
			'vat_no' => 'Vat No',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('client_no',$this->client_no,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('email_add',$this->email_add,true);
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('vat_no',$this->vat_no,true);
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
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
