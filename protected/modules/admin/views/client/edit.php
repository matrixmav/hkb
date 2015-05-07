<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	'Edit',
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);
if(isset($_REQUEST['clientId'])){
    $clientId = $_REQUEST['clientId'];
} else {
    echo "Invalid Client";exit;
}
?>

<div class="row form-group">
    <div class="col-md-12">
        <?php echo CHtml::link(Yii::t('translation', 'Edit Client') . ' <i class=""></i>', '/admin/client/edit?clientId=' . $clientId, array("class" => "btn btn-success")); ?>
        <?php echo CHtml::link(Yii::t('translation', 'View Invoice') . ' <i class=""></i>', '/admin/ClientInvoice?clientId=' . $clientId, array("class" => "btn btn-success")); ?>
        <?php echo CHtml::link(Yii::t('translation', 'Payment') . ' <i class=""></i>', '/admin/ClientInvoice/payment?clientId=' . $clientId, array("class" => "btn btn-success")); ?>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>  
