<?php

/**
 * This is the model class for table "tbl_hotel_administrative".
 *
 * The followings are the available columns in table 'tbl_hotel_administrative':
 * @property integer $id
 * @property integer $hotel_id
 * @property string $account_no
 * @property string $hotel_ownfirst_name
 * @property string $hotel_ownlast_name
 * @property string $contract_file
 * @property string $contract_start_date
 * @property string $registration_no
 * @property string $vat_no
 * @property string $billing_address
 * @property string $accounting_info
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Hotel $hotel
 * @property HotelAdministrativeEmail[] $hotelAdministrativeEmails
 */
class HotelAdministrative extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hotel_administrative';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_no, contract_start_date', 'required'),
			array('hotel_id', 'numerical', 'integerOnly'=>true),
			array('account_no, registration_no, vat_no', 'length', 'max'=>20),
                        array('hotel_ownfirst_name, hotel_ownlast_name', 'length', 'max'=>75),
			array('contract_file', 'length', 'max'=>15),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			array('billing_address,accounting_info', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hotel_id,hotel_ownfirst_name,hotel_ownlast_name,account_no, contract_file, contract_start_date, registration_no, vat_no, billing_address, accounting_info, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'hotelAdministrativeEmails' => array(self::HAS_MANY, 'HotelAdministrativeEmail', 'administrative_id'),
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
                        'hotel_ownfirst_name' => 'Hotel owner Firstname',
                        'hotel_ownlast_name' => 'Hotel owner Lastname',
			'account_no' => 'Account No',
			'contract_file' => 'Contract File',
			'contract_start_date' => 'Contract Start Date',
			'registration_no' => 'Registration No',
			'vat_no' => 'Vat No',
			'billing_address' => 'Billing Address',
			'accounting_info' => 'Accounting Info',
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
                $criteria->compare('hotel_ownfirst_name',$this->hotel_ownfirst_name);
                $criteria->compare('hotel_ownlast_name',$this->hotel_ownlast_name);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('contract_file',$this->contract_file,true);
		$criteria->compare('contract_start_date',$this->contract_start_date,true);
		$criteria->compare('registration_no',$this->registration_no,true);
		$criteria->compare('vat_no',$this->vat_no,true);
		$criteria->compare('billing_address',$this->billing_address,true);
		$criteria->compare('accounting_info',$this->accounting_info,true);
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
	 * @return HotelAdministrative the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
