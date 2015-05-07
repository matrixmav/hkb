<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>  
<script>
$( document ).ready(function() {
    getCountryCityList(2);//2: USA Country id
});
    </script>