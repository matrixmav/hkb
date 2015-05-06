<?php 
	$userid = isset(Yii::app()->session['userid'])? Yii::app()->session['userid'] : '';
    foreach($hoteldata as $hdel){ 
    	$this->renderPartial('_hotelWidget',array('hdel'=>$hdel, 'userid'=>$userid));
	} 
?>