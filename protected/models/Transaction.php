<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property integer $id
 * @property integer $user_id
 * @property string $mode
 * @property integer $gateway_id
 * @property integer $actual_amount
 * @property integer $paid_amount
 * @property integer $total_rp
 * @property integer $used_rp
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class Transaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, mode, gateway_id, actual_amount, paid_amount, status, created_at, updated_at', 'required'),
			array('user_id, gateway_id, status', 'numerical', 'integerOnly'=>true),
			array('mode', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, mode, gateway_id, actual_amount, paid_amount, total_rp, used_rp, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'usertable' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'mode' => 'Mode',
			'gateway_id' => 'Gateway',
			'actual_amount' => 'Actual Amount',
			'paid_amount' => 'Paid Amount',
			'total_rp' => 'Total Rp',
			'used_rp' => 'Used Rp',
			'status' => 'Status',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('mode',$this->mode,true);
		$criteria->compare('gateway_id',$this->gateway_id);
		$criteria->compare('actual_amount',$this->actual_amount);
		$criteria->compare('paid_amount',$this->paid_amount);
		$criteria->compare('total_rp',$this->total_rp);
		$criteria->compare('used_rp',$this->used_rp);
		$criteria->compare('status',$this->status);
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
	 * @return Transaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
