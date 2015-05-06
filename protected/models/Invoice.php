<?php

/**
 * This is the model class for table "{{invoice}}".
 *
 * The followings are the available columns in table '{{invoice}}':
 * @property string $id
 * @property string $inv_no
 * @property string $inv_date
 * @property integer $inv_month
 * @property integer $inv_year
 * @property integer $hotel_id
 * @property string $account_no
 * @property string $inv_label
 * @property double $hotel_inv
 * @property double $vat_amt
 * @property double $total_inv
 * @property double $paid_inv
 * @property double $pending_inv
 * @property string $added_at
 * @property string $updated_at
 */
class Invoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inv_no, inv_date, inv_month, inv_year, hotel_id,inv_country, inv_label, hotel_inv, vat_amt, total_inv, paid_inv, pending_inv,inv_due_date', 'required'),
			array('inv_month, inv_year, hotel_id', 'numerical', 'integerOnly'=>true),
			array('hotel_inv, vat_amt, total_inv, paid_inv, pending_inv,reminder_nos', 'numerical'),
			array('inv_no, account_no', 'length', 'max'=>20),
			array('inv_label', 'length', 'max'=>150),
			array('account_no','safe'),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),					
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, inv_no, inv_date, inv_month, inv_year, hotel_id,inv_country, account_no, inv_label, hotel_inv, vat_amt, total_inv, paid_inv, pending_inv,reminder_nos,inv_due_date, added_at, updated_at', 'safe', 'on'=>'search'),
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
				'hotelAdministratives' => array(self::BELONGS_TO, 'HotelAdministrative', '', 'foreignKey' => array('hotel_id'=>'hotel_id')),
				'hotel' => array(self::BELONGS_TO, 'Hotel', 'hotel_id'),					
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'inv_no' => 'Inv No',
			'inv_date' => 'Inv Date',
			'inv_month' => 'Inv Month',
			'inv_year' => 'Inv Year',
			'hotel_id' => 'Hotel',
			'account_no' => 'Account No',
			'inv_label' => 'Inv Label',
			'hotel_inv' => 'Hotel Inv',
			'vat_amt' => 'Vat Amt',
			'total_inv' => 'Total Inv',
			'paid_inv' => 'Paid Inv',
			'pending_inv' => 'Pending Inv',
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
		$criteria->compare('inv_no',$this->inv_no,true);
		$criteria->compare('inv_date',$this->inv_date,true);
		$criteria->compare('inv_month',$this->inv_month);
		$criteria->compare('inv_year',$this->inv_year);
		$criteria->compare('hotel_id',$this->hotel_id);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('inv_label',$this->inv_label,true);
		$criteria->compare('hotel_inv',$this->hotel_inv);
		$criteria->compare('vat_amt',$this->vat_amt);
		$criteria->compare('total_inv',$this->total_inv);
		$criteria->compare('paid_inv',$this->paid_inv);
		$criteria->compare('pending_inv',$this->pending_inv);
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
	 * @return Invoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotal($records, $column)
	{
		$total = 0;
		foreach ($records as $record) {
			$total += $record->$column;
		}
		return number_format($total,2);
	}
}
