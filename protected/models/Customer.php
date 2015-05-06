<?php

/**
 * This is the model class for table "tbl_customer".
 *
 * The followings are the available columns in table 'tbl_customer':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $telephone
 * @property integer $origin_id
 * @property string $password
 * @property integer $is_subscribed
 * @property integer $status
 * @property string $auth_code
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblOrigin $origin
 * @property TblNewsletter[] $tblNewsletters
 * @property TblReservation[] $tblReservations
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name,country_id,email_address, telephone, added_at, updated_at', 'required'),
			array('origin_id, is_subscribed, status', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>75),
			array('email_address, password', 'length', 'max'=>150),
			array('telephone', 'length', 'max'=>15),
			array('auth_code', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, comment, email_address, country_id,telephone, origin_id, password, is_subscribed, status, auth_code, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'origin' => array(self::BELONGS_TO, 'Origin', 'origin_id'),
			'newsletters' => array(self::HAS_MANY, 'Newsletter', 'customer_id'),
			'reservations' => array(self::HAS_MANY, 'Reservation', 'customer_id'),
                        'country'=> array(self::BELONGS_TO, 'Country', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email_address' => 'Email Address',
                        'country_id' => 'Country Code',
			'telephone' => 'Telephone',
			'origin_id' => 'Origin',
			'password' => 'Password',
			'is_subscribed' => 'Is Subscribed',
			'status' => 'Status',
			'auth_code' => 'Auth Code',
			'comment'=>'Comment',
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
	public function search($isSubscribed = "0")
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email_address',$this->email_address,true);
                $criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('origin_id',$this->origin_id);
		$criteria->compare('password',$this->password);
		$criteria->compare('is_subscribed',$isSubscribed);
		$criteria->compare('status',$this->status);
		$criteria->compare('auth_code',$this->auth_code,true);
		$criteria->compare('comment',$this->comment,true);		
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
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
     * Create customer
     * 
     * @param objecyt $customerObject
     * @param array $customerPostArray
     * @return Object
     */
    public function createAndUpdate($customerPostArray) {

        $isSecret = 0;
        if ($customerPostArray['id']) {
            $customerObject = Customer::model()->findByPk($customerPostArray['id']);
            $customerObject->updated_at = new CDbExpression('NOW()');
        } else {
            $customerObject = new Customer();
            $customerObject->added_at = new CDbExpression('NOW()');
        }
        if (isset($customerPostArray['is_secret'])) {
            $isSecret = $customerPostArray['is_secret'];
        }
        if (isset($customerPostArray['country_id'])) {
            $customerObject->country_id = $customerPostArray['country_id'];
        }
        if (isset($customerPostArray['password'])) {
            $customerObject->password = md5($customerPostArray['password']);
        }
        if (isset($customerPostArray['first_name'])) {
            $customerObject->first_name = $customerPostArray['first_name'];
        }
        if (isset($customerPostArray['last_name'])) {
            $customerObject->last_name = $customerPostArray['last_name'];
        }
        if (isset($customerPostArray['email_address'])) {
            $customerObject->email_address = $customerPostArray['email_address'];
        }
        if (isset($customerPostArray['telephone'])) {
            $customerObject->telephone = $customerPostArray['telephone'];
        }
        if (isset($customerPostArray['input_verification_code'])) {
            $customerObject->auth_code = $customerPostArray['input_verification_code'];
        }

        $customerObject->origin_id = 1; //TODO: Need to confirm with team
        $customerObject->is_subscribed = $isSecret;
        $customerObject->status = 1; //TODO: need to verify with team

        return $customerObject->save();
    }

    /**
     * is email existed
     */
    public function isEmailExisted() {
        
    }

    /**
     * is phone existed
     */
    public function isPhoneExisted() {
        
    }
    
    public static function customerData($criteria)
    {
    	return $dataProvider=new CActiveDataProvider('Customer', array(
    			'criteria'=>$criteria,
    	));
    }
}
