<?php
$curController = @Yii::app ()->controller->id;
$curAction = @Yii::app ()->getController ()->getAction ()->controller->action->id;
$this->breadcrumbs = array (
		'Hotel' => array (
				'/admin/hotel' 
		),
		'Texts' 
);
require_once Yii::getPathOfAlias ( 'application.modules.admin.views.layouts' ) . '/formassets.php';
?>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>

<div class="portlet box green">

	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo $model->name;?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>

	<div class="portlet-body">
		<!--   form tag starts here -->
	<?php
	
$id = isset ( $model->id ) ? $model->id : null;
	$form = $this->beginWidget ( 'CActiveForm', array (
			'action' => Yii::app ()->createUrl ( $this->route ) . "?id=$id&type=textes",
			'id' => "form_hotel_text",
			'method' => 'post',
			'htmlOptions' => array (
					'class' => 'form-horizontal',
					'role' => 'form',
					'data-model_id' => $id 
			) 
	) );
	?>
		<ul class="nav nav-tabs">
		<?php
		$criteria = new CDbCriteria ();
		$criteria->addCondition ( "status=1" );
		$portals = Portal::getAllPortal ( $criteria );
		$i = 0;
		foreach ( $portals as $portal ) {
			?>
			<li <?php echo ($i==0)?"class='active'":""?>><a
				href="#tab_<?php echo $portal->id?>" data-toggle="tab">
					 <?php echo $portal->name?>
				</a></li>
		<?php $i++; }?>
		</ul>
		<!-- Tabs Content Starts here -->
		<div class="tab-content form-group">
			<?php
			$criteria = new CDbCriteria ();
			$criteria->addCondition ( "status=1" );
			$portals = Portal::getAllPortal ( $criteria );
			$p = 0;
			foreach ( $portals as $portal ) {
				?>		
			<div class="tab-pane fade <?php echo ($p==0)?"active in":""?>"
				id="tab_<?php echo $portal->id?>">
				<?php
				$contentTypes = Yii::app ()->params->hotelContentType;
				foreach ( $contentTypes as $contentType ) {
					?>
					<!-- Row Start Here -->
				<div class="row form-inline" style="margin-top:4%;">
					<div class="col-md-2" style="padding-left: 5%">
						<label><?php echo $contentType;?></label>
					</div>
					
								<?php
					$languages = Language::getAllLanguage ();
					foreach ( $languages as $language ) {
						$criteria = new CDbCriteria ();
						$criteria->addCondition ( "portal_id=" . $portal->id );
						$criteria->addCondition ( "hotel_id=" . $model->id );
						$criteria->addCondition ( "language_id=" . $language->id );
						$criteria->addCondition ( "type='" . strtolower ( $contentType ) . "'" );
						$contentModel = HotelContent::model ()->find ( $criteria );
						?>
								<div class="col-md-1">
						<label><?php echo $language->code; ?><span class="required"> * </span></label></div>
						
						<div class="col-md-9">
							<textarea id="HotelContent_content_<?php echo $portal->id."_".strtolower($contentType)."_".$language->id?>"
								name="HotelContent[<?php echo $portal->id?>][<?php echo strtolower($contentType)?>][<?php echo $language->id?>]"
								class="editor form-control" rows="6" style="width:523px"><?php echo isset($contentModel->content)?$contentModel->content:"";?></textarea>
						</div>
					
								<?php }?>

							
				</div>
				<!-- Row Ends Here -->
				
				<?php }?>
			</div>			
			<?php $p++; }?>			

		</div>
		<!-- Tabs Content finish here -->
		<div class="row">
				<div class="col-md-12">
				<div class="col-md-3"></div>
					<div class="col-md-9" style="margin-left:-15px;">
						<button type="submit" class="btn green">Submit</button>
						<a class="btn default" href="/admin/hotel/">Cancel</a>
					</div>
				</div>
				<div class="col-md-6"></div>
			</div>
		<?php $this->endWidget(); ?>
		<!--   form tag Ends here -->
	</div>
</div>
<!--  <script type="text/javascript" src="/metronic/assets/plugins/ckeditor/ckeditor.js"></script>-->
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="/metronic/custom/form-validation-hoteltextes.js?ver=<?php echo strtotime("now");?>"></script>
<script src="/metronic/assets/scripts/custom/components-editors.js"></script>
<script>
jQuery(document).ready(function() {       
  ComponentsEditors.init();
  $('.editor').wysihtml5({
	    "font-styles": true, 
	    "emphasis": true, 
	    "lists": true,
	    "html": false,
	    "link": false, 
	    "image": false
	});
});   
</script>
