<?php
/* @var $this SearchController */

$this->breadcrumbs=array(
	'Reservation',
);
foreach(Yii::app()->user->getFlashes() as $key => $message) {
	echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
}
Yii::app()->clientScript->registerScript(
		'myHideEffect',
		'$(".alert-danger").animate({opacity: 1.0}, 3000).fadeOut("slow");',
		CClientScript::POS_READY
);
?>
<style>
.addedfields{padding: 0;list-style-type: none;}
.addedfields li input, .addedfields li .removeBtn {display: inline-block;vertical-align: top;}
.addedfields li input.textbox{width: 85%;}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<div class="row">
<div class="col-md-12">
<h4>New Reservation</h4>
<hr style="margin:10px 0">
</div>
</div>
<div class="portlet-body form">
	<?php 
        $model = City::model();
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route),
			'id'=>'form_search_reservation',
			'method'=>'post',
			'htmlOptions'=>array(
			'class'=>'form-horizontal',
			'role'=>'form',
			'name'=>'search',
			)
		)); 
		?>	
<div class="form-body">
	<div class="form-group">
		<label class="control-label col-md-3">Portal
		<span class="required">*</span>
		</label>
		<div class="col-md-4">
		<select name="Search[portal]" class="form-control select2me">
			<?php 
			$portals = Portal::model()->findAll();
			foreach($portals as $portal){ ?>
				<option value="<?php echo $portal->id?>"><?php echo $portal->name?></option>
			<?php 	
			}					
			?>
		</select>
		<span for="Search[portal]" class="help-block"></span>
		</div>
	</div>
    <input type="hidden" name="selectedCityId" id="selectedCityId" value="0">
	<div class="form-group">
		<label class="control-label col-md-3">Destination<span class="required"> * </span></label>
		<div class="col-md-7">
                    <!--<input type="text" id="search_destination" class='form-control searchCity' name="Search[destination]">-->
                    <?php echo $form->textField($model, 'Search[destination]', array('id' => 'search_destination', "class" => "form-control searchCity", "data-noval" => "Entrez un nom de ville, de département, de restaurant ou un point d'intérêt",  'value'=>"Choose City", 
                        'onfocus'=>"this.value='';$(\"#selectedCityId\").val('');$(\"#neighbourhood\").hide();$(\"#neighbourhood .addedfields\").html(\"\");")); ?>
                     
		</div>
	</div>
	<div class="form-group" id="neighbourhood" style="display: none;">
		<label class="control-label col-md-3">Neighbourhood</label>
		<div class="col-md-7">
			<ul class="addedfields">
				
			</ul>
		</div>
	</div>	
	<div class="form-group">
		<label class="control-label col-md-3">Date<span class="required"> * </span></label>
		<div class="col-md-7">
			<input type="text" id="search_date" name="Search[date]" class="form-control"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-6 col-md-9">
				<button type="submit" class="btn green">Search</button>	
				<a class="btn default" href="/admin/reservation">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
<?php 


?>					

    
<?php $this->endWidget(); ?>
</div>	
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script src="/metronic/custom/form-validation-adminuser.js?ver=<?php echo strtotime("now");?>"></script>-->
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="/metronic/custom/form-validation-reservation.js?ver=<?php echo strtotime("now");?>"></script>
<script type="text/javascript">
    var optionDropdownList = "";
jQuery(document).ready(function() {  
    var dateToday = new Date();
   // initiate layout and plugins
   $( "#search_date" ).datepicker({
	   dateFormat: "yy-mm-dd",
           minDate: dateToday,
   });
   FormValidation.init();
   		function split( val ) {
	      return val.split( /,\s*/ );
	    }
	    function extractLast( term ) {
	      return split( term ).pop();
	    }
    /*$(".searchCity").change(function(){
        //alert('asdasd');
       $("#selectedCityId").val('');
    });*/
    $( ".searchCity" )
   .bind( "keydown", function( event ) {
   	if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
   		event.preventDefault();
   	}
   })
   .autocomplete({source: function( request, response ) {
   	$.getJSON("/admin/search/citylist", {
   		term: extractLast( request.term )
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
       return false;
   	// prevent value inserted on focus
   },
   select: function( event, ui ) {
        $("#selectedCityId").val(ui.item.id);        
        //$('.addedfields').html(ui.item.id);
        $("#neighbourhood .addedfields").html('');
        getDiv(ui.item.id);        
        //return false;
   }    
   });
  
    /*$('#search_destination').change(function(e) { 
               if($(".addedfields").length < 10){		    
                 $(".addedfields").append(
                        optionDropdownList 
                 );
                $("#neighbourhood").show();
                 e.preventDefault();
               }
               $(".removeBtn").on("click",function(e){
                             $(this).parent().remove();
                             e.preventDefault();
                     });
               autoComplete("textbox","/admin/hotel/hotellist");
          });*/
     $(".removeBtn").on("click",function(e){
             $(this).parent().remove();
             e.preventDefault();
     });
     //autoComplete("textbox","/admin/hotel/hotellist");
});

function getDiv(id){ 
    $.ajax({
        type: "POST",
        url: "/admin/search/getneighbourhood",
        data: {'id': id},
        dataType: "json",
        success: function (result) { 
            if(result){
                $("#neighbourhood").show();
                $(".addedfields").append(result);
            }else
            {
                $("#neighbourhood").hide();
            }
        }
    });
}

</script>