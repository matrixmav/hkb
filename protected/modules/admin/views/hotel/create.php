<?php
/* @var $this HotelController */
/* @var $model Hotel */

$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Hotel', 'url'=>array('index')),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
 
if($type=="details"){
	
	$this->renderPartial('_details', array('model'=>$model)); 
	
}elseif ($type=="administratif") {
	
	$this->renderPartial('_administratif', array('model'=>$model));
	
}elseif ($type=="textes") {
	
	$this->renderPartial('_textes', array('model'=>$model));
	
}
?>