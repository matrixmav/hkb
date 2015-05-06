<?php 
	$userid = isset(Yii::app()->session['userid'])? Yii::app()->session['userid'] : 0;
	$hids = 0;
    foreach($hoteldata as $hdel){ 
    	
    	$this->renderPartial('_hotelWidget',array('hdel'=>$hdel, 'userid'=>$userid,'hids'=>$hids));
    	++$hids;
	} 
?>