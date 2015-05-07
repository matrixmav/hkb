<?php
$this->breadcrumbs = array(
    'Client Invoice' => array('index?clientId=1'),
    'Payment',
);
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts') . '/formassets.php';
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<form class="form-horizontal" role="form" name="search" id="form_search_reservation" action="/admin/ClientInvoice/payment/" method="post">	

    <div class="portlet box green">

        <div class="portlet-title">
            <div class="caption">Client Invoice : Payment
            </div>
        </div>
        <div class="portlet-body form"><div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-1">Client</label>
                    <div class="col-md-7">
                        <select name="client" class="form-control select2me" required>						
                            <?php
                            echo '<option selected> </option>';
                            foreach ($clientListObject as $client) {
                                echo '<option>' . $client->name . '</option>';
                            }
                            ?>
                        </select>
                        <span for="Search[portal]" class="help-block"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-1">Date</label>
                    <div class="col-md-7">
                        <input type="text" id="search_date" name="inv_date" class="form-control" required/>
                    </div>
                </div>

                <input type='hidden' name='clientId' id="clientId" value='<?php echo ($clientId) ? $clientId : ""; ?>'>
                <div class="form-group">
                    <label class="control-label col-md-1">Label</label>
                    <div class="col-md-7">
                        <input type="text" id="label" name="label" class="form-control" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-1"></label>
                    <div class="col-md-12" style="padding-left: 40px;font-size: 14px;font-weight: bold;margin-top: 50px;">		
                        Lines
                        <hr class="noMargin"/>	
                    </div>
                </div>
                <div class="form-group addedfields" id='repeatFields'>
                    <label class="control-label col-md-1 txtLeft" style="width:1%;"></label>
                    <label class="control-label col-md-5 txtLeft">Title</label>				
                    <label class="control-label col-md-1 txtLeft">PU HT</label>				
                    <label class="control-label col-md-1 txtLeft">QTE</label>				
                    <label class="control-label col-md-1 txtLeft">%VAT</label>
                    <div class="actions">
                        <a class="clone_1 btn btn-success">ADD</a> 			        
                    </div>	
                </div><?php $tvaField = Yii::app()->params;?>
                <div id='repeatFields_1'>
                    <div class="form-group addedfields" id='repeatFieldsRepeat'>		
                        <div class="col-md-1 pull-left" style="width:1%;"></div>			
                        <div class="col-md-5 pull-left">
                            <input type="text" id="lines" name="lines[]" class="form-control" required/>
                        </div>				
                        <div class="col-md-1 pull-left">
                            <input type="text" id="puht" name="puht[]" pattern="\d*" class="form-control"/>
                        </div>				
                        <div class="col-md-1 pull-left">
                            <input type="text" id="qte" name="qte[]" pattern="\d*" class="form-control"/>
                        </div>				
                        <div class="col-md-1 pull-left">
                            <input type="text" id="tva" name="tva[]" pattern="\d*" class="form-control" value='<?php echo $tvaField['clientInvoicePercentage'];?>' readonly/>
                        </div>
                        <!-- div class="actions">			        
                            <a class="remove_1 btn btn-success">REMOVE</a>
                        </div-->

                    </div>
                </div>
                <div id="repeatFieldMain">

                </div>
                <div class="row">
                    <div class="col-md-12" style="margin-top:40px;">
                        <label class="control-label col-md-1" style="width:1%;"></label>
                        <button type="submit" class='btn btn-primary' name="yt0" value="register">Payment</button>				
                    </div>		
                </div>

            </div>  
        </div>
    </div>



</form>

<script src="/metronic/custom/form-validation-adminuser.js?ver=<?php echo strtotime("now"); ?>"></script>
<script src="/metronic/custom/form-validation-reservation.js?ver=<?php echo strtotime("now"); ?>"></script>
<script>

</script>
<script type="text/javascript">
    var optionDropdownList = "";
    jQuery(document).ready(function () {
        // initiate layout and plugins
        $("#search_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#addextra").click(function () {
            $("#repeatFields").clone().appendTo("#repeatFields_1");
        });

        ///


        var regex = /^(.*)(\d)+$/i;
        var cloneIndex = $("#repeatFields").length;
        var cloneIndex = 1;
        function clone() {
            //alert("cool");
            // $("#repeatFields_1").append("<h1>Ram</h1>");
            //cloneIndex = 1;
            $("#repeatFields_1").append("<div id='repeatFields_2'><div class='form-group addedfields'  id='repeatFieldsRepeat'><div class='col-md-1 pull-left' style='width:1%;'></div><div class='col-md-5 pull-left'><input type='text' id='lines_cpy_" + cloneIndex + "' name='lines[]' class='form-control'/></div><div class='col-md-1 pull-left'><input type='text' id='puht_cpy_" + cloneIndex + "' name='puht[]' class='form-control'/></div><div class='col-md-1 pull-left'><input type='text' id='qte_cpy_" + cloneIndex + "' name='qte[]' class='form-control'/></div><div class='col-md-1 pull-left'><input type='text' id='tva_cpy_" + cloneIndex + "' name='tva[]' class='form-control' value='<?php echo $tvaField['clientInvoicePercentage'];?>' readonly /></div><div class='actions'><a class='remove_1 btn btn-success' onclick='removeit()'>REMOVE</a></div></div></div>");
            cloneIndex++;
        }
        function remove() {
            //alert('test');
            $(this).parents("#repeatFields_1").remove();
        }
        function getalert() {
            alert('hi');
        }
        $("a.clone_1").on("click", clone);

        $("a.remove_1").on("click", remove);

    });
function removeit(){
var x = document.getElementById('repeatFields_2');
x.parentNode.removeChild(x);
}
</script>