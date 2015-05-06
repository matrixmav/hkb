<?php
/* @var $this RoomController */
/* @var $model Room */

$rm_status=RoomStatusDef::model()->findAll("room_id=".$model->id);

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    <?php if(isset($_GET['hid'])){
        $hotelObject = Hotel::model()->findByPk($_GET['hid']);
    echo "Hotel Name : <b>" . $hotelObject->name . "</b>";
}?>
</div><?php 
$this->menu=array(
	array('label'=>'List Room', 'url'=>array('index')),
	array('label'=>'Create Room', 'url'=>array('create')),
	array('label'=>'View Room', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Room', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'rm_status'=>$rm_status,'model1'=>$model1,'mode'=>'edit')); ?>