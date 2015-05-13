<?php

/**
 * This is the model class for table "money_transfer".
 *
 * The followings are the available columns in table 'money_transfer':
 * @property integer $id
 * @property integer $to_user_id
 * @property integer $from_user_id
 * @property integer $fund_type
 * @property string $comment
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class MoneyTransfer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'money_transfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to_user_id, from_user_id, fund_type, comment, created_at, updated_at', 'required'),
			array('to_user_id, from_user_id, fund_type, status', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, to_user_id, from_user_id, fund_type, comment, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
                    'touser' => array(self::BELONGS_TO, 'User', 'to_user_id'),
                    'fromuser' => array(self::BELONGS_TO, 'User', 'from_user_id')
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'to_user_id' => 'To User',
			'from_user_id' => 'From User',
			'fund_type' => '1:RP,2:Amount',
			'comment' => 'Comment',
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
		$criteria->compare('to_user_id',$this->to_user_id);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('fund_type',$this->fund_type);
		$criteria->compare('comment',$this->comment,true);
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
	 * @return MoneyTransfer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
