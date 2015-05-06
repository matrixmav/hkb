<?php

/**
 * This is the model class for table "tbl_contact".
 *
 * The followings are the available columns in table 'tbl_contact':
 * @property integer $id
 * @property integer $portal_id
 * @property string $type
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $institute_name
 * @property string $position
 * @property string $hotel_website
 * @property string $email_address
 * @property string $telephone
 * @property string $message
 * @property string $resume
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TblPortal $portal
 */
class Contact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, title, first_name, last_name, institute_name, email_address, telephone, added_at, updated_at', 'required'),
			array('portal_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>7),
			array('title', 'length', 'max'=>3),
			array('first_name, last_name', 'length', 'max'=>75),
			array('institute_name, email_address', 'length', 'max'=>150),
			array('position, hotel_website, resume', 'length', 'max'=>100),
			array('telephone', 'length', 'max'=>15),
			array('message', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, portal_id, type, title, first_name, last_name, institute_name, position, hotel_website, email_address, telephone, message, resume, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'portal' => array(self::BELONGS_TO, 'Portal', 'portal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'portal_id' => 'Portal',
			'type' => 'Type',
			'title' => 'Title',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'institute_name' => 'Institute Name',
			'position' => 'Position',
			'hotel_website' => 'Hotel Website',
			'email_address' => 'Email Address',
			'telephone' => 'Telephone',
			'message' => 'Message',
			'resume' => 'Resume',
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
		$criteria->compare('portal_id',$this->portal_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('institute_name',$this->institute_name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('hotel_website',$this->hotel_website,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('resume',$this->resume,true);
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
	 * @return Contact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
