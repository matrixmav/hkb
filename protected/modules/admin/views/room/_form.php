<?php
$this->breadcrumbs=array(
		'Hotel'=>array('/admin/hotel'),
		'Rooms'=>array('/admin/room/index?type=room&hotel_id='.Yii::app()->session['hotel_id']),
		'Room'
); 
$type ="room";
$hotel_id =$_GET['hid'];
$hotel = Hotel::model()->findByPk($hotel_id);
?>

<?php $access = Yii::app()->user->getState('access'); ?>
<?php $this->renderPartial('/hotel/_hotel_menu', array('model'=>$hotel, 'access'=>$access, 'type' => $type)); ?>

<?php
if (isset($_GET['hid']))
{
	$hid = $_GET['hid'];
}
if (isset($_GET['id']))
{
	$room_id = $_GET['id'];
}
$dayname= Yii::app()->params->room_dayname;
$room_status = Yii::app()->params->room_status;
$curController = @Yii::app()->controller->id ;
$curAction =  @Yii::app()->getController()->getAction()->controller->action->id;
foreach ($room_status as $ky=>$rstat)
{
	//Construct the array for room status
	$$ky = array();	
}
foreach ($dayname as $dy=>$dname)
{
	//Construct the array for the day
	$$dname = array();
}

if(isset($rm_status))
{
	foreach ($rm_status as $rs=>$rvalue)
	{
		// Result will be $open[0] = "Sun";
		array_push($$rvalue['room_status'], $rvalue['dyname']);
		
		// Result will be $Sun[0] = 14;
		array_push($$rvalue['dyname'], $rvalue['room_no']);
	}
}
else 
	$rm_status = array();

require_once Yii::getPathOfAlias('application.modules.admin.views.layouts'). '/formassets.php';
?>
<script type="text/javascript">
<!--
$(function(){
	$room_status_no = 4;
	
	$('.daychk').click(function(e){

		$vname = $(this).attr('id');
		$sp = $vname.split('_');
		$cur_no = parseInt($sp[1]);
		$mno = $cur_no % 10;
		$max = ($room_status_no * 10) + $mno;
		$min = 10 + $mno;

	
		for($n=$cur_no+10;$n<=$max;$n=$n+10)
		{
			$st = "rno_"+$n;
			//$st2 = "uniform-rno_"+$n;
			
			if(this.checked)
			{
				$("#"+$st).attr("disabled", true);
				//$("#"+$st2+" span").addClass("disabled");
			}
			else
				$("#"+$st).attr("disabled", false);
		}
		for($n=$cur_no-10;$n>=$min;$n=$n-10)
		{
			$st = "rno_"+$n;
			if(this.checked)
				$("#"+$st).attr("disabled", true);
			else
				$("#"+$st).attr("disabled", false);
		}
		
	});

	$('.all_stat').click(function(e){	
		var parenttable = $(this).closest("table");		
		var parentrow = $(this).closest("tr");		
		var allnestedtds = parentrow.find("td");
		parenttable.find("td").find("span").removeClass("checked");
		
		allnestedtds.each(function(){			
			$(this).find("span").addClass("checked");
			$(this).find(":input").prop( "checked", true );
		});		
	});
		
	$('.dayall').click(function(e){
		$vname = $(this).attr('id');
		$sp = $vname.split('_');
		$cur_no = parseInt($sp[1]);

		$max = ($cur_no * 10) + 7;
		$min = ($cur_no * 10) + 1;

		for($a=1;$a<=$room_status_no;$a++)
		{
			$mn = (10 * $a) + 1;
			$mx = (10 * $a) + 7;
			
			for($n=$mn;$n<=$mx;$n=$n+1)
			{
				$st = "uniform-rno_"+$n;
				$("#"+$st+" span").removeClass("checked");
			}
		}

		for($n=$min;$n<=$max;$n=$n+1)
		{
			$st = "uniform-rno_"+$n;
			$("#"+$st+" span").addClass("checked");
		}
		
	});

	$('.dvalid').keypress(function (e) {
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
	        return false;
	    }
	   });

	$('.dvalid2').keyup(function (e){
	
		  var val = $(this).val();
		  val = val.replace(/[^\w]+/g, "");
		  <?php 
		  foreach ($dayname as $nm=>$dnn):
		  ?>
		  $('#room_no_<?php echo $dnn;?>').val(val);
		  <?php 
		  endforeach;
		  ?>
	});
	
});	
//-->
</script>

<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i><?php echo ucwords($curAction);?> <?php echo ucwords($curController)." for :"."'".$hotel->name."'";?>
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse">
			</a>
		</div>
	</div>
	<div class="portlet-body form">
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'action'=>Yii::app()->createUrl($this->route)."?id=$model->id",
			'id'=>'form_sample_3_room',
			'method'=>'get',
			'htmlOptions'=>array(
			  'class'=>'form-horizontal',
			  'role'=>'form'
			)
		)); 
		?>		
			<div class="form-body">
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div>
				<input type="hidden" value="<?php echo Yii::app()->session['hotel_id'];?>" name="Room[hotel_id]" />
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('name'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'name',array( 'class'=>'form-control')); ?>
					</div>
				</div>
		
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('category'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
					<?php echo $form->DropDownList( $model,'category',array('sun'=>"DayUse",'halfsun'=>'Late break','moon'=>'Night'),array("class"=>"form-control select2me",'id'=>'categoryc')); ?>
						<?php //echo $form->textField($model,'category',array( 'class'=>'form-control')); ?>
					</div>
				</div>
				<input type="hidden" name ="Room[room_status]" value="open" />
				<input type="hidden" name ="Room[quantity]" value="0" />
				<!-- <div class="form-group">
					<label class="control-label col-md-3">
						<?php //echo $model->getAttributeLabel('room_status'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
					<?php //echo ZHtml::enumDropDownList( $model,'room_status',array("class"=>"form-control select2me")); ?>
						<?php //echo $form->textField($model,'room_status',array( 'class'=>'form-control')); ?>
					</div>
				</div> -->
				
				<!-- <div class="form-group">
					<label class="control-label col-md-3">
						<?php //echo $model->getAttributeLabel('quantity'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php //echo $form->textField($model,'quantity',array( 'class'=>'form-control')); ?>
					</div>
				</div> -->
				<?php $currencies = Currency::model()->findAll();?>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('currency_id'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<select id="country_id" class="form-control select2me">
								 <?php 
								 $selected = "";
								 foreach($currencies as $currency)
								 { 
								 	if($currency->id  == $model->currency_id)
								 	{
								 		$selected = "selected = 'selected'";
								 	}
								 ?>
								 	<option  value="<?php echo $currency->id; ?>"  <?php echo $selected;?>><?php echo $currency->code; ?></option>
								 <?php 
								 }
								 ?>
							  	</select>
					</div>
				</div>
				<div id="sun">
                                    <?php 
                                    $readonlyFlag = '';
                                    if($mode == 'edit'){
                                        $readonlyFlag = 'readonly';
                                    }
                                    ?>
                                <div class="form-group">
					<label class="control-label col-md-3">
						<?php echo "Price"; //$model->getAttributeLabel('default_discount_price'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'default_discount_price',array( 'class'=>'form-control','id'=>'sundisval','readonly'=>$readonlyFlag)); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo "RAC Price"; //$model->getAttributeLabel('default_price'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'default_price',array( 'class'=>'form-control' ,'id'=>'sunval')); ?>
					</div>
				</div>				
				</div>
				<div id="night">
                                <div class="form-group">
					<label class="control-label col-md-3">
						<?php echo "Night Price"; //$model->getAttributeLabel('default_discount_night_price'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'default_discount_night_price',array( 'class'=>'form-control','id'=>'nightdisval')); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo "Night RAC Price"; //$model->getAttributeLabel('default_night_price'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php echo $form->textField($model,'default_night_price',array( 'class'=>'form-control','id'=>'nightval')); ?>
					</div>
				</div>				
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('available_from'); ?><span class="required"> * </span>
					</label>
					
					<div class="col-md-7">
					<?php if(isset($model->available_from)){?> <input type="hidden" value="<?php echo $model->available_from;?>" id="availablefrom"><?php } ?>
						<select name="Room[available_from]" id="availablefrombox" class="form-control select2me">
						<?php 
						$selected = "";
						for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
    						for($mins=0; $mins<60; $mins+=30){
    						$selected = "";
							$time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
							if(isset($model->available_from)){
								$pieces = explode(":", $time);
								if($pieces[0] <10)
								{
									$maintime = "0".$time.":00";
								}else {
									$maintime = $time.":00";
								}
								if($maintime == $model->available_from)
								{
									$selected = ' selected="selected"';
								}	
							}
							
							echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
						}
					}					 // the interval for mins is '30'
			?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('available_till'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
					<select name="Room[available_till]" id="availabletillbox" class="form-control select2me">
					<?php 
						$selected = "";
						for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
    						for($mins=0; $mins<60; $mins+=30){
    						$selected = "";
							$time = str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
							if(isset($model->available_till)){
								$pieces = explode(":", $time);
								if($pieces[0] <10)
								{
									$maintime = "0".$time.":00";
								}else {
									$maintime = $time.":00";
								}
								if($maintime == $model->available_till)
								{
									$selected = ' selected="selected"';
								}	
							}
							
							echo '<option value="'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
						}
					}					 // the interval for mins is '30'
			?>
						</select>
						<span class="help-block" id="availableboxerror" style="display: none;">* Available from and Available till cannot be same or lesser</span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('exhausted_status'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php //echo $form->textField($model,'exhausted_status',array( 'class'=>'form-control')); ?>
						<?php 

						if($model->exhausted_status == 'closed'){
							$model->exhausted_status = 'closed';
						}else{
							$model->exhausted_status = 'request';
						}
						 echo ZHtml::enumDropDownList( $model,'exhausted_status',array("class"=>"form-control select2me")); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">
						<?php echo $model->getAttributeLabel('cc_required'); ?><span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<?php //echo $form->textField($model,'exhausted_status',array( 'class'=>'form-control')); ?>
						<?php echo $form->DropDownList( $model,'cc_required',array('0'=>"No",'1'=>'Yes'),array("class"=>"form-control select2me")); ?>
					</div>
				</div>
				<div class="form-group">
					<table class="roomAvailability">
					<tr>
						<td>&nbsp;</td>
						<?php 
						foreach ($dayname as $ky=>$dname):
						?>
						<td><?php echo $dname;?></td>
						<?php 
						endforeach;
						?>
						<td>All</td>
					</tr>
					<?php 
					// Dont worry about the c,n,nw they are used to give the checkbox unique identifier 
					$c=0;
					foreach ($room_status as $rky=>$rmstat):
					$c++;
					?>
					<tr>
						<td><?php echo $rmstat;?></td>
						<?php
						//$n = 0;
						foreach ($dayname as $ky=>$dname):
						/*$n++;
						$nw = (10*$c)+$n;	

						// Check if the Sun (exp) is available for any status array
						$cn = 0;
						foreach ($room_status as $ky=>$rstat)
						{
							if(in_array($dname, $$ky))
							{
								$cn =1;
								break;
							}							
						}
						if($cn == 1)
						{
							$addin = (in_array($dname, $$rky))? "checked" : "disabled='diabled'";
						}
						else
							$addin ="";
						*/
						$addin = (in_array($dname, $$rky))? "checked" : "";
						?>
						<td><input type="radio" style="margin-left: 0;" <?php echo $addin;?> name="roomst[<?php echo $dname;?>]" id="<?php echo $dname;?>" value="<?php echo $rky;?>"></td>
						<?php 
						endforeach;
						?>
						<td><input type="radio" style="margin-left: 0;" id="all_stat" class="all_stat" type="checkbox" name="all_stat" value=""></td>
					</tr>
					<?php 
					endforeach;
					?>
					<tr>
						<td>Qty</td>
						<?php 
						foreach ($dayname as $ky=>$dname):
						
						$dval =0;
						if(count($$dname))
						{
							foreach ($$dname as $d=>$val)
								$dval = $val;
						}
						?>
						<td><input type="textbox" class="dvalid textQty" name="room_no[<?php echo $dname;?>]" id="room_no_<?php echo $dname;?>" maxlength="5" value="<?php echo $dval;?>"></td>
						<?php 
						endforeach;
						?>
						<td><input type="textbox" class="dvalid2 textQty" name="all_qty" id="all_qty" maxlength="5" value=""></td>
					</table>
				</div>
				<?php $getlanguage = Language::model()->findAll();?>
				<?php 
					$c=1;
					foreach($getlanguage as $languages){
					if(isset($model->id))
					{
						$getroomcontent = RoomInfo::model()->findByAttributes(array('language_id'=>$languages->id, 'room_id'=>$model->id));
					}else {
						$getroomcontent = new RoomInfo;
					}
					?>
					<h3 style="margin-left:70px;"><?php echo $languages->code. " : ";?></h3>
				
						<input type="hidden" name="RoomInfo[<?php echo $languages->id;?>][language_id]" value="<?php echo $languages->id;?>"/> 
						<div class="form-group">
						<label class="control-label col-md-3">
						<?php echo Yii::t('translation','Room Name');?>
						</label>
						<div class="col-md-7">
						<textarea class="form-control rmname" id="roomname-<?php echo $c;?>" name="RoomInfo[<?php echo $languages->id;?>][name]"><?php if(isset($getroomcontent->name)){ if($getroomcontent->name == ""){ echo $model->name; }else{ echo $getroomcontent->name;} }else{ echo $model->name;}?></textarea>
						</div>
						</div>
						
						<div class="form-group">
						<label class="control-label col-md-3">
						<?php echo Yii::t('translation','Room Condition');?>
						</label>
						<div class="col-md-7">
						<textarea style="height: 100px;" class="form-control" name="RoomInfo[<?php echo $languages->id;?>][room_condition]" ><?php if(isset($getroomcontent->room_condition)){ if($getroomcontent->room_condition == ""){ echo Yii::t('translation','room_conditon_value'); }else{  echo $getroomcontent->room_condition; } }else{echo Yii::t('translation','room_conditon_value');}?></textarea>
						</div>
						</div>
				
				<?php $c++; } ?>
				<h3 style="margin-left:70px;">Option : </h3>
				<?php 
				
				$defaultOptions = Equipment::model()->findAllByAttributes(array('hotel_id'=>0, 'type'=>'room', 'base_type'=> 1));
				$roomOptions = Equipment::model()->findAllByAttributes(array('hotel_id'=>$hid, 'type'=>'room', 'base_type'=> 1));
				?>
				<?php 
				if(isset($roomOptions) || isset($defaultOptions)){?>
					<h5 style="margin-left:80px;">Default Options : </h5>
					<?php foreach ($defaultOptions as $defaultOpt){
						if(isset($room_id)){
							$roomOptionDefault = RoomOptions::model()->findByAttributes(array('room_id'=>$room_id, 'equipment_id'=>$defaultOpt->id));
						}
						?>
							<div class="form-group">
								<label class="control-label col-md-9 padding-left15" style="width:70%;text-align:left;padding-left: 90px;">
									<input type="checkbox" del-id="<?php if(isset($roomOptionDefault)){echo $roomOptionDefault->id;}?>" name="check_list[<?php echo $defaultOpt->id;?>]" value="<?php echo $defaultOpt->id;?>" <?php if(isset($roomOptionDefault)){echo "checked";}?> >
										<label><?php echo $defaultOpt->name;?><?php if($defaultOpt->cc_required == 1){echo " (cc required)";}?></label>
								</label>
								<div class="col-md-3 form-inline" style="width:10%;height:30px;">											
									<input type="text" class="form-control mandprice margin-right15" style="width: 100px;" id="currency" name="check_price[<?php echo $defaultOpt->id;?>]" value="<?php if(isset($roomOptionDefault)){echo $roomOptionDefault->price;}else{ echo $defaultOpt->default_price;}?>"/>&nbsp;
								</div>
								<div class="col-md-3 form-inline" style="width:20%;height:30px;">
									<?php $allCurrencies = Currency::model()->findAll(array('order' => 'id ASC')); ?>
									<select name="check_currency[<?php echo $defaultOpt->id;?>]" class="form-control select2me">
										<option value="">Select currency</option>
										<?php foreach ($allCurrencies as $currency) {?>
											<option value="<?php echo $currency->id; ?>" <?php echo $roomOptionDefault && $roomOptionDefault->currency_id ==  $currency->id ? "selected" : "" ?>><?php echo $currency->code; ?></option>	
										<?php }?>
									</select>
								</div>
							</div>
					<?php } ?>
					<h5 style="margin-left:80px;">Hotel Options : </h5>
					<?php foreach ($roomOptions as $hotelOpt){
						if(isset($room_id)){
							$roomOptionDefault2 = RoomOptions::model()->findByAttributes(array('room_id'=>$room_id, 'equipment_id'=>$hotelOpt->id));
						}
						?>
							<div class="form-group">
								<label class="control-label col-md-9 padding-left15" style="width:70%;text-align:left;padding-left: 90px;">
									<input type="checkbox" del-id="<?php if(isset($roomOptionDefault2)){echo $roomOptionDefault2->id;}?>" name="check_list[<?php echo $hotelOpt->id;?>]" value="<?php echo $hotelOpt->id;?>" <?php if(isset($roomOptionDefault2)){echo "checked";}?> >
										<label><?php echo $hotelOpt->name;?><?php if($hotelOpt->cc_required == 1){echo " (cc required)";}?></label>
								</label>
								<div class="col-md-3 form-inline" style="width:10%;height:30px;">											
									<input type="text" class="form-control mandprice margin-right15" style="width: 100px;" id="currency" name="check_price[<?php echo $hotelOpt->id;?>]" value="<?php if(isset($roomOptionDefault2)){echo $roomOptionDefault2->price;}else{ echo $hotelOpt->default_price;}?>"/>&nbsp;
								</div>
								<div class="col-md-3 form-inline" style="width:20%;height:30px;">
									<?php $allCurrencies = Currency::model()->findAll(array('order' => 'id ASC')); ?>
									<select name="check_currency[<?php echo $hotelOpt->id;?>]" class="form-control select2me">
										<option value="">Select currency</option>
										<?php foreach ($allCurrencies as $currency) {?>
											<option value="<?php echo $currency->id; ?>" <?php echo $roomOptionDefault2 && $roomOptionDefault2->currency_id ==  $currency->id ? "selected" : "" ?>><?php echo $currency->code; ?></option>	
										<?php }?>
									</select>
								</div>
							</div>
					<?php } ?>
				<?php } else {
					echo "No Options Available";
				} ?>
				<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" id="datasubmit" class="btn green">Submit</button>
					<a class="btn default" href="index?hotel_id=<?php echo Yii::app()->session['hotel_id'];?>&type=room">Cancel</a>
				</div>
			</div>
			
		<?php $this->endWidget(); ?>
	</div>
</div>
</div>
<script>
$(document).ready(function(){
	$('#Room_name').change(function(){
		var roomname =  $('#Room_name').val();
		for(var i=1 ; i<=10; i++)
		{
			
			$('#roomname-'+i).val(roomname);
		}
	});
		$('#datasubmit').click(function(){
			var frombox = $('#availablefrombox').val();
			var from = frombox.split(':');

			var tillbox = $('#availabletillbox').val();
			var till = tillbox.split(':');
			var from0 = parseInt(from[0])
			var till0 = parseInt(till[0])
			var from1 = parseInt(from[1])
			var till1 = parseInt(till[1])
			if(from0 >= till0)
			{
				if(from1 >= till1)
				{
					$('#availablefrombox').parent().addClass("has-error");
					$('#availabletillbox').parent().addClass("has-error");
					$('#availableboxerror').show();
					return false;
				}
			}
			});
		$('#availablefrombox').change(function(){
			$('#availablefrombox').parent().removeClass("has-error");
			$('#availabletillbox').parent().removeClass("has-error");
			$('#availableboxerror').hide();
			});
		$('#availabletillbox').change(function(){
			$('#availablefrombox').parent().removeClass("has-error");
			$('#availabletillbox').parent().removeClass("has-error");
			$('#availableboxerror').hide();
			});
	});
</script>
<div class="row">
	<div class="col-md-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'room-grid',
	'dataProvider'=>$model1->search(),
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
		//'idJob',
		array(
			'name'=>Yii::t('translation', 'Name'),
			'header'=>'<span style="white-space: nowrap;">Name &nbsp; &nbsp; &nbsp;</span>',
			'value'=>'$data->name',
		),
		array(
					'name'=>Yii::t('translation', 'Category'),
					'value'=>array($this, 'getCategoryName'),
			),
		array(
					'name'=>Yii::t('translation', 'Time Slot'),
					'value'=>array($this, 'getslot'),
					'htmlOptions'=>array('width'=>'14%'),
			),
		array(
					'name'=>Yii::t('translation', 'Price'),
					'value'=>array($this, 'getprice'),
					//'htmlOptions'=>array('width'=>'14%'),
			),		
		array(
					'name'=>Yii::t('translation', 'Status'),
					'value'=>'($data->status == 1) ? Yii::t(\'translation\', \'Active\') : Yii::t(\'translation\', \'Inactive\')',
			),
		array( 
			'class'=>'CButtonColumn',
			'template'=>'{Edit}',
			'htmlOptions'=>array('width'=>'10%'),
			'buttons'=>array(
				'Edit' => array(
					'label'=>'Edit',
					'options'=>array('class'=>'btn purple fa fa-edit margin-right15'),
					'url'=>'Yii::app()->createUrl("admin/room/update", array("id"=>$data->id,"hid"=>$data->hotel_id))',
				),
				'Delete' => array(
					'label'=>'Change Status',
					'options'=>array('class'=>'fa fa-success btn default black delete'),
					'url'=>'Yii::app()->createUrl("admin/room/delete", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
			</div>
			</div>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-room.js?ver=<?php echo strtotime("now");?>"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
var url =  "<?php echo Yii::app()->createUrl('admin/room/saveroominfoprice'); ?>";
$( window ).load(function() {
	 var valueload =	$('#categoryc').val();
	 if(valueload == "sun" || valueload == "halfsun" )
		{
			$('#sun').show();
			$('#night').hide();
			$('#nightval').val("0");
			$('#nightdisval').val("0");
		}else
		{
			$('#sun').hide();
			$('#night').show();
			$('#sunval').val("0");
			$('#sundisval').val("0");
		}
	});
$(document).ready(function(){
	var posturl =  "<?php echo Yii::app()->createUrl('admin/room/deloptions'); ?>";
	$('#form_sample_3_room').submit(function(){
			$('.mandprice').each(function(){
					if($(this).val() == "")
					{
						$(this).parent().parent().addClass("has-error");
						return false;
						exit;
					}
				});
		});
	$('#categoryc').change(function(){
		var thisvalue = $(this).val() ;
		if(thisvalue == "sun" || thisvalue == "halfsun" )
		{
			$('#sun').show();
			$('#night').hide();
			$('#nightval').val("0");
			$('#nightdisval').val("0");
			
		}else
		{
			$('#sun').hide();
			$('#night').show();
			$('#sunval').val("0");
			$('#sundisval').val("0");
		}
	});
	$('.checked input').click(function(){
			var prime = $(this).attr("del-id");
			if(prime !=""){
				$.ajax({
					type: "POST",
					url: posturl,
					data: { prime: prime},
					success: function(result){
								
						}
					});	
				}
			
		});
	$("#currency").keypress(function (e) {
	    //if the letter is not digit then display error and don't type anything
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	       //display error message
	      // $("#errmsgfp").html(DigitsOnly).show().fadeOut("slow");
	              return false;
	   }
	  });
});
</script>