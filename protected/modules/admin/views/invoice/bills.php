<?php 
$this->breadcrumbs=array('Invoices');
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/invoice.js?ver=<?php echo strtotime("now");?>"></script> 
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/select2/select2-metronic.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="/metronic/assets/scripts/custom/components-dropdowns.js"></script>
<script type="text/javascript" src="/metronic/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<?php $hotelObject = Hotel::model()->findByPk($hotel_id); ?>
<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotelObject, 'access'=>$access, 'type' => $type)); ?>

<style>
.invoiceBrief{list-style-type:none;padding: 0;}
.invoiceBrief li label,.invoiceBrief li select,button{display: inline-block;}
</style>
<div class="row form-group margin-topDefault">
	<div style="border: 1px solid #000; margin-left: 15px; padding:15px 0;min-height: 100px; width: 97%;">
	<form action="/admin/invoice/bills?id=<?php echo $hotel_id?>&type=bills" method="post" name="InvoiceFilter">
		<ul class="invoiceBrief">
			<li>
				<label class="col-md-2">Client / Hotel / Bills : </label>
				<label><?php echo Hotel::getHotelName($hotel_id)?></label>
			</li>
			<li>
			<label class="col-md-2">Billing Period: </label>
				<select name="Invoice[year]" class="form-control input-small select2me">
					<!--<option value="0">All</option>-->
					<?php 
					//for($i=date("Y",strtotime("-5 year"));$i<=date("Y");$i++){
                                        for($i=Yii::app()->params->daystay_start_year;$i<=date("Y");$i++){
						$selected = ($i==$user_year)?"selected='selected'":"";
						echo "<option $selected value='$i'>$i</option>";
					}?>
				</select>
				<select name="Invoice[month]" class="form-control input-small select2me">
                                <option value="0">All</option>
				<?php 
				$months = Yii::app()->params->months;
				foreach($months as $key=>$month){
                                    $selected = ($key==$user_month)?"selected='selected'":"";
                                    echo "<option $selected value='$key'>$month</option>";
				}
				?>
				</select>
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>	
			</li>
		</ul>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$dataProvider,
	'enableSorting'=>'true',
	'ajaxUpdate'=>true,
	'summaryText'=>'Showing {start} to {end} of {count} entries',
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
		array(
                    'name'=>'inv_no',
                    'header'=>'<span style="white-space: nowrap;">Bill No &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->inv_no',
		),
		array(
                    'name'=>'inv_date',
                    'header'=>'<span style="white-space: nowrap;">Date &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>array($this, 'getDateFormate'),
		),
		array(
                    'name'=>'hotel_id',
                    'header'=>'<span style="white-space: nowrap;">Client &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'isset($data->hotel->name)?$data->hotel->name:""',
		),
		array(
                    'name'=>'account_no',
                    'header'=>'<span style="white-space: nowrap;">Client No &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'isset($data->hotelAdministratives->account_no)?$data->hotelAdministratives->account_no:""',
		),
		array(
                    'name'=>'inv_label',
                    'header'=>'<span style="white-space: nowrap;">Label &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->inv_label',
		),
		array(
                    'name'=>'hotel_inv',
                    'header'=>'<span style="white-space: nowrap;">HT &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->hotel_inv',
                    'footer'=> Invoice::model()->getTotal($model, 'hotel_inv'),
		),
		array(
                    'name'=>'vat_amt',
                    'header'=>'<span style="white-space: nowrap;">VAT &nbsp; &nbsp; &nbsp;</span>',
                    'value'=>'$data->vat_amt',
                    'footer'=> Invoice::model()->getTotal($model, 'vat_amt'),
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
		array(
                    'name'=>'',
                    'value'=>array($this, 'getInvoiceedit'),				
		),
	),
)); ?>
            </div>
	</div>
	
<script>
$('[data-toggle="popover"]').popover({
    trigger: 'click'
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
         if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
$(function() {
	$( "#datepickerInvoice" ).datepicker();
});
</script>