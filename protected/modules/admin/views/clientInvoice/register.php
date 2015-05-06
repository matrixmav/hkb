<?php
$this->breadcrumbs=array(
	'ClientInvoice'=>array('index'),
	'Register',
);
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<form class="form-horizontal" role="form" name="search" id="form_search_reservation" action="/admin/ClientInvoice/register/" method="post">	

<div class="portlet box green">

	<div class="portlet-title">
		<div class="caption">ClientInvline : Register
		</div>
	</div>
	<div class="portlet-body form"><div class="form-body">
	<div class="form-group">
		<label class="control-label col-md-1">Client</label>
		<div class="col-md-7">
		<select name="client" class="form-control select2me">						
				<?php 
				echo '<option selected> </option>';
				foreach($clientObj as $client) {			
					echo '<option>'.$client->name.'</option>';
				}
				?>
					</select>
			<span for="Search[portal]" class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-1">Date</label>
		<div class="col-md-7">
			<input type="text" id="search_date" name="Search[date]" class="form-control"/>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-1">Label</label>
		<div class="col-md-7">
			<input type="text" id="label" name="label" class="form-control"/>
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
				<label class="control-label col-md-1 txtLeft">%TVA</label>
				<div class="actions">
			        <button class="clone_1 btn btn-success">ADD</button> 			        
			    </div>	
</div>
	<div id='repeatFields_1'>
		<div class="form-group addedfields" id='repeatFieldsRepeat'>		
				<div class="col-md-1 pull-left" style="width:1%;"></div>			
				<div class="col-md-5 pull-left">
					<input type="text" id="lines" name="lines" class="form-control"/>
				</div>				
				<div class="col-md-1 pull-left">
					<input type="text" id="puht" name="puht" class="form-control"/>
				</div>				
				<div class="col-md-1 pull-left">
					<input type="text" id="qte" name="qte" class="form-control"/>
				</div>				
				<div class="col-md-1 pull-left">
					<input type="text" id="tva" name="tva" class="form-control"/>
				</div>
				<div class="actions">			        
			        <button class="remove_1 btn btn-success">REMOVE</button>
			    </div>
					
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-top:40px;">
			<label class="control-label col-md-1" style="width:1%;"></label>
			<button type="submit" class='btn btn-primary' name="yt0" value="register">Register</button>				
		</div>		
	</div>
	
</div>  
	</div>
</div>
  

  <!--div id="clonedInput1" class="clonedInput">
    <div>
        <label for="txtCategory" class="">Learning category <span class="requiredField">*</span></label>
        <select class="" name="txtCategory[]" id="category1">
            <option value="">Please select</option>
        </select>
    </div>
    <div>
        <label for="txtSubCategory" class="">Sub-category <span class="requiredField">*</span></label>
        <select class="" name="txtSubCategory[]" id="subcategory1">
            <option value="">Please select category</option>
        </select>
    </div>
    <div>
        <label for="txtSubSubCategory">Sub-sub-category <span class="requiredField">*</span></label>
        <select name="txtSubSubCategory[]" id="subsubcategory1">
            <option value="">Please select sub-category</option>
        </select>
    </div>
    <div class="actions">
        <button class="clone">Clone</button> 
        <button class="remove">Remove</button>
    </div>
</div-->
  
</form>

<script src="/metronic/custom/form-validation-adminuser.js?ver=<?php echo strtotime("now");?>"></script>
<script src="/metronic/custom/form-validation-reservation.js?ver=<?php echo strtotime("now");?>"></script>
<script>

</script>
<script type="text/javascript">
    var optionDropdownList = "";
jQuery(document).ready(function() {   
   // initiate layout and plugins
   $( "#search_date" ).datepicker({
	   dateFormat: "yy-mm-dd"
   });
   $("#addextra").click(function(){
        $("#repeatFields").clone().appendTo("#repeatFields_1");
    });

   ///
/*var regex = /^(.*)(\d)+$/i;
var cloneIndex = $(".clonedInput").length;

function clone(){
    $(this).parents(".clonedInput").clone()
        .appendTo("#repeatFields_1")
        .attr("id", "clonedInput" +  cloneIndex)
        .find("*")
        .each(function() {
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
            }
        })
        .on('click', 'button.clone', clone)
        .on('click', 'button.remove', remove);
    cloneIndex++;
}
function remove(){
    $(this).parents(".clonedInput").remove();
}
$("button.clone").on("click", clone);

$("button.remove").on("click", remove);*/

var regex = /^(.*)(\d)+$/i;
var cloneIndex = $("#repeatFields").length;

function clone(){
    $(this).parents("#repeatFields").next("#repeatFields_1").children("#repeatFieldsRepeat").clone()
        .appendTo("#repeatFields_1")
        .attr("id", "repeatFields" +  cloneIndex)
        .find("*")
        .each(function() {
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
            }
        })
        .on('click', 'button.clone', clone)
        .on('click', 'button.remove', remove);
    cloneIndex++;
}
function remove(){
    $(this).parents("#repeatFields").remove();
}
$("button.clone_1").on("click", clone);

$("button.remove_1").on("click", remove);


   ///
});
</script>