<?php 
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Price'
);
?>
<div class="pull-right margin-right15" style="margin-top:-52px;">
    <?php if(isset($_GET['id'])){
        $hotelObject = Hotel::model()->findByPk($_GET['id']);
    echo "Hotel Name : <b>" . $hotelObject->name . "</b>";
}?>
</div>

<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotelObject, 'access'=>$access, 'type' => $type)); ?>

<?php
/* @var $this RoomController */
/* @var $model Room --*/
$dayname= Yii::app()->params->room_dayname;
$monthname=Yii::app()->params->room_monthname;

//$year = date('Y');
$year = isset($_REQUEST['prenextyear'])?$_REQUEST['prenextyear']:date('Y');

$curdate=strtotime(date('Y-m-d'));

$hotel = Hotel::model()->findByPk($hotel_id);
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
		var val1 = $("#put_me_in").val();
		$(this).val(val1); 
	});
	
	$('.titleTd').click(function(e){
		var parentrow = $(this).parent("tr");
		var allnestedtds = parentrow.find("td");

		allnestedtds.each(function(){
			if($(this).hasClass("selected")){	
				$(this).find(":input").val($("#put_me_in").val());					
			}
		});
	});

	$('.headerTd').click(function(e){
		var selectedmonth = $(this).data("month");

			$('.calenderTable td[data-monthresult='+selectedmonth+'] > input.roompr').val($("#put_me_in").val());

	});
	
	$('.cal_header > td').click(function(e){
		if($(this).data("monthdata")){
			var result = $(this).data("monthdata").split('/');
			$('input[data-vertical='+result[1]+'-'+result[2]+']').val($("#put_me_in").val());
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
	
	$('.headerTd').mouseover(function(e){
		var selectedmonth = $(this).data("month");

			$('.calenderTable td[data-monthresult='+selectedmonth+']').addClass('highlightedgreen');

	});
   
	});
//-->
</script>
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="/metronic/custom/custom.css"/>
<link rel="stylesheet" type="text/css" href="/metronic/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
<!-- BEGIN PAGE LEVEL STYLES -->
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo "Update '".$hotel->name."' : Room Price";?>
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
	<form class="form-horizontal" role="form" id="form_tariff" action="/admin/room/stariff" method="post">
	<input type="hidden" name="form_type" value="1">
	<input type="hidden" name="prenextyear" value="<?php echo $year?>">

	<div style="display:none"><input type="hidden" value="<?php echo $hotel_id;?>" name="hotel_id" /></div>	
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
			<label class="control-label col-md-3">Choose WeekDays:<span class="required"> * </span></label>
			<div class="col-md-9">
			<?php
			$i=0; 
			foreach($dayname as $dy=>$dname):	
			$clname = ($i==0)? "pull-left" : "pull-left margin-left15";
			$i++;
			?>
				<span class="<?php echo $clname;?>"><?php echo $dname;?><br/><input type="checkbox" name="dy[<?php echo $dname;?>]" value="1"/></span>
			<?php 
			endforeach;
			?>
			</div>
		</div>
		<?php 
		foreach ($model as $ind=>$md):
			?>
			<div class="form-group">
				<label class="control-label col-md-3"><?php echo $md->name;?>:</label>
			<div class="col-md-3">
				<input data-validation="required" class="form-control dvalid" name="room[<?php echo $md->id;?>]" type="text" maxlength="5" /></div>
			</div>
			<?php 
		endforeach;			
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" name="sub" value="action" class="btn green">Submit</button>	
					<a class="btn default" href="/admin/room/tariff?id=<?php echo $hotel_id;?>&type=tariff">Cancel</a>			
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
	 <!-- class="full-length no-border" -->
	<form action="/admin/room/stariff" id="tariff_calendar" method="post">
	<table class="calenderTable">
	<tr class="full-length no-border"><td colspan="31" align="center"><select onchange="yearChange(this)" id="prenextyear" name="prenextyear">
		<?php $prenextyears=array(date("Y",strtotime("-1 year")),date('Y'),date("Y",strtotime("+1 year")));
			foreach($prenextyears as $prenextyear){
				$selected = ($prenextyear == $year)?'SELECTED':'';
				echo "<option $selected value='$prenextyear'>$prenextyear</option>";				
			}
		?>
		</select></td></tr>	
	<tr class="full-length no-border"><td colspan="31" align="center">Enter a Tariff: <input class="priceFilter dvalid" type="text" name="put_me_in" id="put_me_in" maxlength="5" value="0"></td></tr>	
	<input type="hidden" value="<?php echo $hotel_id;?>" name="hotel_id" />
	<input type="hidden" name="form_type" value="2">
	<?php 
	//$num_of_days = getDays($year);
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
				<td data-monthdata="<?php echo $date;?>" <?php echo $wclass;?>><span <?php echo $wend;?>><?php echo $d;?></span></td>
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
			$trClass = ($cn == $cn_rooms)? 'class="lastRow"' : '';				
			?>
			<tr <?php echo $trClass;?>>
				<td class="titleTd"><?php echo $md->name;?></td>
				<?php 
				for($d=1;$d<=31;$d++):
					if($d<=$num_of_days[$m]):
						
						$date = $year.'-'.$m.'-'.$d;
						$verticalSel = $m.'-'.$d;
						$room_tariff = $tariff->find("`room_id`=".$md->id." and `tariff_date`='".$date."'");
						$tariff_value = ($room_tariff !=NULL)? $room_tariff->price : 0; 						
						
						$mdt =  strtotime($date);						
						if($curdate <= $mdt)
						{
							?>
							<td data-monthresult="<?php echo date('n',strtotime($month));?>" class="selected dvalid"><input data-vertical="<?php echo $verticalSel;?>" class="roompr" type="text" id="room[<?php echo $md->id?>][<?php echo $date;?>]" name="room[<?php echo $md->id?>][<?php echo $date;?>]" maxlength="5" value="<?php echo floor($tariff_value);?>"></td>
							<?php 
						}
						else 
						{
							?>
							<td><?php echo floor($tariff_value);?></td>
							<?php 
						}
					?>
						
					<?php
					else:
						?>
						<td class="blank-cell">&nbsp;</td>
						<?php 
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
	<script src="/metronic/custom/form-validation-tariff.js?ver=<?php echo strtotime("now");?>"></script>
	<!-- END PAGE LEVEL STYLES -->
	
	<script>
	jQuery(document).ready(function() {   
		 FormValidation.init();
	 });
	</script>	