<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	//public $telephone;
	/**
	 * Validates the username and password.
	 * This method should check the validity of the provided username
	 * and password in some way. In case of any authentication failure,
	 * set errorCode and errorMessage with appropriate values and return false.
	 * @param string username
	 * @param string password
	 * @return boolean whether the username and password are valid
	 */
	public function CustomerAuthenticate()
	{
		$record=Customer::model()->findByAttributes(array('telephone'=>$this->username));  // here I use Email as user name which comes from database
		if($record===null)
		{
			$this->_id='user Null';
			$this->errorCode=self::ERROR_TELEPHONE_INVALID;
		}
		else if(md5($this->password) != $record->password)            // here I compare db password with passwod field
		{
			$this->_id=$this->id;
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
				Yii::app()->user->setState('id',$record->id);
                $this->_id = $record->id;
                Yii::app()->user->setState('user_id',$record->id);
               	Yii::app()->user->setState('telephone', $record->telephone);
				Yii::app()->user->setState('email_address', $record->email_address);
                //last logedin 
                //User::model()->updateByPk($record->id,array('last_logged_at'=>date('Y-m-d H:i:s')));
        		
                //wp Login
               
		}
		return !$this->errorCode;		
	}
        
	public function getId()
	{
		return $this->_id;
	}
        
    public function authenticate($access="")
	{
		if($access=="manager"){
			$record=AdminUser::model()->find('type="hotel" and email_address="'.$this->username.'"');  // here I use Email as user name which comes from database
		}else{
			$record=AdminUser::model()->find('type="dayuse" and email_address="'.$this->username.'" and status=1');  // here I use Email as user name which comes from database
		}
		if($record===null)
		{
			$this->_id='user Null';
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else if(md5($this->password) != $record->password)            // here I compare db password with passwod field
		{
			$this->_id=$this->username;
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->errorCode=self::ERROR_NONE;
			$this->_id=$this->username;
			Yii::app()->user->setState('role_id',1);//TODO: 1 admin role
			Yii::app()->user->setState('user_id',$record->id);
			Yii::app()->user->setState('username', $record->email_address);
			Yii::app()->user->setState('email', $this->username);
			Yii::app()->user->setState('type', $record->type);
			Yii::app()->user->setState('access', $access);
                        
                        if($access=='manager')
                        {
                            // Setting the hotel ids for the manager which all he/she has access
                            $HTcriteria=new CDbCriteria;
                            $HTcriteria->alias = 'ht';
                            $HTcriteria->with = array('hotelAccess'=>array('joinType'=>'INNER JOIN', 'condition'=>'hotelAccess.user_id='.$record->id));
                            $HTcriteria->condition='ht.status=1';

                            $AccHotels = Hotel::model()->findAll($HTcriteria);
                            $htIds = array();
                            foreach ($AccHotels as $AccHotel)
                                array_push ($htIds, $AccHotel->id);

                            Yii::app()->user->setState('AccHotels', $htIds);
                        }
		}
		return !$this->errorCode;		
	}

}