<?php 
$this->breadcrumbs=array(
		'Invoices'
);
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

<style>
.invoiceBrief{list-style-type:none;padding: 0;}
.invoiceBrief li label,.invoiceBrief li select,button{display: inline-block;}
</style>
<div class="row form-group margin-topDefault">
	<div style="border: 1px solid #000; margin-left: 15px; padding:15px 0;min-height: 100px; width: 97%;">
	<form action="/admin/invoice/hotelbills" method="post" name="InvoiceFilter">
		<ul class="invoiceBrief">
			<li>
                            <label class="col-md-2">Hotel / Invoice No. : <input type="text" id="invoice_search" name="invoice_search" class="form-control"/></label>
				<label><?php //echo Hotel::getHotelName($hotel_id)?></label>
			</li>
			<li>
			<label class="margin-topDefault" style="width:10%;" >Billing Period: </label>
				<select name="Invoice[year]" id="inv_year" class="form-control input-small select2me">
                                        <?php 
                                        for($i=Yii::app()->params->daystay_start_year;$i<=date("Y");$i++){
                                                $selected = ($i==$selectedYear)?"selected='selected'":"";
                                                echo "<option $selected value='$i'>$i</option>";
                                        }?>
				</select>
				<select name="Invoice[month]" id="inv_month" class="form-control input-small select2me">
				<option value="0">All</option>
				<?php 
				$months = YII::app()->params['months'];
				foreach($months as $key=>$month){ ?>
					<option value="<?php echo $key; ?>" <?php echo ($key == $selectedMonth)? "selected": ""; ?> ><?php echo $month; ?> </option>";
				<?php } ?>
				</select>
				<button type="submit" class="btn green"><?php echo Yii::t('translation','Submit');?></button>
                                <a  class="btn green" target="_blank"  name="download" onclick="generatecsv();">Export</a>
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
	'itemsCssClass'=>'table table-striped table-bordered table-hover table-full-width invoiceTable',
        'rowHtmlOptionsExpression' => 'array("id"=>$data->inv_no)',
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
                    'header'=>'<span style="white-space: nowrap;" >Bill No &nbsp; &nbsp; &nbsp;</span>',
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
                    'value'=>array($this,'getAllInvoiceLink'),				
		),
	),
)); ?>
            </div>
	</div>
	
<style>
    .invoiceTable td{position: relative;height: 52px;}
    .nestedGridpane{width: 1022px;display: block;border: 1px solid #dddddd;padding: 10px;position: absolute;z-index: 99999;background: #FFF0F0;top: 52px;left: 0;}
</style>
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
//href="/admin/invoice/createcsv"
function generatecsv()
{
    var yr = $("#inv_year").val();
    var mn = $("#inv_month").val();
    var stxt = $("#invoice_search").val();
    //alert("/admin/invoice/createcsv?month="+mn+"&year="+yr+"&stxt="+stxt);
    //window.location.href("/admin/invoice/createcsv?month="+mn+"&year="+yr+"&stxt="+stxt);
    window.open("/admin/invoice/createhotelbillcsv?month="+mn+"&year="+yr+"&stxt="+stxt);
}
function createNestedGrid(){
    var nestedPane = "<div class='nestedGridpane' style='display:none'>lokesh</div>";    
}

$('.invoiceTable td').on('click',function(){
    var parTRid = $(this).parent("tr").attr('id');
    var parTR = $(this).parent("tr");
    if(parTR.next('tr').hasClass('temprow')) {
        $('.temprow').remove();   
    } else if(parTR.attr('id')==null) {
        $('.temprow').remove();
    } else {
        $('.temprow').remove();
        $.ajax({
        type: "POST",
        url: "/admin/invoice/getpaymentinvoice",
        data: {'id': parTRid},
        dataType: "json",
        success: function (resutl) {
            if(resutl != "1"){
                parTR.after(JSON.stringify(resutl));
            } else { 
                parTR.val("");
            }
        }
    });
    }
});
</script>

