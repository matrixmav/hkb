<?php

/**
 * This is the model class for table "tbl_admin_user".
 *
 * The followings are the available columns in table 'tbl_admin_user':
 * @property integer $id
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $password
 * @property string $type
 * @property integer $login_status
 * @property string $last_logged_in
 * @property string $last_logged_out
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblSectionAccess[] $tblSectionAccesses
 */
class AdminUser extends CActiveRecord
{
	public $errorCode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_admin_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, first_name, last_name, telephone, email_address, password, type', 'required','except'=>'hotelManager,changepassword'),
			array('email_address, password', 'required','on'=>'login'),
			array('password', 'required','on'=>'changepassword'),
			array('password', 'authenticate','on'=>'login'),
			array('title', 'length', 'max'=>30),
			array('telephone', 'length', 'max'=>20),					
			array('first_name, last_name', 'length', 'max'=>75),
			array('email_address, password', 'length', 'max'=>150),
			array('type', 'length', 'max'=>6),
			array('first_name, last_name, telephone, email_address', 'required','on'=>'hotelManager'),
			array('updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'update'),
			array('added_at,updated_at','default','value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, first_name, last_name, email_address, password, type,login_status,last_logged_in,last_logged_out,status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'sectionAccesses' => array(self::HAS_MANY, 'SectionAccess', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email_address' => 'Email Address',
			'telephone'=>'Telephone',
			'password' => 'Password',
			'type' => 'Type',
                        'login_status' => 'Login Status',
                        'last_logged_in' => 'Last Logged In',
                        'last_logged_out' => 'Last Logged Out',
                        'status' => 'Status',
                        'user_icon' => 'User Icon',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type,true);
                $criteria->compare('login_status',$this->login_status,true);
                $criteria->compare('last_logged_in',$this->last_logged_in,true);
                $criteria->compare('last_logged_out',$this->last_logged_out,true);
                $criteria->compare('status',$this->status,true);
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
	 * @return AdminUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function authenticate($attribute,$params)
	{
		$this->_identity=new AdminUser($this->email_address,$this->password);
		if(!$this->_identity->authenticate())
			$this->addError('password','Incorrect Email or password.');
	}
	public function getFullName()
	{
		return $this->first_name." ".$this->last_name;
	}
	
}
