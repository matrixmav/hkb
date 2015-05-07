<?php
/* @var $this AreaController */
/* @var $model Area */

$this->breadcrumbs=array(
	'Areas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Area', 'url'=>array('index')),
	array('label'=>'Manage Area', 'url'=>array('admin')),
);
?>
<?php //$this->renderPartial('_form', array('model'=>$model)); ?>
<style>
    #hiddendrop ul{position: absolute;z-index: 1;background: #fff;width: 579px;box-sizing: border-box;list-style-type: none;padding: 0px;margin: -1px 0 0 7px;border: 1px solid #999999;border-top:0;}
    #hiddendrop ul li{padding: 8px 0 8px 15px;}
    #hiddendrop ul li a{color:#333;cursor:pointer;}
    #hiddendrop ul li a:hover{text-decoration: none; }
    #hiddendrop ul li:nth-child(odd){background: #fafafa;}
</style>
<?php
$this->breadcrumbs = array(
    'Area' => array('/admin/area'),
    'Area'
);
$curController = @Yii::app()->controller->id;
$curAction = @Yii::app()->getController()->getAction()->controller->action->id;
require_once Yii::getPathOfAlias('application.modules.admin.views.layouts') . '/formassets.php';
?>
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-reorder"></i><?php echo ucwords($curAction); ?> <?php echo ucwords($curController); ?>
        </div>
        <div class="tools">
            <a href="javascript:;" class="collapse">
            </a>
        </div>
    </div>
    <div class="portlet-body form">
        <?php echo CHtml::beginForm(); ?>		
        <div class="form-body">
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                You have some form errors. Please check below.
            </div>
            <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button>
                Your form validation is successful!
            </div>

            <?php if(isset($_GET['id'])){
            	$area = Area::model()->findByPk($_GET['id']);            	
            }?>
            <div class="row form-group">
                <label class="control-label col-md-3">
						Name<span class="required"> * </span>
					</label>
					<div class="col-md-7">
						<input class="form-control" type="text" maxlength="150" name='name' value = "<?php if(isset($_GET['id'])){echo $area->name;}else{echo '';}?>" required>	
					</div>
            </div>




            <div class="row form-group">
                <label class="control-label col-md-3">
                    Country
                </label>
                <div class="col-md-7">
                    
                        <select id="country_id" name='State[country_id]' class="form-control select2me">
                            <?php

                            foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['name'])."</option>";
                                endforeach;

                            ?>
                    </select>
                </div>
            </div>



            
        </div>

        <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">Submit</button>
                <a class="btn default" href="/admin/area">Cancel</a>
            </div>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>


<div class='showMe' style='display: none;'>
	<div class="portlet box green">
	    <div class="portlet-title">
	        <div class="caption">
	            <i class="fa fa-reorder"></i> Add City
	        </div>
	        <div class="tools">
	            <a href="javascript:;" class="collapse">
	            </a>
	        </div>
	    </div>
	    <div class="portlet-body form">

<?php 
	if (isset($_GET['id'])) {
	
$idCity = $_GET['id'];
}else{
	$idCity = 1;
}
?>
	<?php echo CHtml::beginForm(); ?>


	<div class="form-body" id='form2'>
	            <div class="alert alert-danger display-hide">
	                <button class="close" data-close="alert"></button>
	                You have some form errors. Please check below.
	            </div>
	            <div class="alert alert-success display-hide">
	                <button class="close" data-close="alert"></button>
	                Your form validation is successful!
	            </div>
	            <input type='hidden' name='name' value=''>
		<div class="form-group">
	                <label class="control-label col-md-3">City</label>
	                <div class="col-md-7">
	                    	<select class="form-control" name='cityId'>
	                    		<?php 
	                    			$cityList = City::model()->findAll();
	                    			foreach($cityList as $city){
	                    				echo '<option value = '.$city->id.'>'.$city->name.'</option>';

	                    			}
	                    		?>
	                    		
	                    	</select>
	                    	<input type='hidden' value='<?php echo $idCity;?>' name='areaId'>
	                </div><button type="submit" class="btn green" id='creatCity'>Add</button>
                    <?php echo CHtml::submitButton('Remove', array('name' => 'button2', 'class'=>'btn green')); ?>
	                <div class="form-group noMargin">
	                    <label class="control-label col-md-3 nopadding"></label>
	                    <div id="hiddendrop" class="col-md-7" style="display:none;"></div>                                  
	                </div>
                    
	     </div>
	</div>
	</div>
	</div>
	<?php echo CHtml::endForm(); ?>
</div>



<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/form-validation-area.js?ver=<?php echo strtotime("now"); ?>"></script>
<!-- END PAGE LEVEL STYLES -->
<script type="text/javascript">
    var transDigits = "<?php echo Yii::t('translation', 'Digits Only'); ?>";
    jQuery(document).ready(function () {
        //ComponentsDropdowns.init();	

        $('#slectbox').keyup(function () {

            var citylike = $(this).val();
            var countryid = $('#country_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('admin/area/citydrop'); ?>",
                data: {citylike: citylike, countryid: countryid},
                success: function (result) {
                    $('#hiddendrop').show();
                    $('#hiddendrop').html(result);
                    //ComponentsDropdowns.init();
                    cityanchor();
                }
            });

        });

        function cityanchor()
        {
            $('.anchorcls').click(function () {
                $('#cityid').val($(this).attr("id"));
                $('#slectbox').val($(this).text());
                $('#hiddendrop').hide();
            });
        }

        var showForm = <?php if(isset($_GET['id'])){echo 1;}else{echo 2;}?> ;
        if(showForm==1){
        	$('.showMe').css('display', 'block');
        }


    });
</script>