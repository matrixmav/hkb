<?php

/**
 * This is the model class for table "tbl_portal".
 *
 * The followings are the available columns in table 'tbl_portal':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $url
 * @property string $headtitle
 * @property string $contact_email
 * @property string $booking_email
 * @property string $telephone_std
 * @property integer $status
 * @property string $added_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property OriginPortal[] $originPortals
 * @property PortalContact[] $portalContacts
 */
class Portal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_portal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, slug, url, headtitle, contact_email, booking_email, telephone_std','required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name, slug, url, contact_email, booking_email', 'length', 'max'=>100),
			array('headtitle', 'length', 'max'=>120),
			array('telephone_std', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, slug, url, headtitle, contact_email, booking_email, telephone_std, status, added_at, updated_at', 'safe', 'on'=>'search'),
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
			'originPortals' => array(self::HAS_MANY, 'OriginPortal', 'portal_id'),
			'portalContacts' => array(self::HAS_MANY, 'PortalContact', 'portal_id'),
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
			'slug' => 'Slug',
			'url' => 'Url',
			'headtitle' => 'Headtitle',
			'contact_email' => 'Contact Email',
			'booking_email' => 'Booking Email',
			'telephone_std' => 'Telephone Std',
			'status' => 'Status',
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
		$pageSize = Yii::app()->params['defaultPageSize'];
		
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('headtitle',$this->headtitle,true);
		$criteria->compare('contact_email',$this->contact_email,true);
		$criteria->compare('booking_email',$this->booking_email,true);
		$criteria->compare('telephone_std',$this->telephone_std,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('added_at',$this->added_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array('pageSize' => $pageSize),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Portal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getAllPortal($criteria="") {
		return self::model ()->findAll($criteria);
	}
}
