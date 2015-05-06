<?php
/* @var $this HotelController */
/* @var $model Hotel */

$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    Hotel Name : <b><?php echo $model->name; ?></b>
</div>
<?php 
$this->menu=array(
	array('label'=>'List Hotel', 'url'=>array('index')),
	array('label'=>'Create Hotel', 'url'=>array('create')),
	array('label'=>'View Hotel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_hotel_menu', array('model'=>$model, 'access'=>$access, 'type' => $type)); ?>

<?php 
if($type=="details"){
	
	$this->renderPartial('_details', array('model'=>$model)); 
	
}elseif ($type=="photos") {
	
	$this->renderPartial('_photoList', array('model'=>$model,'photoPort'=>$photoPort));
	
}elseif ($type=="photoadd") {
	
	$this->renderPartial('_form', array('model'=>$model));
	
}elseif ($type=="textes") {
	
	$this->renderPartial('_texteslist', array('model'=>$model,'contentModel'=>$contentModel,'portal_id'=>$portal_id));
	
}elseif ($type=="textadd") {
	
	$this->renderPartial('_textes', array('model'=>$model,'contentModel'=>$contentModel));
	
}elseif ($type=="administratif") {
	
	$this->renderPartial('_administratif', array('adminModel'=>$adminModel,'model'=>$model));
	
}

?>