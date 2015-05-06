<?php 
$this->breadcrumbs=array(
		'Origines'
);
?>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model)); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link(Yii::t('translation','Add').' <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>
<h4><?php echo Yii::t('translation','Origines')?></h4>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'origin-portal',
	'action' => Yii::app()->createUrl('admin/origin/index'),  //<- your form action here
	'enableAjaxValidation'=>false,
)); ?>
<div class="portlet-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th></th>
			<?php 
			foreach($portals as $portal){
				echo "<th>".$portal['name']."</th>";
			}?>
			<th>Status</th>
			<th>Action</th>
		</tr>
		</thead>								
		<tbody>
		<?php 

		foreach($origins as $origin){
			echo "<tr><td>".$origin['name']."</td>";
			foreach($portals as $portal){
				$selected = '';
				if(array_key_exists($origin['id'], $originPort)){
					$tempArry  = $originPort[$origin['id']];
					if(in_array($portal['id'], $tempArry)){
						$selected = 'checked="checked"';
					}
				
				}
				$originId = $origin['id'];
				
				echo "<td><input type='checkbox' name='Origine_Portal[".$portal['id']."][]' value='".$origin['id']."' $selected></td>";
			}
			$status= ($origin['status']==1)?'Active':'Inactive';
			echo "<td>".$status."</td>";
			echo '<td width="23%" class="button-column"><a href="/admin/origin/update?id='.$originId.'" title="Edit" class="btn purple fa fa-edit margin-right15">'.Yii::t('translation','Edit').'</a><a href="/admin/origin/delete?id='.$originId.'" title="Delete" class="fa fa-success btn default black delete">'.Yii::t('translation','Change Status').'</a></td>';
			
			echo "</tr>";
		}
		
		?>
		</tbody>
		</table>
	</div>
	
<div class="row">
	<div class="col-md-6">
			<?php echo CHtml::submitButton('Record',array('class'=>'btn green')); ?>				
	</div>
</div>
</div>
<?php $this->endWidget(); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-markdown/lib/markdown.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL STYLES -->
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>
<script src="/metronic/custom/form-validation-origin-portal.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript">
jQuery(document).ready(function() {   
   // initiate layout and plugins
   ComponentsDropdowns.init();
   FormValidation.init();
});
</script>