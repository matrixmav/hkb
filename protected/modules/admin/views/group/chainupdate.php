<?php
$this->breadcrumbs=array(
		'Groups'=>array('/admin/group'),
		'Group'
);
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<?php 
//echo "<pre>"; print_r($model);exit;
    $clieldGroupValue = '';
    $childId = '';
    $showText = 'Create';
    if(!empty($childObject)){
        $showText = 'Update';
        $childId = $childObject->id;
        $clieldGroupValue = $childObject->name;

    } ?>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($showText." Chain under '".$model->name."'");?> <?php echo ucwords("group");?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>

<div class="portlet-body form">
	<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?id=$model->id",
			'id'=>'form_sample_3_group',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form'
			)
		)); 
		?>	
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		<?php echo Yii::t('translation','You have some form errors. Please check below.');?>
	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		<?php echo Yii::t('translation','Your form validation is successful!');?>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3">
			<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
		</label>
		<div class="col-md-7">
                    
                    <input type="hidden" name="clieldId" id="clieldId" value="<?php echo $childId; ?>"/>
                    <input type="text" value="<?php echo $clieldGroupValue; ?>" maxlength="150" id="Group_name" name="Group[name]" class="form-control">
                    
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
				<a class="btn default" href="/admin/group/chainupdate?id=<?php echo $_GET['id']; ?>"><?php echo Yii::t('translation','Cancel');?></a>				
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
    <style>
        #chain_list ul{margin-top:50px;list-style-type: none;}        
        #chain_list ul li a{display:inline-block;}
    </style>
    <div class="row">
	<div class="col-md-12">
	<?php //echo "----".$model->status;?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'group-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>Yii::t('translation', 'Showing {start} to {end} of {count} entries'),
	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'pager'=>array(
		'header'=>false,
		'firstPageLabel' => "<<",
		'prevPageLabel' => "<",
		'nextPageLabel' => ">",
		'lastPageLabel' => ">>",
	),	
	'columns'=>array(
		//'idJob',
		array(
			'name'=>Yii::t('translation', 'Name'),
			'value'=>'$data->name',
		),
		array(
			'name'=>Yii::t('translation', 'Updated'),
			'value'=>'$data->updated_at',
		),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}{Delete}',
			'htmlOptions'=>array('width'=>'30%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>Yii::t('translation', 'Edit'),
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/group/chainupdate", array("id"=>$data->parent_id,"childId"=>$data->id))',
				),
				'Delete' => array(
					'label'=>Yii::t('translation', 'Delete'),
					'options'=>array('class'=>'fa fa-trash-o fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/group/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
	</div>
</div>
    
</div>
<?php $this->endWidget(); ?>
</div>
</div>
<script>
jQuery(document).ready(function() {   
	  $('#addbutton').click(function(e){
		     if($(".addedfields").length < 10){		    
		       $(".addedfields").append(
		    		   "<li style='margin-top:5px;'><input type='text' name='Group[name][]' class='form-control textbox'/>"+
					   "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a></li>"
		       );
		       e.preventDefault();
		     }
		     $(".removeBtn").on("click",function(e){
				   $(this).parent().remove();
				   e.preventDefault();
			   });
		});
	   $(".removeBtn").on("click",function(e){
		   $(this).parent().remove();
		   e.preventDefault();
	   });
		
	});
</script>