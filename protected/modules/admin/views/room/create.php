<?php
/* @var $this RoomController */
/* @var $model Room */

$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	'Create',
); ?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    <?php if(isset($_GET['hid'])){
        $hotelObject = Hotel::model()->findByPk($_GET['hid']);
    echo "Hotel Name : <b>" . $hotelObject->name . "</b>";
}?>
</div><?php 
$this->menu=array(
	array('label'=>'List Room', 'url'=>array('index')),
	array('label'=>'Manage Room', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'model1'=>$model1,'mode'=>'add')); ?>