<?php 
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Availability'
);
?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    <?php if(isset($_GET['id'])){
        $hotelObject = Hotel::model()->findByPk($_GET['id']);
    echo "Hotel Name : <b>" . $hotelObject->name . "</b>";
} ?>
</div>

<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotelObject, 'access'=>$access, 'type' => $type)); ?>

<?php
/* @var $this RoomController */
/* @var $model Room */
$dayname= Yii::app()->params->room_dayname;
$monthname=Yii::app()->params->room_monthname;
$room_status = Yii::app()->params->room_status;
$room_status_color = Yii::app()->params->room_status_color;

//$year = date('Y');
$year = isset($_REQUEST['prenextyear'])?$_REQUEST['prenextyear']:date('Y');

$curdate=strtotime(date('Y-m-d'));

$hotel = Hotel::model()->findByPk($hotel_id);
////$(this).css("background-color","blue");
//($(this).attr("id")+"[rmstat]").val(123);
?>
<script type="text/javascript">
<!--
function UpdateQueryString(key, value, url) {
    if (!url) url = window.location.href;
    var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
        hash;

    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            hash = url.split('#');
            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
    }
    else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?';
            hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}
function yearChange(sel){

	var currentUrl = window.location.href;
	var url = UpdateQueryString("prenextyear", sel.value, currentUrl)
    window.location.href = url;
	
}
$(function(){
	$('.roompr').click(function(e){
		
		var rval = $('input:radio[name=rmstat]:checked').val();
		var val1 = $("#put_me_in").val();			
		$(this).val(val1); 

		var cell_color = "lightgreen";
		
		if(rval == "closed")
			cell_color = "lightpink";
		else if(rval == "request")
			cell_color = "lightblue";
		else if(rval == "free_sale"){
			cell_color = "lightyellow";
			$(this).val("FS"); 
		}
		$(this).css("background-color",cell_color);
		//alert($(this).next().attr('id'));
		var hd =$(this).next().attr('id');
		$("#"+hd).val(rval);	
		
	});
	
	$('.titleTd').click(function(e){
		var parentrow = $(this).parent("tr");
		var allnestedtds = parentrow.find("td");

		allnestedtds.each(function(){
			if($(this).hasClass("selected"))
				{	
					$(this).find(":input").val($("#put_me_in").val());
					
					$(this).removeClass('lightgreen');
					$(this).removeClass('lightred');
					$(this).removeClass('lightblue');
					$(this).removeClass('lightyellow');
					
					var rval = $('input:radio[name=rmstat]:checked').val();
					var cell_color = "lightgreen";
					
					if(rval == "closed")
						cell_color = "lightpink";
					else if(rval == "request")
						cell_color = "lightblue";
					else if(rval == "free_sale"){
						cell_color = "lightyellow";
						$(this).find(":input").val("FS");
						
					}
					
					$(this).addClass(cell_color);
					var hd =$(this).find(":input").next().attr('id');
					$("#"+hd).val(rval);
				}
			});
		
		
	});
$('.headerTd').mouseover(function(e){

var selectedmonth = $(this).data("month");

	$('.calenderTable td[data-monthresult='+selectedmonth+']').addClass('highlightedgreen');

});

$('.headerTd').click(function(e){
	var selectedmonth = $(this).data("month");
	$('.calenderTable td[data-monthresult='+selectedmonth+'] > input.roompr').val($("#put_me_in").val());

	$('.calenderTable td[data-monthresult='+selectedmonth+']').removeClass('lightgreen');
	$('.calenderTable td[data-monthresult='+selectedmonth+']').removeClass('lightred');
	$('.calenderTable td[data-monthresult='+selectedmonth+']').removeClass('lightblue');
	$('.calenderTable td[data-monthresult='+selectedmonth+']').removeClass('lightyellow');
	
	var rval = $('input:radio[name=rmstat]:checked').val();
	var cell_color = "lightgreen";
	
	if(rval == "closed")
		cell_color = "lightpink";
	else if(rval == "request")
		cell_color = "lightblue";
	else if(rval == "free_sale"){
		cell_color = "lightyellow";
		$('.calenderTable td[data-monthresult='+selectedmonth+'] > input.roompr').val("FS");		
	}
	$('.calenderTable td[data-monthresult='+selectedmonth+']').addClass(cell_color);
	$('.calenderTable td[data-monthresult='+selectedmonth+'] > input.current_state').val(rval);
});
	
	$('.cal_header > td').click(function(e){
		if($(this).data("monthdata")){
			var result = $(this).data("monthdata").split('/');
			$('input[data-vertical='+result[1]+'-'+result[2]+']').val($("#put_me_in").val());
			$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().removeClass('lightgreen');
			$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().removeClass('lightred');
			$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().removeClass('lightblue');
			$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().removeClass('lightyellow');
			
			var rval = $('input:radio[name=rmstat]:checked').val();
			var cell_color = "lightgreen";
			
			if(rval == "closed")
				cell_color = "lightpink";
			else if(rval == "request")
				cell_color = "lightblue";
			else if(rval == "free_sale"){
				cell_color = "lightyellow";
				$('input[data-vertical='+result[1]+'-'+result[2]+']').val("FS");
			}
			
			$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().addClass(cell_color);
			$('input[data-vertical='+result[1]+'-'+result[2]+']').next().val(rval);
		}
	});
	
	 $('.dvalid').keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");	       
	        return false;
	    }
	   });

	$('select[name="room_status"]').change(function(){
		if($(this).val()=="free_sale"){
			$(".freesale").val("FS");
			$(".freesale").attr("disabled", "disabled"); 
		}else{
			$(".freesale").val("");
			$(".freesale").removeAttr("disabled"); 
		}
	});

	// on column mouseover
	$('.cal_header > td').not('.headerTd').mouseover(function(e){
		var result = $(this).data("monthdata").split('/');
		$('input[data-vertical='+result[1]+'-'+result[2]+']').parent().addClass('highlightedgreen');
		
	});
	$('.cal_header > td').mouseout(function(e){
		$('.calenderTable td').removeClass('highlightedgreen');		
	});


//on row mouse over
	$('.titleTd').mouseover(function(e){
		var parentrow = $(this).parent("tr");
		var allnestedtds = parentrow.find("td");

		allnestedtds.each(function(){
			if($(this).hasClass("selected"))
				{	
					$(this).addClass('highlightedgreen');
					
				}
			});		
	});
	
	$('.titleTd').mouseout(function(e){
		var parentrow = $(this).parent("tr");
		var allnestedtds = parentrow.find("td");

		allnestedtds.each(function(){
			if($(this).hasClass("selected"))
				{	
				$('.calenderTable td').removeClass('highlightedgreen');		
					
				}
			});		
	});
	
		   
	});
	
//-->
</script>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
<div class="portlet box green">
<div class="portlet-title">
	<div class="caption">
		<i class="fa fa-reorder"></i><?php echo "Update '".$hotel->name."' : Room Availability";?>
	</div>
	<div class="tools">
		<a href="javascript:;" class="collapse">
		</a>
	</div>
</div>

<div class="portlet-body form">
<?php 
if($rmcount!=0)
{
?>
<form class="form-horizontal" role="form" id="form_availability" action="/admin/room/savailability" method="post">
<input type="hidden" name="form_type" value="1">
<input type="hidden" name="prenextyear" value="<?php echo $year?>">

<div style="display:none">
<input type="hidden" value="<?php echo $hotel_id;?>" name="hotel_id" id="hotel_id"/>
<input type="hidden" value="<?php echo $rmstatus;?>" name="rmstatus" id="rmstatus"/>
<input type="hidden" name="form_type" value="1">
</div>	
<div class="form-body">
	<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		You have some form errors. Please check below.	</div>
	<div class="alert alert-success display-hide">
		<button class="close" data-close="alert"></button>
		Your form validation is successful!	</div>
									
	<div class="form-group">
		<label class="control-label col-md-3">Start Date (included):<span class="required"> * </span>
		</label>
		<div class="col-md-3">
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'name'=>'start_date',
					// additional javascript options for the date picker plugin
					'options'=>array(
							'showAnim'=>'fold',
							'minDate'=> 0,
							'dateFormat' => 'yy-mm-dd',
							
					),
					'htmlOptions'=>array(
							'class'=>'form-control'
					),
			));			
			?>	
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3">End date (inclusive):<span class="required"> * </span>
		</label>
		<div class="col-md-3">
			<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
					'name'=>'end_date',
					// additional javascript options for the date picker plugin
					'options'=>array(
							'showAnim'=>'fold',
							'minDate'=> 0,
							'dateFormat' => 'yy-mm-dd',
							
					),
					'htmlOptions'=>array(
							'class'=>'form-control'
					),
			));			
			?>		
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3">Choose Status:<span class="required"> * </span></label>
		<div class="col-md-3">
			<select id="room_status" name = "room_status" class="form-control select2me">
			<?php foreach ($room_status as $rky=>$rmstat): ?>
				<option value="<?php echo $rky;?>"><?php echo $rmstat;?></option>
			<?php endforeach;?>
				
			</select>
		</div>
	</div>
	<?php 
	foreach ($model as $ind=>$md):
		?>
		<div class="form-group">
			<label class="control-label col-md-3"><?php echo $md->name;?>:</label>
		<div class="col-md-3">
			<input data-validation="required" class="form-control dvalid freesale" name="room[<?php echo $md->id;?>]" type="text" maxlength="5" /></div>
		</div>
		<?php 
	endforeach;			
	?>
	<div class="row">
		<div class="col-md-6">
			<div class="col-md-offset-3 col-md-9">
				<button type="submit" name="sub" value="action" class="btn green">Submit</button>	
				<a class="btn default" href="/admin/room/availability?id=<?php echo $hotel_id;?>&type=availability">Cancel</a>			
			</div>
		</div>
		<div class="col-md-6">
		</div>
	</div>
	
</div>
</form>
<?php }
	else 
	{
		echo "<div class='form-body'>";
		echo "Please add a room first.";
		echo "</div>";
	}
	?>
	</div>
</div>	
<?php 
if($rmcount!=0)
{
?>
<form action="/admin/room/savailability" id="availability_calendar" method="post">
<input type="hidden" value="<?php echo $hotel_id;?>" name="hotel_id" id="hotel_id"/>
<input type="hidden" value="<?php echo $rmstatus;?>" name="rmstatus" id="rmstatus"/>
<input type="hidden" name="form_type" value="2">
<input type="hidden" value="" name="cellcolor" id="cellcolor"/>
	<table class="calenderTable">	
	<tr class="full-length no-border"><td colspan="31" align="center">	
	<div class="form-group">
		<div class="col-md-12">
		<div><select onchange="yearChange(this)" id="prenextyear" name="prenextyear">
		<?php $prenextyears=array(date("Y",strtotime("-1 year")),date('Y'),date("Y",strtotime("+1 year")));
			foreach($prenextyears as $prenextyear){
				$selected = ($prenextyear == $year)?'SELECTED':'';
				echo "<option $selected value='$prenextyear'>$prenextyear</option>";				
			}
		?>
		</select></div>
		Number of Bedrooms: <input class="priceFilter dvalid" type="text" name="put_me_in" id="put_me_in" maxlength="5" value="0">
			<div data-error-container="#form_2_membership_error" class="radio-list" style="display:inline-block;">
				<?php 
				foreach ($room_status as $rky=>$rmstat):
				$rchecked = ($rmstatus == $rky) ? "checked" : "";
				?>
				<label style="display: inline-block;" class="<?php echo $room_status_color[$rky];?>">
				<?php
				echo "<input type='radio' id='rmstat' name='rmstat' value='".$rky."' ".$rchecked." class='check_stat'/>".$rmstat." ";
				?></label>
				<?php 
				endforeach;
				?>				
			</div>
			<span for="Hotel[status]" class="help-block"></span>
		</div>
	</div>
	</td></tr>	
	<?php 
	$num_of_days = BaseClass::getDays($year);
	$m=0;
	$cn_rooms = count($model);
	
	foreach ($monthname as $ky=>$month):
	$m++;
	?>
		<tr class="cal_header">
			<td data-month="<?php echo date('n',strtotime($month));?>" class="headerTd"><b><?php echo $month." ".$year;?></b></td>
			<?php 
			for($d=1;$d<=31;$d++):
				if($d<=$num_of_days[$m]):
					
					$date = $year.'/'.$m.'/'.$d;
					$day = date('l', strtotime($date));
					$wend = ($day=="Saturday" || $day=="Sunday")? 'style="font-weight:bold"' : '';
					$wclass = ($day=="Saturday" || $day=="Sunday")? 'class="weekendHeader"' : '';
				?>
				<td data-monthdata="<?php echo $date;?>" <?php echo $wclass;?>><span style="display:block;" <?php echo $wend;?>><?php echo $d;?></span></td>
				<?php 
				else:
					?>
					<td>&nbsp;</td>
					<?php 
				endif;
			endfor; 
			?>
		</tr>
		<?php 
		$cn = 0;
				
		foreach ($model as $ind=>$md):
			$cn++;
			$trClass = ($cn == $cn_rooms)? 'lastRow' : '';
			//[200] => Array ( [1] => Array ( [2015-01-13] => 10-open
			//room-72-2015-1-15
			?>
			<tr class="selectRoomRow <?php echo $trClass;?>">
				<td class="titleTd"><?php echo $md->name;?></td>
				<?php 
				for($d=1;$d<=31;$d++):
					if($d<=$num_of_days[$m]):
						
						$date = $year.'-'.$m.'-'.$d;
						$verticalSel = $m.'-'.$d;
						$dname = date('D', strtotime($date));
						$dtname = date('Y-m-d', strtotime($date));
						
						$mdt =  strtotime($date);
						if(isset($avdetail[$md->id][$m]))
						{
							if(isset($avdetail[$md->id][$m][$dtname]))
							{ 
								$gTd = explode("-", $avdetail[$md->id][$m][$dtname]);
								if($curdate <= $mdt)
								{
									?>
									<td data-monthresult="<?php echo date('n',strtotime($month));?>" class="selected dvalid <?php echo $room_status_color[$gTd[1]];?>">
										<input class="roompr" data-vertical="<?php echo $verticalSel;?>" type="text" id="room[<?php echo $md->id?>][<?php echo $date;?>]" name="room[<?php echo $md->id?>][<?php echo $date;?>]" maxlength="5" value="<?php echo ($gTd[1]=="free_sale")?"FS":$gTd[0];?>">
										<input class="current_state" type="hidden" id="<?php echo $md->id."-".$date;?>" name="<?php echo $md->id."-".$date;?>" value="<?php echo $gTd[1];?>">
										<input class="old_value" type="hidden" id="<?php echo "pval-".$md->id."-".$date;?>" name="<?php echo "pval-".$md->id."-".$date;?>" value="<?php echo $gTd[0];?>">
									</td>
									<?php 
								}
								else 
								{
									?>
									<td class="<?php echo $room_status_color[$gTd[1]];?>"><i><?php echo $gTd[0];?></i></td>
									<?php
								}
							}
							else 
							{ 
								if($curdate <= $mdt)
								{
									?>
									<td data-monthresult="<?php echo date('n',strtotime($month));?>" class="selected dvalid lightgreen">
										<input class="roompr" data-vertical="<?php echo $verticalSel;?>" type="text" id="room[<?php echo $md->id?>][<?php echo $date;?>]" name="room[<?php echo $md->id?>][<?php echo $date;?>]" maxlength="5" value="0">
										<input class="current_state" type="hidden" id="<?php echo $md->id."-".$date;?>" name="<?php echo $md->id."-".$date;?>" value="open">
										<input class="old_value" type="hidden" id="<?php echo "pval-".$md->id."-".$date;?>" name="<?php echo "pval-".$md->id."-".$date;?>" value="0">
									</td>
									<?php
								}
								else 
								{
									echo '<td class="blank-cell">&nbsp;</td>';
								}
							}
						}
						else
						{ 
							if($curdate <= $mdt)
							{
								?>
								<td data-monthresult="<?php echo date('n',strtotime($month));?>" class="selected dvalid lightgreen">
									<input class="roompr" data-vertical="<?php echo $verticalSel;?>" type="text" id="room[<?php echo $md->id?>][<?php echo $date;?>]" name="room[<?php echo $md->id?>][<?php echo $date;?>]" maxlength="5" value="0">
									<input class="current_state" type="hidden" id="<?php echo $md->id."-".$date;?>" name="<?php echo $md->id."-".$date;?>" value="open">
									<input class="old_value" type="hidden" id="<?php echo "pval-".$md->id."-".$date;?>" name="<?php echo "pval-".$md->id."-".$date;?>" value="0">
								</td>
								<?php
							}
							else 
							{
								echo '<td class="blank-cell">&nbsp;</td>';
							}
						}
					?>
					<?php 
					else:
						echo '<td class="blank-cell">&nbsp;</td>';
					endif;
				endfor; 
				?>
			</tr>
			<?php 
		endforeach;			
		?>	
		<tr class="full-length no-border"><td colspan="31" align="center"><input type="submit" id="sub<?php echo $m;?>" name="save" value="Save" class="btn green"></td></tr>	
		<?php
	endforeach;
	?>
	</table>
	</form>
<?php 
}
	?>
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="/metronic/assets/plugins/jquery-validation/dist/jquery.validate.min.js?ver=<?php echo strtotime("now");?>"></script>
	<script src="/metronic/custom/form-validation-availability.js?ver=<?php echo strtotime("now");?>"></script>
	<!-- END PAGE LEVEL STYLES -->
	
	<script>
	jQuery(document).ready(function() {   
		 FormValidation.init();
	 });
	</script>