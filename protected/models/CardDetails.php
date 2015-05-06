<?php

/**
 * This is the model class for table "tbl_card_details".
 *
 * The followings are the available columns in table 'tbl_card_details':
 * @property integer $id
 * @property integer $reservation_id
 * @property string $card_details
 * @property string $created_at
 * @property string $updated_at
 */
class CardDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_card_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reservation_id', 'numerical', 'integerOnly'=>true),
			array('card_details', 'length', 'max'=>255),
			array('created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, reservation_id, card_details, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'reservation_id' => 'Reservation',
			'card_details' => 'Card Details',
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
		$criteria->compare('reservation_id',$this->reservation_id);
		$criteria->compare('card_details',$this->card_details,true);
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
	 * @return CardDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function create($postDataArray, $reservationId) {

            $cardDetailString = $postDataArray['card_number'] . "-" . $postDataArray['card_year'] . "-" . $postDataArray['card_month'] . "-" . $postDataArray['card_security_code'] . "-" . $postDataArray['card_holder_name'];
            $cardDetailsObject = new CardDetails;
            $cardDetailsObject->reservation_id = $reservationId;
            $cardDetailsObject->card_details = base64_encode($cardDetailString);
            $cardDetailsObject->created_at = new CDbExpression('NOW()');
            $cardDetailsObject->updated_at = new CDbExpression('NOW()');
            //Inserte in reservation option table
            return $cardDetailsObject->save();
        }

}
