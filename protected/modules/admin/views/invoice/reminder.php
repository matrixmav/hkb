<?php
/* @var $this InvoiceController */
/* @var $model Invoice */

$this->breadcrumbs = array(
    'Invoices' => array('index'),
    'Reminder',
);

$this->menu = array(
    array('label' => 'List Invoice', 'url' => array('index')),
    array('label' => 'Manage Invoice', 'url' => array('admin')),
);
?>

<div class="row">
	<div class="col-md-12">
            <form id="sendRemainderFrm" name="sendRemainderFrm" method="post" action=""/>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$nonBlockedInvoiceListDataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
//	'summaryText'=>'Showing {start} to {end} of {count} entries',
//	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'pager'=>array(
		'header'=>false,
		'firstPageLabel' => "<<",
		'prevPageLabel' => "<",
		'nextPageLabel' => ">",
		'lastPageLabel' => ">>",
	),	
	'columns'=>array(
                array(
                    'header'=>'<input class="headerAllCheck" type="checkbox"/>',
                    'value'=>'CHtml::checkBox("cid[]",null,array("value"=>$data->id,"class"=>"rowCheckbox"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('width'=>5),
		),
		array(
                    'name'=>'inv_no',
                    'header'=>'<span style="white-space: nowrap;">Rese No. &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->inv_no',
		),
		array(
                    'name'=>'hotel_id',
                    'header'=>'<span style="white-space: nowrap;">Client &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'isset($data->hotel->name)?$data->hotel->name:""',
		),
                array(
                    'name'=>'inv_date',
                    'header'=>'<span style="white-space: nowrap;">Date &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getDateFormate'),
		),
		array(
                    'name'=>'inv_due_date',
                    'header'=>'<span style="white-space: nowrap;">Limit &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getInvDueDate'),
		),
		array(
                    'name'=>'inv_date',
                    'header'=>'<span style="white-space: nowrap;">Reminded &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getDateFormate'),
		),
		array(
                    'name'=>'reminder_nos',
                    'header'=>'<span style="white-space: nowrap;">Rem Count&nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->reminder_nos',
		),
		array(
                    'name'=>'total_inv',
                    'header'=>'<span style="white-space: nowrap;">Total Invoice &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->total_inv',
                    'footer'=> Invoice::model()->getTotal($model, 'total_inv'),
		),
		array(
                    'name'=>'pending_inv',
                    'header'=>'<span style="white-space: nowrap;">Balance &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->pending_inv',
                    'footer'=> Invoice::model()->getTotal($model, 'pending_inv'),
		),				
	),
)); ?>
            <input type="submit" id="send_reminder" name="send_reminder" value="Send Reminder"/>
            <input type="submit" id="block" name="block" value="Block"/>
        </form>
            </div>
	</div>
<!--<a href="#" id="send_reminder" name="send_reminder" >Send Reminder</a>
<a href="#" id="Block" name="Block" >Block</a>-->

<div class="row">
	<div class="col-md-12">
            <form id="sendRemainderFrm" name="sendRemainderFrm" method="post" action=""/>
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'blocked_invoice-grid',
	'dataProvider'=>$blockedInvoiceListDataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
//	'summaryText'=>'Showing {start} to {end} of {count} entries',
//	'template'=>'{items} {summary} {pager}',
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width',
	'pager'=>array(
		'header'=>false,
		'firstPageLabel' => "<<",
		'prevPageLabel' => "<",
		'nextPageLabel' => ">",
		'lastPageLabel' => ">>",
	),	
	'columns'=>array(
                array(
//                    'name'=>'iid',
//                    'header'=>'<input type="checkbox"/>',
//                    'value'=>'$data->id',
//                   'class'=>'CCheckBoxColumn',
                    'header'=>'<input class="headerAllCheck" type="checkbox"/>',
                    'value'=>'CHtml::checkBox("cid[]",null,array("value"=>$data->id,"class"=>"rowCheckbox"))',
                    'type'=>'raw',
                    'htmlOptions'=>array('width'=>5),
		),
		array(
                    'name'=>'inv_no',
                    'header'=>'<span style="white-space: nowrap;">Rese No. &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->inv_no',
		),
		array(
                    'name'=>'hotel_id',
                    'header'=>'<span style="white-space: nowrap;">Client &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'isset($data->hotel->name)?$data->hotel->name:""',
		),
                array(
                    'name'=>'inv_date',
                    'header'=>'<span style="white-space: nowrap;">Date &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getDateFormate'),
		),
		array(
                    'name'=>'inv_due_date',
                    'header'=>'<span style="white-space: nowrap;">Limit &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getInvDueDate'),
		),
		array(
                    'name'=>'inv_date',
                    'header'=>'<span style="white-space: nowrap;">Reminded &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getDateFormate'),
		),
		array(
                    'name'=>'reminder_nos',
                    'header'=>'<span style="white-space: nowrap;">Rem Count&nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->reminder_nos',
		),
		array(
                    'name'=>'total_inv',
                    'header'=>'<span style="white-space: nowrap;">Total Invoice &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->total_inv',
                    'footer'=> Invoice::model()->getTotal($modelBlock, 'total_inv'),
		),
		array(
                    'name'=>'pending_inv',
                    'header'=>'<span style="white-space: nowrap;">Balance &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->pending_inv',
                    'footer'=> Invoice::model()->getTotal($modelBlock, 'pending_inv'),
		),				
	),
)); ?>
            <input type="submit" id="unblock" name="unblock" value="Un Block"/>
        </form>
            </div>
	</div>

<script>
    // To check and uncheck all the checkboxes
    $('.headerAllCheck').click(function(){
	if($(this).is(':checked'))
	{
		var parent = $(this).closest(".grid-view");
		var inputWrap =  parent.find(".checker").children("span");
		inputWrap.addClass('checked');
		inputWrap.find("input:checkbox").prop('checked', true);
	}
	else{
		var parent = $(this).closest(".grid-view");
		var inputWrap =  parent.find(".checker").children("span");
		inputWrap.removeClass('checked');
		inputWrap.find("input:checkbox").prop('checked', false);

	}  
    });
    
    // conditional base checking 
    
 $('.rowCheckbox').click(function(){
	var parent = $(this).closest(".grid-view");
	if($(this).prop('checked')==true)
	{
		var chkbox_count = 1;
		var no_ofchkbox = parent.find('.rowCheckbox').length;

		$('tbody tr .checker>span', parent).each(function(){
		         if($(this).hasClass('checked')){
				chkbox_count++; 
			}
          
		});	 
		if(no_ofchkbox == chkbox_count) 
		{
                    	parent.find(".headerAllCheck").parent("span").addClass('checked');
                        parent.find(".headerAllCheck").prop('checked', true);		
		}    
	}
	else
	{       
		parent.find(".headerAllCheck").parent("span").removeClass('checked');
		parent.find(".headerAllCheck").prop('checked', false);		
	}	
});
    </script>