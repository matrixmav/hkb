<?php
$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	'Simple Name',
);
?>
<div class="row form-group">
	<div class="col-md-12">
<?php echo CHtml::beginForm(); ?>
<table class="table table-striped table-bordered table-hover table-full-width">
	<tr>
		<td><b>Account No</b></td>
		<td><b>Hotel</b></td>
		<td><b>Simple Name</b></td>
	</tr>
	<?php
        if($count!=NULL)
        {
        foreach($count as $val){ 
            $accountNo = $val->hotelAdministratives;
            $accNum = isset($accountNo['0']['account_no'])? $accountNo['0']['account_no'] : '';
        ?>
	<tr>
		<td><?php echo $accNum; ?></td>
		<td> <?php echo $val->name; ?> </td>
		<td><input type="text" class="form-control" name="Hotel[<?php echo $val->id;?>]" value="<?php echo $val->simple_name;?>"/></td>
	</tr>
<?php } 
        }?>
</table>
<?php echo CHtml::submitButton('Update',array('class' => 'submitClass btn btn-success', 'style' => 'width: 120px; border-radius: 10px;')); ?>
<?php echo CHtml::endForm(); ?>
</div>
</div>