<?php $this->breadcrumbs=array(
	'Hotel',
);
//http://www.yiiframework.com/wiki/410/create-custom-button-button-with-ajax-function-in-cgridview/
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<div class="row noMargin">
	<div class="col-md-12">
		<?php  $this->renderPartial('_search',array('model'=>$model,'access'=>$access)); ?>
	</div>
</div>
<?php if($access!="manager"){?>
<!--<div class="row">
	<div class="col-md-12">
		<div class="col-md-1">
			<div class="form-group">
				<?php echo CHtml::link('Add <i class="fa fa-plus"></i>', '/admin/'.  get_class($model) .'/create/type/details', array("class"=>"btn  green margin-right-20")); ?>
			</div>
		</div>
	</div>
</div>-->
<div class="row form-group">
<div class="col-md-12">
<a class="btn green <?php echo ($status==1 && !$search_result)? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel', array('type'=>1))?>">Active</a>
<a class="btn green <?php echo ($status==0 && !$search_result)? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel', array('type'=>0))?>">Inactive</a>
<a class="btn green <?php echo ($status==2 && !$search_result)? "active":""?>" href="<?php echo Yii::app()->createUrl('/admin/hotel', array('type'=>2))?>">Closed</a>
</div>
</div>
<?php }?>
<div class="row">
	<div class="col-md-12">
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hotel-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>'Showing {start} to {end} of {count} entries'.
    CHtml::dropDownList(
         'pageSize',
         $pageSize,
         Yii::app()->params['pageSizeOptions'],
         array('class'=>'change-pageSize')) .' rows per page',
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
			'name'=>'name',
                        'htmlOptions'=>array('width'=>'45%'),
			'header'=>'<span style="white-space: nowrap;">Name</span>',
			'value'=>'$data->name',
		),
		array(
			'name'=>'status',
                        'htmlOptions'=>array('width'=>'8%'),
			'header'=>'<span style="white-space: nowrap;">Status</span>',
                        'value'=>array($this,'getHotelStatus'),
			//'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Active\') : Yii::t(\'translation\', \'Inactive\')',
		),
		array(
			'name'=>'is_new',
                        'htmlOptions'=>array('width'=>'8%'),
			'header'=>'<span style="white-space: nowrap;">Is New</span>',					
			'value'=>'($data->is_new == 1) ? Yii::t(\'translation\', \'Yes\') : Yii::t(\'translation\', \'No\')',
		),
		array(
			'name'=>'is_feature',
                        'htmlOptions'=>array('width'=>'10%'),
			'header'=>'<span style="white-space: nowrap;">Featured</span>',					
			'value'=>'($data->is_feature == 1) ? Yii::t(\'translation\', \'Yes\') : Yii::t(\'translation\', \'No\')',
		),
		array(
			'name'=>'city.name',
                        'htmlOptions'=>array('width'=>'8%'),
			'header'=>'<span style="white-space: nowrap;">City</span>',
			'value'=>'$data->city->name',
		),
		//'city.name:text:City',
		array( 
			'class'=>'CButtonColumn',
			//'template'=>'{Edit}{Delete}',
                        'template'=>'{Edit}{Send}',
			'htmlOptions'=>array('width'=>'21%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple btn-sm fa fa-edit inlineBlock margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/hotel/update/type/details", array("id"=>$data->id))',
				),
                                'Send' => array(
					'label'=>'Send Email',
					'url'=>'Yii::app()->createUrl("admin/hotel/sendhotelbutton", array("id"=>$data->id,"type"=>$data->status))',
                                        'options' => array(
                                             'class'=>'btn btn-primary btn-sm fa fa-edit inlineBlock',
                                             'confirm'=>'It will send mail to the Hotel Manager',
                                             'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) {if(data==0) alert("Unable to send the email"); else $.fn.yiiGridView.update("hotel-grid")}'),
                                            ),
                                        'visible'=> '($data->status==0)?true:false;',
				),
                                /*'Delete' => array(
                                            'label'=>Yii::t('translation', 'Change Status'),
                                            'options'=>array('class'=>'fa fa-success btn default black delete'),
                                            'url'=>'Yii::app()->createUrl("admin/hotel/delete", array("id"=>$data->id))',
				),
                                'options' => array(
                                             'confirm'=>'It will send mail to the Hotel Manager',
                                              'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("hotel-grid")}')
                                            ),
                                */
			),
		),
	),
)); ?>
	</div>
</div>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript">
/*<![CDATA[*/
	function split( val ) {
		return val.split( /,\s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}
	function getActiveHotelType() {
		var Ahref = jQuery("div.form-group").find("a.active").attr("href");
		var lastChar = Ahref.substr(Ahref.length - 1);
		return lastChar;
	}
	    
    
jQuery(function($) {
	jQuery(document).on('click','#hotel-grid a.delete',function() {
		th = this;
		url = jQuery(this).attr('href');
		bootbox.confirm("Are you sure you want to change status", function(result) {
			if(result == true){
				var th = this,
				afterDelete = function(){};
				jQuery('#hotel-grid').yiiGridView('update', {
					type: 'POST',
					url: url,
					success: function(data) {
						jQuery('#hotel-grid').yiiGridView('update');
						afterDelete(th, true, data);
						showSucessMsg("Record status Changed", "Status Changed");
					},
					error: function(XHR) {
						return afterDelete(th, false, XHR);
					}
				});	   
			}   
		}); 
		return false;		   	
	});	
	
	$('.change-pageSize').live('change', function() {
	        $.fn.yiiGridView.update('hotel-grid',{ data:{ pageSize: $(this).val() }})
	});
		    
	$( ".searchCity" )
	   .bind( "keydown", function( event ) {
	   	if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
	   		event.preventDefault();
	   	}
	   })
	   .autocomplete({source: function( request, response ) {
	   	$.getJSON("/admin/search/hotellist", {
	   		term: extractLast( request.term ),
	   		hotelStatus : getActiveHotelType()
	   	}, response );
	   },
	   search: function() {
	   // custom minLength
	   	var term = extractLast( this.value );
	   	if ( term.length < 2 ) {
	   		return false;
	   	}
	   },
	   focus: function() {
	   	// prevent value inserted on focus
	   	return false;
	   },
	   select: function( event, ui ) {
	   	var terms = split( this.value );
	   	// remove the current input
	   	terms.pop();
	   	// add the selected item
	   	terms.push( ui.item.value );
	   	// add placeholder to get the comma-and-space at the end
	   	//terms.push( "" );
	   	//this.value = terms.join( ", " );
	   	this.value = terms;
	   	return false;
	   }
	   });
});
/*]]>*/
</script>