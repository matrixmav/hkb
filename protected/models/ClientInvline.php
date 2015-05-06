<?php

/**
 * This is the model class for table "{{client_invline}}".
 *
 * The followings are the available columns in table '{{client_invline}}':
 * @property string $id
 * @property string $client_inv_no
 * @property string $title
 * @property double $unit_price
 * @property integer $qty
 * @property double $wv_amt
 * @property double $vat
 * @property double $vat_amt
 * @property double $tot_amt
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property ClientInvoice $clientInvNo
 */
class ClientInvline extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_client_invline';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_inv_no, title, unit_price, qty, wv_amt, vat, vat_amt, tot_amt, added_at, updated_at', 'required'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('unit_price, wv_amt, vat, vat_amt, tot_amt', 'numerical'),
			array('client_inv_no', 'length', 'max'=>30),
			array('title', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_inv_no, title, unit_price, qty, wv_amt, vat, vat_amt, tot_amt, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'clientInvNo' => array(self::BELONGS_TO, 'ClientInvoice', 'client_inv_no'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_inv_no' => 'Client Inv No',
			'title' => 'Title',
			'unit_price' => 'Unit Price',
			'qty' => 'Qty',
			'wv_amt' => 'Wv Amt',
			'vat' => 'Vat',
			'vat_amt' => 'Vat Amt',
			'tot_amt' => 'Tot Amt',
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
		$criteria->compare('client_inv_no',$this->client_inv_no,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('wv_amt',$this->wv_amt);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('vat_amt',$this->vat_amt);
		$criteria->compare('tot_amt',$this->tot_amt);
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
	 * @return ClientInvline the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
